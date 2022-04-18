<?php
require "../init.php";

loginRequired();

// Create table
if (isset($_POST['createtable'])) {
  if (!valid($table = $_POST['name'])) die("Invalid table name");
  for ($i = 1; $i <= $_POST['columns']; $i++) {
    if (!valid($name = $_POST['name' . $i])) die("Invalid column name");
    $type = str_replace(["text", "number"], ["VARCHAR(255)", "INT"], $_POST['type' . $i]);
    $columns[] = "$name $type";
  }
  $columnsstring = implode(", ", $columns);
  $sql = "CREATE TABLE $table ($columnsstring)";
  if ($dbh->exec($sql) === false) die(dump($dbh->errorInfo()));
  redirect("/admin");
}
