<?php

namespace MyDb;

use \PDO;
use FormFramework as FF;

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

// Action Backup
if (isset($_GET['action']) && $_GET['action'] == 'backup') {
    $file = '/backups/mydb-' . date('Y-m-d-H-i-s') . '.gz';
    $cmd = 'mariadb-dump --opt -h mydb-mariadb -u mydb -pmydb mydb | gzip > ' . $file;
    if (system($cmd) === false) die('error: ' . $cmd);
    die('done');
}

echo '<h1>admin</h1>';
echo '<p><a href="?page=add_table">Add table</a><br /></p>';
echo '<p><a href="?page=admin&action=backup">Backup</a><br /></p>';

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
