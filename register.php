<?php

require_once("start.php");

$errors = [];
$user = [];

$a = "Bejelentkezés";
if ($auth->is_authenticated()) {
  $a = $auth->authenticated_user()["username"];
}

function letezik($p)
{
    return isset($_GET[$p]) && strlen(trim($_GET[$p])) > 0;
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

function allapottartas($p)
{
    global $user;
    global $errors;
    if (count($errors) > 0 && isset($user[$p])) {
        return $user[$p];
    } else {
        return "";
    }
}


if (count($_GET) > 0) {


    // usernév ellenőrzés
    if (letezik("username")) {
        $username = trim($_GET["username"]);
        if ($auth->user_exists($username)) {
            $errors["username"] = "Foglalt felhasználónév";
        } else {
            $user["username"] = $username;
        }
    } else {
        $errors["username"] = "Nincs felhasználónév!";
    }

    //jelszó1 ellenőrzés
    if (letezik("password")) {
        $password = trim($_GET["password"]);
    } else {
        $errors["password"] = "Nincs jelszó 1!";
    }

    //jelszó2 ellenőrzés
    if (letezik("password2")) {
        $password2 = trim($_GET["password2"]);
    } else {
        $errors["password2"] = "Nincs jelszó 2!";
    }

    //j1 == j2
    if (isset($password) && isset($password2)) {
        if ($password === $password2) {
            $user["password"] = $password;
        } else {
            $errors["password"] = "Jelszavak nem egyeznek!";
            $errors["password2"] = "Jelszavak nem egyeznek!";
        }
    }

    if (letezik("email")) {
        $email = trim($_GET["email"]);

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $user["email"] = $email;
        } else {
            $errors["email"] = "Nem megfelellő formátumú az emailcím";
        }
    } else {
        $errors["email"] = "Nincs Email megadva!";
    }

    if (count($errors) === 0) {
        $auth->register($user);
        $user_login = $auth->authenticate($username, $password);
        if ($user_login) {
            $auth->login($user_login);
            header("Location: main.php");
            die();
        }
    }
}

//var_dump($user)


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <style>
        span {
            margin-left: 1em;
            color: red;
        }
    </style>
    <title>NEPTUN regisztráció | Tanulmányi Hivatal</title>
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
        <div class="row">
            <div class="col-4"></div>
            <div class="col-4">
                <form action="register.php" method="get">
                    <div class="mb-3">
                        <label for="username" class="form-label">Felhasználó név</label>
                        <input type="text" name="username" id="username" maxlength="10" value="<?= allapottartas("username") ?>" class="form-control"></input>
                        <div id="error" class="form-text"><span><?= hibatKiir("username") ?></span></div>
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email cím</label>
                        <input type="text" name="email" id="email" value="<?= allapottartas("email") ?>" class="form-control" aria-describedby="emailHelp">
                        <div id="error" class="form-text"><span><?= hibatKiir("email") ?></span></div>

                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control">
                        <div id="error" class="form-text"><span><?= hibatKiir("password") ?></span></div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password2" id="password2">
                        <div id="error" class="form-text"><span><?= hibatKiir("password2") ?></span></span></div>
                    </div>
                    <button type="submit" class="btn btn-primary">Regisztráció indítása</button>
                </form>
            </div>
            <div class="col-4"></div>

        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>