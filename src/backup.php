<?php

namespace MyDb;

require 'init.php';
User::checkLogin('admin');

$fileName = sprintf(
    '%s-%s.sql',
    DB_NAME,
    date('Y-m-d-H-i-s'),
);

$cmd = sprintf(
    'mariadb-dump --opt -h %s -u %s -p%s --add-drop-database -B %s',
    DB_HOST,
    DB_USER,
    DB_PASS,
    DB_NAME,
);

header('Content-Type: application/sql');
header('Content-Disposition: attachment; filename=' . $fileName);

passthru($cmd);
