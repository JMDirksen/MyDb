<?php

namespace MyDb;

use FormFramework as FF;

User::checkLogin('admin');

// Action: Add column
if (isset($_POST['name'])) {
    $tableName = $_POST['table'];
    $table = new Table($tableName);
    $column = new Column(
        table: $tableName,
        name: $_POST['name'],
        new: true,
        type: $_POST['type'],
        display_name: $_POST['display_name'],
        default: $_POST['default'],
    );
    $table->addColumn($column);
    redirect('?page=edit_table&table=' . $tableName);
}

// Form: Add column
if (isset($_GET['add_column_type'])) {
    $tableName = $_GET['table'];
    $type = $_GET['add_column_type'];
    $form = new FF\Form();
    $e = [];
    switch ($type) {
        default:
            $e[] = new FF\Input('hidden', 'table', $tableName);
            $e[] = new FF\Input('hidden', 'type', $type);
            $e[] = new FF\Input('text', 'name', null, 'columname', 'Name', autofocus: true);
            $e[] = new FF\Input('text', 'display_name', null, 'Column name', 'Display name');
            $e[] = new FF\Input('text', 'default', null, 'Default value', 'Default value');
            $e[] = new FF\Input('checkbox', 'required', label: 'Required');
            break;
    }
    $e[] = new FF\Input('submit', value: 'Add');
    $form->elements = $e;
    echo $form->getHtml(true);
} else {

    // Form: Add type
    $form = new FF\Form('GET');
    $e = [];
    $e[] = new FF\Input('hidden', 'page', 'edit_table');
    $e[] = new FF\Input('hidden', 'table', $_GET['table']);
    $e[] = $s = new FF\Select('add_column_type', 'text', 'Add column of type');
    $s->options[] = ['checkbox', 'checkbox', 'A checkbox'];
    $s->options[] = ['date', 'date', 'A date'];
    $s->options[] = ['datetime', 'datetime', 'A date and time'];
    $s->options[] = ['number', 'number', 'A whole number'];
    $s->options[] = ['text', 'text', 'A string of maximum 255 characters'];
    $s->options[] = ['time', 'time', 'A time'];
    $e[] = new FF\Input('submit', value: 'Go');
    $form->elements = $e;
    echo $form->getHtml();
}

// Table: Columns listing
$table = new Table($_GET['table']);
$columnList = '';
foreach ($table->columns as $column)
    $columnList .= sprintf(
        '<tr><td>%s</td><td>%s</td><td>%s</td></tr>',
        $column->name,
        htmlspecialchars($column->display_name),
        $column->type,
    );
?>
<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Display name</th>
            <th>Type</th>
        </tr>
    </thead>
    <tbody>
        <?php echo $columnList; ?>
    </tbody>
</table>
