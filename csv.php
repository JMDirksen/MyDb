<?php

require 'init.php';
loginRequired();

// Start memory file
$fp = fopen('php://temp', 'r+');

// Header
$table = new Table($_GET['table']);
$columns = explode(',', $_GET['columns']);
$header = array_merge(['id'], $columns);
fputcsv($fp, $header);

// Data
$rs = new Recordset($table->name, $columns);
foreach ($rs->records as $record) {
    fputcsv($fp, array_merge([$record->id], $record->data));
}

// Output
if (isset($_GET['show'])) header('Content-Type: text/plain');
else {
    header('Content-Type: text/csv');
    header(sprintf('Content-Disposition: attachment; filename=export-%s.csv', $table->name));
}
rewind($fp);
echo stream_get_contents($fp);
