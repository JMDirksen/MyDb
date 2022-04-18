<?php
loginRequired();

if (!valid($table = $_GET['t'])) die("Invalid table name");

// Header
echo "<h1>$table</h1>";
echo "<table>\n";
echo "<tr><th></th>";

// Columns
$sth = $dbh->prepare("SHOW COLUMNS FROM $table");
if ($sth->execute() === false) die(dump($sth->errorInfo()));
$columns = $sth->fetchAll(PDO::FETCH_ASSOC);
foreach ($columns as $column) {
  echo "<th>$column[Field]</th>";
}
echo "</tr>";

// Rows
$sth = $dbh->prepare("SELECT * FROM $table");
if ($sth->execute() === false) die(dump($sth->errorInfo()));
$result = $sth->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
  echo "<tr><td><a href=\"?p=edit_record&t=$table&id=$row[id]\">E</a> <a href=\"action.php?a=d&t=$table&id=?\">X</a></td>";
  foreach ($row as $v) {
    echo "<td>$v</td>";
  }
  echo "</tr>\n";
}

echo "</table>\n";
