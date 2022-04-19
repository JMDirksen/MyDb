<?php
loginRequired();

if (!valid($table = $_GET['t'])) die('Invalid table name');

// Delete record
if (isset($_GET['delete'])) {
  $sql = "DELETE FROM `$table` WHERE `id` = ?";
  $sth = $dbh->prepare($sql);
  if (!$sth->execute([$_GET['delete']])) die(dump($sth->errorInfo()));
  redirect("/?p=view_table&t=$table");
}

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
  echo "<a href=\"?p=view_table&t=$table&delete=$row[id]\" onClick=\"return confirm('Delete record $row[id]?')\">X</a>";
  echo "</td>";
  foreach ($row as $v) {
    echo "<td>$v</td>";
  }
  echo "</tr>\n";
}

echo "</table>\n";
