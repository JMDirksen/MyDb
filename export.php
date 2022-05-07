<?php
loginRequired('admin');

$tableName = $_GET['table'];

// Table dropdown
$sth = $dbh->prepare('SELECT `name`, `display_name` FROM `s_table` ORDER BY `display_name`');
$sth->execute();
$tableList = $sth->fetchAll(PDO::FETCH_ASSOC);
$tableDropdown = '<select name="table">';
foreach ($tableList as $t) {
  $selected = ($t['name'] == $tableName) ? ' selected' : '';
  $tableDropdown .= sprintf(
    '<option value="%s"%s>%s</option>',
    $t['name'],
    $selected,
    htmlentities($t['display_name']),
  );
}
$tableDropdown .= '</select> ';

// Columns selection
$table = new Table($_GET['table']);
$columnCount = count($table->columns);
$columnsSelect = sprintf('<select name="columns[]" size="%d" multiple>', $columnCount);
foreach ($table->columns as $column) {
  $selected = (isset($_GET['columns']) && in_array($column->name, $_GET['columns'])) ? ' selected' : '';
  $columnsSelect .= sprintf(
    '<option value="%s"%s>%s</option>',
    $column->name,
    $selected,
    htmlentities($column->display_name),
  );
}
$columnsSelect .= '</select> ';

// Generate export link
if (isset($_GET['getlink'])) {
  $downloadUrl = sprintf('csv.php?table=%s&columns=%s', $tableName, join(',', $_GET['columns']));
  $showUrl = $downloadUrl . '&show';

  $linksHtml = sprintf('<br /><a href="%s" target="_blank">Download CSV</a>', $downloadUrl) .
    sprintf(' <small>(<a href="%s" target="_blank">show</a>)</small>', $showUrl);
}

?>

<form method="GET">
  <input type="hidden" name="page" value="export">
  <label for="table">Table</label>
  <?php echo $tableDropdown; ?>
  <input type="submit" value="Select">
</form>

<form method="GET">
  <input type="hidden" name="page" value="export">
  <input type="hidden" name="table" value="<?php echo $tableName; ?>">
  <label for="columns">Select columns</label><br />
  <?php echo $columnsSelect; ?><br />
  <input type="hidden" name="getlink">
  <input type="submit" value="Get export link">
</form>

<?php echo @$linksHtml; ?>
