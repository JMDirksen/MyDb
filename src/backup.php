<?php

namespace MyDb;

require 'init.php';
loginRequired('admin');

$fileName = sprintf(
    '%s-%s.sql.gz',
    DB_NAME,
    date('Y-m-d-H-i-s'),
);

$cmd = sprintf(
    'mariadb-dump --opt -h %s -u %s -p%s %s | gzip',
    DB_HOST,
    DB_USER,
    DB_PASS,
    DB_NAME,
);

header('Content-Type: application/gzip');
header(sprintf('Content-Disposition: attachment; filename=%s', $fileName));

passthru($cmd);
