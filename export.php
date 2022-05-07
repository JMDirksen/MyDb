<?php
loginRequired('admin');

$table = $_GET['table'];

// Generate export link
if (isset($_POST['columnsselect'])) {
  $downloadUrl = sprintf('csv.php?table=%s&columns=%s', $table, join(',', $_POST['columns']));
  $showUrl = $downloadUrl . '&show';

  $linksHtml = sprintf('<br /><a href="%s" target="_blank">Download CSV</a>', $downloadUrl) .
    sprintf(' <small>(<a href="%s" target="_blank">show</a>)</small>', $showUrl);
}

// Table dropdown
$sth = $dbh->prepare('SELECT `name`, `display_name` FROM `s_table` ORDER BY `display_name`');
$sth->execute();
$tableList = $sth->fetchAll(PDO::FETCH_ASSOC);
$tableDropdown = '<select name="table">';
foreach ($tableList as $t) {
  $selected = ($t['name'] == $table) ? ' selected' : '';
  $tableDropdown .= sprintf('<option value="%s"%s>%s</option>', $t['name'], $selected, $t['display_name']);
}
$tableDropdown .= '</select> ';

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

<form method="GET">
  <label for="table">Table</label>
  <?php echo $tableDropdown; ?>
  <input type="hidden" name="page" value="export">
  <input type="submit" value="Select">
</form>

<form method="POST">
  <label for="columns">Select columns</label><br />
  <?php echo $columnsSelect; ?><br />
  <input type="submit" name="columnsselect" value="Get export link">
</form>

<?php echo @$linksHtml; ?>
