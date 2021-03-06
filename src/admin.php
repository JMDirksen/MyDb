<?php

namespace MyDb;

use \PDO;
use FormFramework as FF;

User::checkLogin('admin');

// Table Action
if (isset($_POST['table-action'])) {
    switch ($_POST['table-action']) {
        case 'export':
            redirect(sprintf('?page=export&table=%s', $_POST['table']));
            break;
        case 'edit':
            redirect(sprintf('?page=edit_table&table=%s', $_POST['table']));
            break;
        case 'import':
            redirect(sprintf('?page=import&table=%s', $_POST['table']));
            break;
        default:
            redirect();
    }
}

// Restore
if (isset($_FILES['restore'])) {
    $sql = file_get_contents($_FILES['restore']['tmp_name']);
    $dbh->exec($sql);
    User::logout();
    redirect('/?page=login');
}

// Reset
if (isset($_GET['action']) && $_GET['action'] == 'reset') {
    $dbh->exec(sprintf('DROP DATABASE `%s`; CREATE DATABASE `%1$s`', DB_NAME));
    User::logout();
    redirect('/?page=login');
}

echo '<h1>Admin</h1>';
echo '<h2>Tables</h2>';
echo '<p><a href="?page=add_table">Add table</a><br /></p>';

// Table dropdown
$sth = $dbh->prepare(
    'SELECT `name`, `display_name` FROM `s_table` ORDER BY `display_name`'
);
$sth->execute();
$tableList = $sth->fetchAll(PDO::FETCH_ASSOC);

$form = new FF\Form();
$form->elements[] = $tableSelect = new FF\Select('table');
foreach ($tableList as $table)
    $tableSelect->options[] = [
        $table['name'],
        htmlspecialchars($table['display_name'])
    ];

// Action dropdown
$form->elements[] = $s = new FF\Select('table-action', selected: 'edit');
$s->options[] = ['delete', 'Delete'];
$s->options[] = ['edit', 'Edit'];
$s->options[] = ['export', 'Export'];
$s->options[] = ['import', 'Import'];
$form->elements[] = new FF\Input('submit', value: 'Go');
echo $form->getHtml();

echo '<h2>Database</h2>';

// Backup
echo '<p><a href="backup.php">Backup</a></p>';

// Restore
$form = new FF\Form(enctype: 'multipart/form-data');
$msg = 'Overwrite current database?\\n' .
    'This will remove everything, make sure you have a backup!';
$form->elements[] = new FF\Input(
    'file',
    'restore',
    label: 'Restore',
    accept: '.sql',
    onclick: sprintf('return confirm(\'%s\')', $msg),
    onchange: 'form.submit()',
);
echo $form->getHtml();

// Reset
$msg = 'Reset whole database?\\n' .
    'This will remove everything, make sure you have a backup!';
$js = sprintf('onClick="return confirm(\'%s\')"', $msg);
echo sprintf('<p><a href="?page=admin&action=reset" %s>Reset</a></p>', $js);
