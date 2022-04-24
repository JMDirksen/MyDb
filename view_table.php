<?php
loginRequired();

if (!valid($tableName = @$_GET['table'])) die('Invalid table name');

// Delete record
if (isset($_GET['delete'])) {
  (new Record($tableName, $_GET['delete']))->delete();
  redirect('/?page=view_table&table=' . $tableName);
}

$table = new Table($tableName);

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
  foreach ($record->data as $columnName => $value) {
    $dataHtml .= sprintf('<td>%s</td>', $value);
  }
  $dataHtml .= '</tr>' . PHP_EOL;
}
?>

<h1><?php echo $tableName; ?></h1>
<a href="?page=add_record&table=<?php echo $tableName; ?>">Add</a>
<table>
  <tr>
    <th></th><?php echo $columnHtml; ?>
  </tr>
  <?php echo $dataHtml; ?>
</table>
