<?php
loginRequired();

// Edit record
if (isset($_POST['edit_record'])) {
  if (!valid($tableName = $_POST['table'])) die('Invalid table name');
  $id = (int)$_POST['id'];
  $table = new Table($tableName);
  $record = $table->getRecord($id);
  foreach($record->data as $columnName => $value) {
    $record->data[$columnName] = $_POST['column_'.$columnName];
  }
  $record->save();

  redirect('/?page=view_table&table=' . $tableName);
}

// Form
if (!valid($table = $_GET['table'])) die('Invalid table name');
$id = (int)$_GET['id'];
$table = new Table($table);
$record = $table->getRecord($id);
$columnRows = '';
foreach ($record->columns as $column) {
  $columnRows .= sprintf(
    '<tr><td>%s</td><td><input type="%s" name="column_%s" value="%s"></td></tr>' . PHP_EOL,
    $column->display_name,
    $column->type,
    $column->name,
    $record->data[$column->name]
  );
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
