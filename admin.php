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

echo '<h1>admin</h1>';
echo '<p><a href="?page=add_table">Add table</a><br /></p>';

// Table dropdown
$sth = $dbh->prepare('SELECT `name`, `display_name` FROM `s_table` ORDER BY `display_name`');
$sth->execute();
$tableList = $sth->fetchAll(PDO::FETCH_ASSOC);

$form = new Form();
$form->elements[] = $tableSelect = new Select('table');
foreach ($tableList as $table)
  $tableSelect->options[] = [
    $table['name'],
    htmlspecialchars($table['display_name'])
  ];

// Action dropdown
$form->elements[] = $actionSelect = new Select('table-action', selected: 'edit');
$actionSelect->options[] = ['delete', 'Delete'];
$actionSelect->options[] = ['edit', 'Edit'];
$actionSelect->options[] = ['export', 'Export'];
$actionSelect->options[] = ['import', 'Import'];
$form->elements[] = new Input('submit', value: 'Go');
echo $form->getHtml();
