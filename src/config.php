<?php

// Database
define('DB_TYPE', 'mysql');
define('DB_HOST', 'mydb-mariadb');
define('DB_NAME', 'mydb');
define('DB_DSN', sprintf('%s:dbname=%s;host=%s', DB_TYPE, DB_NAME, DB_HOST));
define('DB_USER', 'mydb');
define('DB_PASS', 'mydb');

// Debug
define('DEBUG', false);
