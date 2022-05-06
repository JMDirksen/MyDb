<?php
loginRequired('admin');

// Generate export link
if (isset($_POST['columnsselect'])) {
  $exportLink = sprintf('csv.php?table=test&columns=%s', join(',', $_POST['columns']));
  $link = sprintf('<br /><a href="%s" target="_blank">%s</a>', $exportLink, $exportLink);
}

// Columns selection
$table = new Table($_GET['table']);
$columnCount = count($table->columns);
$columnsSelect = sprintf('<select name="columns[]" size="%d" multiple>', $columnCount);
foreach ($table->columns as $column) {
  $selected = (isset($_POST['columns']) && in_array($column->name, $_POST['columns'])) ? ' selected' : '';
  $columnsSelect .= sprintf('<option value="%s"%s>%s</option>', $column->name, $selected, $column->display_name);
}
$columnsSelect .= '</select> ';

?>
<p>Export table <?php echo $table->display_name; ?></p>
<form method="POST">
  <label for="columns">Select columns</label>
  <?php echo $columnsSelect; ?><br />
  <input type="submit" name="columnsselect" value="Get export link">
</form>
<?php echo @$link; ?>
