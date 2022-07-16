<?php

namespace MyDb;

use \PDO, \PDOException;

ob_start();
session_start();
require 'config.php';
require 'functions.php';

// Auto load classes
spl_autoload_extensions('.php');
spl_autoload_register(function ($class) {
    include str_replace('\\', '/', $class) . '.php';
});

ini_set('allow_url_fopen', 0);

try {
    $dbh = new PDO(DB_DSN, DB_USER, DB_PASS);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}

// Check database
if (!count($dbh->query('SHOW TABLES')->fetchAll())) {
    $dbh->exec(file_get_contents('init.sql'));
}
