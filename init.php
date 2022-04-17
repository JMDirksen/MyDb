<?php

session_start();
require("config.php");
require("functions.php");

if ($debug) {
    ini_set("error_reporting", E_ALL);
    ini_set("display_errors", 1);
}

$dbh = new PDO($dsn, $db_user, $db_pass);