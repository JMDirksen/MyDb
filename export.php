<?php
loginRequired('admin');

$tableName = $_GET['table'];

// Table dropdown
$sth = $dbh->prepare('SELECT `name`, `display_name` FROM `s_table` ORDER BY `display_name`');
$sth->execute();
$tableList = $sth->fetchAll(PDO::FETCH_ASSOC);
$form = new Form('GET');
$form->element[] = new Input('hidden', 'page', 'export');
$form->element[] = $s = new Select('table', $tableName, 'Table');
foreach ($tableList as $t) {
    $s->option[] = [$t['name'], $t['display_name']];
}
$form->element[] = new Input('submit', value: 'Select');
echo $form->getHtml();

// Columns selection
$table = new Table($_GET['table']);
$form = new Form('GET');
$form->element[] = new Input('hidden', 'page', 'export');
$form->element[] = new Input('hidden', 'table', $tableName);
$form->element[] = $s = new Select('columns[]', @$_GET['columns'], 'Select columns', true);
foreach ($table->columns as $column) {
    $s->option[] = [$column->name, $column->display_name];
}
$form->element[] = new Input('hidden', 'getlink', 1);
$form->element[] = new Input('submit', value: 'Get export link');
echo $form->getHtml();

// Generate export link
if (isset($_GET['getlink'])) {
    $downloadUrl = sprintf(
        'csv.php?table=%s&columns=%s',
        $tableName,
        join(',', $_GET['columns'])
    );
    $showUrl = $downloadUrl . '&show';

    $linksHtml = sprintf(
        '<br /><a href="%s" target="_blank">Download CSV</a>' .
            ' <small>(<a href="%s" target="_blank">show</a>)</small>',
        $downloadUrl,
        $showUrl
    );

    echo $linksHtml;
}
