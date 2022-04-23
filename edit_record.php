<?php
loginRequired();

// Edit record
if (isset($_POST['edit_record'])) {
  if (!valid($table = $_POST['table'])) die('Invalid table name');
  $id = $_POST['id'];
  if ($id == 'new') $new = true;

  // Build columns and values arrays
  foreach ($_POST as $name => $value) {
    if (substr($name, 0, 7) == 'column_') {
      if (!valid($name)) die('Invalid column name');
      $column = substr($name, 7);
      if ($column == 'id') continue;
      $columns[] = $column;
      $values[] = $value;
    }
  }

  if ($new) {
    // Build/execute insert query
    $sql = "INSERT INTO `$table` (" . join(', ', $columns) . ') VALUES (' . join(', ', array_fill(0, count($values), '?')) . ')';
    $sth = $dbh->prepare($sql);
    $sth->execute($values);
  } else {
    // Build/execute update query
    $sql = "UPDATE `$table` SET " . join(' = ?, ', $columns) . ' = ? WHERE id = ?';
    $sth = $dbh->prepare($sql);
    $params = array_merge($values, [$id]);
    $sth->execute($params);
  }
  redirect('/?page=view_table&table=' . $table);
}

// Form
if (!valid($table = $_GET['table'])) die('Invalid table name');
$id = $_GET['id'];
$table = new Table($table);
$columnRows = '';
foreach ($table->columns as $column) {
  $columnRows .= "<tr>" .
    "<td>$column->display_name</td>" .
    "<td><input type=\"$column->type\" name=\"column_$column->name\" value=\"\"></td>" .
    "</tr>\n";
}
?>
<h1><?php echo "$table->name - $id"; ?></h1>
<form method="POST">
  <input type="hidden" name="table" value="<?php echo $table->name; ?>">
  <input type="hidden" name="id" value="<?php echo $id; ?>">
  <table>
    <?php echo $columnRows; ?>
    <tr>
      <td></td>
      <td><input type="submit" name="edit_record" value="Save"></td>
    </tr>
  </table>

</form>
