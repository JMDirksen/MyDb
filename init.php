<?php

session_start();
require 'config.php';
require 'functions.php';

// Auto load classes
spl_autoload_register(function ($class_name) {
  require 'class.' . strtolower($class_name) . '.php';
});

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
