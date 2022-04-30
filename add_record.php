<?php
loginRequired();

// Add record
if (isset($_POST['add_record'])) {
  if (!valid($tableName = $_POST['table'])) die('Invalid table name');
  $table = new Table($tableName);
  $data = [];
  foreach ($table->columns as $column) {
    if (!isset($_POST['column_' . $column->name])) continue;
    $data[$column->name] = $_POST['column_' . $column->name];
  }
  $record = $table->addRecord($data);

  redirect('/?page=view_table&table=' . $tableName);
}

// Form
if (!valid($table = $_GET['table'])) die('Invalid table name');
$table = new Table($table);
$columnRows = '';
foreach ($table->columns as $column) {
  $columnRows .= sprintf(
    '<tr><td>%s</td><td><input type="%s" name="column_%s" value=""></td></tr>' . PHP_EOL,
    $column->display_name,
    $column->getHtmlType(),
    $column->name,
  );
}
?>
<h1><?php echo $table->name; ?> - add</h1>
<form method="POST">
  <input type="hidden" name="table" value="<?php echo $table->name; ?>">
  <table>
    <?php echo $columnRows; ?>
    <tr>
      <td></td>
      <td><input type="submit" name="add_record" value="Save"></td>
    </tr>
  </table>
</form>
