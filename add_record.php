<?php
loginRequired();

// Add record
if (isset($_POST['add_record'])) {
  if (!valid($table = $_POST['table'])) die('Invalid table name');

  // Build columns and values arrays
  foreach ($_POST as $name => $value) {
    if (substr($name, 0, 7) == 'column_') {
      $column = substr($name, 7);
      if (!valid($column)) die('Invalid column name');
      $columns[] = $column;
      $values[] = $value;
    }
  }

  // Build/execute insert query
  $sql = "INSERT INTO `$table` (" . join(', ', $columns) . ') ' .
    'VALUES (' . join(', ', array_fill(0, count($values), '?')) . ')';
  $sth = $dbh->prepare($sql);
  $sth->execute($values);
  redirect('/?page=view_table&table=' . $table);
}

// Form
if (!valid($table = $_GET['table'])) die('Invalid table name');
$sth = $dbh->prepare('SELECT * FROM `s_column` WHERE `table` = ?');
$sth->execute([$table]);
$columns = $sth->fetchAll(PDO::FETCH_ASSOC);
$columnRows = '';
foreach ($columns as $column) {
  $columnRows .= "<tr>" .
    "<td>$column[display_name]</td>" .
    "<td><input type=\"$column[type]\" name=\"column_$column[name]\"></td>" .
    "</tr>\n";
}
?>
<h1><?php echo $table; ?> - add</h1>
<form method="POST">
  <input type="hidden" name="table" value="<?php echo $table; ?>">
  <table>
    <?php echo $columnRows; ?>
    <tr>
      <td></td>
      <td><input type="submit" name="add_record" value="Save"></td>
    </tr>
  </table>
</form>
