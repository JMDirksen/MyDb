<?php
loginRequired('admin');

// Table Action
if (isset($_POST['table-action'])) {
  switch ($_POST['table-action']) {
    case 'export':
      redirect(sprintf('?page=export&table=%s', $_POST['table']));
      break;
    case 'edit':
      redirect(sprintf('?page=edit_table&table=%s', $_POST['table']));
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
<p><a href="?page=add_table">Add table</a><br /></p>
<form method="POST">
  <?php echo $tableDropdown; ?>
  <select name="table-action">
    <option value="delete">Delete</option>
    <option value="edit" selected>Edit</option>
    <option value="export">Export</option>
    <option value="import">Import</option>
  </select>
  <input type="submit" value="Go">
</form>
