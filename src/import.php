<?php

namespace MyDb;

use FormFramework as FF;

loginRequired('admin');

global $dbh;
$tableName = $_GET['table'];

if (isset($_FILES['import'])) {
    $handle = fopen($_FILES['import']['tmp_name'], 'r');
    $columns = [];
    $row = 1;
    while (($data = fgetcsv($handle)) !== false) {
        if ($row == 1) {
            $columns = $data;
            dump($columns);
        } else {

            // Convert empty to null
            $data = array_map(fn ($v) => (strlen($v) == 0) ? null : $v, $data);

            $updateString = '';
            foreach ($columns as $c) {
                if ($c == 'id') continue;
                $updateString .= $c . '=VALUES(' . $c . '), ';
            }

            $sql = sprintf(
                'INSERT INTO `%s` (`%s`) VALUES (%s) ON DUPLICATE KEY UPDATE %s',
                $tableName,
                join('`, `', $columns),
                rtrim(str_repeat('?, ', count($columns)), ', '),
                rtrim($updateString, ', '),
            );
            echo $sql . '<br />';
            $sth = $dbh->prepare($sql);
            $sth->execute($data);
        }
        $row++;
    }
    redirect('?page=view_table&table=' . $tableName);
}

echo '<h1>Import</h1>';

$form = new FF\Form(enctype: 'multipart/form-data');
$form->elements[] = new FF\Input(
    'file',
    'import',
    label: 'Import csv file',
    accept: '.csv',
    onchange: 'form.submit()',
);
echo $form->getHtml();
