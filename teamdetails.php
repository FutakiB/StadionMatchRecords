<?php

require_once("start.php");
//var_dump($_GET);

$is_auth = $auth->is_authenticated();

function disable()
{
  global $auth;
  if (!$auth->is_authenticated()) {
    return "disabled";
  }
  return "";
}

$a = "Bejelentkezés";
if ($auth->is_authenticated()) {
  $a = $auth->authenticated_user()["username"];
}

if (!(isset($_GET["team"]) && strlen(trim($_GET["team"])) > 0)) {
  //header("Location: index.php");
  die();
}

if ($teams->findById($_GET["team"])) {
  $team = $teams->findById($_GET["team"]);
} else {
  //header("Location: index.php");
  die();
}

function filter($t)
{
  global $team;
  if ($t["home"]["id"] == $team["id"] || $t["away"]["id"] == $team["id"]) {
    return true;
  }
  return false;
}

$all_maches = $matches->findMany("filter");
//var_dump($all_maches);
function result($a, $b)
{
  if ($a > $b) {
    return "win";
  }
  if ($a < $b) {
    return "lose";
  }
  if ($a === $b) {
    return "tie";
  }
  return "";
}

$list = [];
foreach ($all_maches as $match) {
  global $list;
  $home = $teams->findById($match["home"]["id"]);
  //var_dump($home["name"]);
  $homes = $match["home"]["score"];
  //var_dump( $match["away"]["id"]);
  $away = $teams->findById($match["away"]["id"]);
  $aways = $match["away"]["score"];
  if ($home["id"] === $team["id"]) {
    $res = result($homes, $aways);
  } else {
    $res = result($aways, $homes);
  }
  $list[] = [

    'home' => $home["name"],
    'homes' => $homes,
    'away' => $away["name"],
    'aways' => $aways,
    "date" => $match["date"],
    "res" => $res
  ];
  //var_dump($list);

}


function letezik($p)
{
  return isset($_POST[$p]) && strlen(trim($_POST[$p])) > 0;
}


function hibatKiir($p)
{
  global $errors;
  if (isset($errors[$p])) {
    return $errors[$p];
  } else {
    return "";
  }
}

$errors = [];
$msg = [];


if (count($_POST) > 0) {

  if (isset($_POST["msg"])) {

    if (strlen(trim($_POST["msg"])) > 0) {

      $msg["content"] = $_POST["msg"];
      $msg["teamid"] = $team["id"];
      $msg["from"] = $auth->authenticated_user()["username"];
      $msg["date"] = date("Y/m/d");
      $comments->add($msg);
    } else {

      $errors["msg"] = "Akomment nem lehet üres!";
    }
  }
}


function kommentf($t)
{
  global $team;
  if ($t["teamid"] == $team["id"]) {
    return true;
  }
  return false;
}


$all_commmetn = $comments->findMany("kommentf");

//var_dump($all_commmetn);


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
  <link rel="stylesheet" href="style.css">

  <title>Csapat</title>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="index">Eötvös Loránd Stadion</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="loginform.php"><?= $a ?></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">Kijelentkezés</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="register.php">Regisztráció</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container">
    <div class="row">
      <div class="col">
        <h1><?= $team["name"] ?></h1>
        <h2>Meccsek</h2>

        <table class="table">
          <thead>
            <tr>
              <th scope="col">Hazai</th>
              <th scope="col">Eredmény</th>
              <th scope="col">Vendég</th>
              <th scope="col">Dátum</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($list as $match) : ?>
              <tr>
                <td scope="row"><?= $match["home"] ?></td>
                <td class="<?= $match["res"] ?>">

                  <?php if ($match["homes"] !== "nan") : ?>
                    <?= $match["homes"] ?> - <?= $match["aways"] ?>

                  <?php endif ?>
                </td>

                <td><?= $match["away"] ?></td>
                <td><?= $match["date"] ?></td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>

      </div>
    </div>

    <div class="row">
      <div class="col">
        <h2>Kommentek</h2>

        <form action novalidate method="POST">
          <div class="mb-3">
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="msg" id="msg" <?= disable() ?>></textarea>
          </div>
          <div id="error" class="form-text"><span><?= hibatKiir("msg") ?></span></span></div>
          <button class="btn btn-primary" type="submit" <?= disable() ?>>Elküld</button>

        </form>

      </div>
    </div>

    <div class="row">
      <div class="col">
        <?php foreach ($all_commmetn as $com) : ?>
          <div><?= $com["from"] ?> </div>
          <div><?= $com["date"] ?> </div>
          <div><?= $com["content"] ?></div>
          <hr />
        <?php endforeach ?>
      </div>
    </div>
  </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</html>