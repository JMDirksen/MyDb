<?php
loginRequired();

if (!valid($table = $_GET['t'])) die("Invalid table name");

// Header
echo "<h1>$table</h1>\n";
echo "<a href=\"?p=edit_record&new&t=$table\">Add</a>\n";
echo "<table>\n";
echo "<tr><th></th>";

// Columns
$sth = $dbh->prepare("SHOW COLUMNS FROM $table");
if ($sth->execute() === false) die(dump($sth->errorInfo()));
$columns = $sth->fetchAll(PDO::FETCH_ASSOC);
foreach ($columns as $column) {
  echo "<th>$column[Field]</th>";
}
echo "</tr>\n";

// Rows
$sth = $dbh->prepare("SELECT * FROM $table");
if ($sth->execute() === false) die(dump($sth->errorInfo()));
$result = $sth->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
  echo "<tr><td>";
  echo "<a href=\"?p=edit_record&t=$table&id=$row[id]\">E</a> ";
  echo "<a href=\"action.php?a=d&t=$table&id=$row[id]\" onClick=\"return confirm('Delete record $row[id]?')\">X</a>";
  echo "</td>";
  foreach ($row as $v) {
    echo "<td>$v</td>";
  }
  echo "</tr>\n";
}

echo "</table>\n";
