<?php 

require_once("start.php");

$a = "Bejelentkezés";
if ($auth->is_authenticated()) {
  $a = $auth->authenticated_user()["username"];
}

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
    <title>Belépés</title>
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
                <form action="login.php" method="get">
                    <span><?= isset($_GET["error"]) ? $_GET["error"] : "" ?></span>
                    <div class="mb-3">
                        <label for="username" class="form-label">Felhasználó név</label>
                        <input type="text" name="username" id="username" maxlength="10" class="form-control"></input>

                    </div>


                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Jelszó</label>
                        <input type="password" name="password" id="password" class="form-control">

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