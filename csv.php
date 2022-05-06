<?php

require 'init.php';
loginRequired();
$table = new Table($_GET['table']);
$columns = 'id,' . $_GET['columns'];

//header('Content-Type: text/csv');
//header(sprintf('Content-Disposition: attachment; filename=export-%s.csv', $table->name));

echo $columns . PHP_EOL;
