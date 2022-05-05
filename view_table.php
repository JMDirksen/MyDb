<?php
loginRequired();

if (!valid($tableName = @$_GET['table'])) die('Invalid table name');

// Delete record
if (isset($_GET['delete'])) {
  (new Record($tableName, $_GET['delete']))->delete();
  redirect('/?page=view_table&table=' . $tableName);
}

$table = new Table($tableName);
$display_name = $table->display_name;

// Columns
$columnHtml = '';
foreach ($table->columns as $column) {
  $columnHtml .= "<th>$column->display_name</th>";
}

// Data
$recordset = $table->getRecordset();
$dataHtml = '';
foreach ($recordset->records as $record) {
  $dataHtml .= '<tr><td>' .
    sprintf('<a href="?page=edit_record&table=%s&id=%d">E</a> ', $tableName, $record->id) .
    sprintf(
      '<a href="?page=view_table&table=%s&delete=%s" onClick="return confirm(\'Delete record %s?\')">X</a>',
      $tableName,
      $record->id,
      $record->id
    ) .
    '</td>';
  foreach ($record->columns as $column) {
    $value = $record->data[$column->name];
    // Checkbox value
    if ($column->type == 'checkbox')
      $value = ($value == '1') ?
        '<input type="checkbox" checked onclick="return false">' :
        '<input type="checkbox" onclick="return false">';
    $dataHtml .= sprintf('<td>%s</td>', $value);
  }
  $dataHtml .= '</tr>' . PHP_EOL;
}
?>

<h1><?php echo $display_name; ?></h1>
<a href="?page=add_record&table=<?php echo $tableName; ?>">Add</a>
<table>
  <tr>
    <th></th><?php echo $columnHtml; ?>
  </tr>
  <?php echo $dataHtml; ?>
</table>
