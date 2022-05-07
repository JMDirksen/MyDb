<?php
loginRequired('admin');

// Table Action
if (isset($_POST['table-action'])) {
  switch ($_POST['action']) {
    case 'export':
      redirect(sprintf('?page=export&table=%s', $_POST['table']));
      break;
    default:
      redirect();
  }
}

// Table dropdown
$sth = $dbh->prepare('SELECT `name`, `display_name` FROM `s_table` ORDER BY `display_name`');
$sth->execute();
$tableList = $sth->fetchAll(PDO::FETCH_ASSOC);
$tableDropdown = '<select name="table">';
foreach ($tableList as $table)
  $tableDropdown .= sprintf(
    '<option value="%s">%s</option>',
    $table['name'],
    htmlspecialchars($table['display_name']),
  );
$tableDropdown .= '</select> ';
?>
<h1>admin</h1>
<p><a href="?page=create_table">Create table</a><br /></p>
<form method="POST">
  <?php echo $tableDropdown; ?>
  <select name="action">
    <option value="delete">Delete</option>
    <option value="edit">Edit</option>
    <option value="export">Export</option>
    <option value="import">Import into</option>
  </select>
  <input type="submit" name="table-action" value="Go">
</form>
