<?php

session_start();
require 'config.php';
require 'functions.php';

// Auto load classes
spl_autoload_register(function ($class) {
  if (is_readable($filename = 'class.' . strtolower($class) . '.php')) require_once $filename;
  elseif (is_readable($filename = "FormFramework/$class.php")) require_once $filename;
});

ini_set('allow_url_fopen', 0);

if (DEBUG) {
  ini_set('error_reporting', E_ALL);
  ini_set('display_errors', 1);
}

try {
  $dbh = new PDO(DB_DSN, DB_USER, DB_PASS);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo 'Connection failed: ' . $e->getMessage();
}
