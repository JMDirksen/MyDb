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
$columnsSelect = '';
foreach ($table->columns as $column) {
  $checked = (isset($_GET['columns']) && in_array($column->name, $_GET['columns'])) ? ' checked' : '';
  $columnsSelect .= sprintf(
    '<label><input type="checkbox" name="columns[]" value="%s" %s>%s</label><br />',
    $column->name,
    $checked,
    htmlentities($column->display_name),
  );
}

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
  <fieldset><legend>Select columns</legend>
  <?php echo $columnsSelect; ?>
  </fieldset>
  <input type="hidden" name="getlink" value=1>
  <input type="submit" value="Get export link">
</form>

<?php echo @$linksHtml; ?>
