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
  redirect('/?page=view_table&table='.$table);
}

// Form
if (!valid($table = $_GET['table'])) die('Invalid table name');
if (isset($_GET['new'])) {
  $new = true;
  $id = 'new';
} else {
  $new = false;
  $id = $_GET['id'];
}
echo "<h1>$table - $id</h1>";
?>
<form method="POST">
  <input type="hidden" name="table" value="<?php echo $table; ?>">
  <input type="hidden" name="id" value="<?php echo $id; ?>">
  <table>
    <?php
    if ($new) {
      $sth = $dbh->prepare("SHOW COLUMNS FROM `$table`");
      $sth->execute();
      $columns = $sth->fetchAll(PDO::FETCH_ASSOC);
      foreach ($columns as $column) $row[$column['Field']] = '';
    } else {
      $sth = $dbh->prepare("SELECT * FROM `$table` WHERE id = ?");
      $sth->execute([$id]);
      $row = $sth->fetch(PDO::FETCH_ASSOC);
    }
    foreach ($row as $name => $value) {
      if ($name == 'id') continue;
      echo "<tr>\n";
      echo "<td>$name</td>\n";
      echo "<td><input type=\"text\" name=\"column_$name\" value=\"$value\"></td>\n";
      echo "</tr>\n";
    }
    ?>
    <tr>
      <td></td>
      <td><input type="submit" name="edit_record" value="Save"></td>
    </tr>
  </table>

</form>
