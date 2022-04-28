<?php

require_once("start.php");

function letezik($p){
    return isset($_GET[$p]) && strlen(trim($_GET[$p]))>0;
}

if(count($_GET)<1){
    header("Location: loginform.php");
    die();
}

if(!letezik("username")){
    header("Location: loginform.php?error=Nincs+felhasználónév");
    die();
}

if(!letezik("password")){
    header("Location: loginform.php?error=Nincs+jelszó");
    die();
}

$user_login = $auth -> authenticate($_GET["username"], $_GET["password"]);

if($user_login){
    $auth->login($user_login);
    header("Location: index.php");
}else{
    header("Location: loginform.php?error=Rossz+felhasználónév+vagy+jelszó");
    die();
}

