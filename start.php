<?php

require_once("lib/storage.php");
require_once("lib/auth.php");
session_start();

$comments = new Storage(new JsonIO("data/comments.json"));
$teams = new Storage(new JsonIO("data/teams.json"));
$matches = new Storage(new JsonIO("data/matches.json"));
/*
id => [
    from: neptun
    to: neptun
    content: szöveg
]
*/

$auth = new Auth(new Storage(new JsonIO("data/users.json")));