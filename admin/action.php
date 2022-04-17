<?php
require("../init.php");

loginRequired();

// Create table
if (isset($_POST['createtable'])) {
  for ($i = 1; $i <= $_POST['columns']; $i++) {
    $name = $_POST['name' . $i];
    $type = str_replace(["text", "number"], ["VARCHAR(255)", "INT"], $_POST['type' . $i]);
    $columns[] = "$name $type";
  }
  $columnsstring = implode(", ", $columns);
  $sql = "CREATE TABLE $_POST[name] ($columnsstring)";
  if ($dbh->exec($sql) === false) die(dump($dbh->errorInfo()));
  redirect("/admin");
}
