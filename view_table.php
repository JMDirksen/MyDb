<?php
loginRequired();

if (!valid($table = @$_GET['table'])) die('Invalid table name');

// Delete record
if (isset($_GET['delete'])) {
  $sth = $dbh->prepare("DELETE FROM `$table` WHERE `id` = ?");
  $sth->execute([$_GET['delete']]);
  redirect('/?page=view_table&table=' . $table);
}

// Header
echo "<h1>$table</h1>\n";
echo "<a href=\"?page=edit_record&new&table=$table\">Add</a>\n";
echo "<table>\n";
echo "<tr><th></th>";

// Columns
$sth = $dbh->prepare("SHOW COLUMNS FROM `$table`");
$sth->execute();
$columns = $sth->fetchAll(PDO::FETCH_ASSOC);
foreach ($columns as $column) {
  if ($column['Field'] == 'id') continue;
  echo "<th>$column[Field]</th>";
}
echo "</tr>\n";

// Rows
$sth = $dbh->prepare("SELECT * FROM `$table`");
$sth->execute();
$result = $sth->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
  echo '<tr><td>';
  echo "<a href=\"?page=edit_record&table=$table&id=$row[id]\">E</a> ";
  echo "<a href=\"?page=view_table&table=$table&delete=$row[id]\" onClick=\"return confirm('Delete record $row[id]?')\">X</a>";
  echo '</td>';
  foreach ($row as $key => $value) {
    if ($key == 'id') continue;
    echo "<td>$value</td>";
  }
  echo "</tr>\n";
}

echo "</table>\n";
