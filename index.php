<?php

require_once("start.php");
$a = "Bejelentkezés";
if ($auth->is_authenticated()) {
  $a = $auth->authenticated_user()["username"];
}

$all_team = $teams->findAll();
//var_dump($all_team);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
  <title>Listaoldal</title>
</head>

<body>

  <div class="container">
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
    <div class="row mb-2">
      <div class="col">

        <h1>Eötvös Loránd Stadion</h1>
        <div>
          Az Eötvös Loránd Stadionban játszott mecsek adatait találja meg az

          alábbi oldalon. Csapatokat is megtekintheti és akár kommenteket is
          írhat az egyes mecsekhez. Kellemes böngészést.
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-6">
        <h2>Csapatok</h2>
        <div class="list-group">
          <?php foreach ($all_team as $team) : ?>
            <a href="teamdetails.php?team=<?= $team["id"] ?>" class="list-group-item list-group-item-action"><?= $team["name"] ?></a>
          <?php endforeach ?>

          <!--
          <a href="csapatrészletek.html" class="list-group-item list-group-item-action list-group-item-warning">Kedvenc csapat</a>
          -->
        </div>
      </div>
      <div class="col-6">
        <h2>legutóbbi 5 meccs</h2>
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
            <?php
            $szam = 0;
            foreach ($matches->findAll() as $match) :
              $szam++; ?>
              <tr>
                <td scope="row"><?= $teams->findById($match["home"]["id"])["name"] ?></td>
                <td>

                  <?php if ($match["home"]["score"] !== "nan") : ?>
                    <?= $match["home"]["score"] ?> - <?= $match["away"]["score"] ?>

                  <?php endif ?>
                </td>

                <td><?= $teams->findById($match["away"]["id"])["name"] ?></td>
                <td><?= $match["date"] ?></td>
              </tr>
            <?php
              if ($szam > 4) {
                break;
              }
            endforeach ?>
          </tbody>
        </table>
        <div class="d-grid col-6 mx-auto">
          <button type="button" class="btn btn-outline-secondary btn-sm">
            Small button
          </button>
        </div>
      </div>
    </div>
  </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</html>