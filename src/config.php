<?php

// Database
define('DB_TYPE', getenv('DB_TYPE') ? getenv('DB_TYPE') : 'mysql');
define('DB_HOST', getenv('DB_HOST') ? getenv('DB_HOST') : 'mydb-mariadb');
define('DB_NAME', getenv('DB_NAME') ? getenv('DB_NAME') : 'mydb');
define('DB_USER', getenv('DB_USER') ? getenv('DB_USER') : 'mydb');
define('DB_PASS', getenv('DB_PASS') ? getenv('DB_PASS') : 'mydb');
define('DB_DSN', sprintf('%s:dbname=%s;host=%s', DB_TYPE, DB_NAME, DB_HOST));
