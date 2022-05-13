<?php

namespace MyDb;

use FormFramework as FF;

loginRequired('admin');

// Add column form
if (isset($_GET['add_column_type'])) {
    $type = $_GET['add_column_type'];
    $form = new FF\Form();
    switch ($type) {
        case 'text':
            $form->elements[] = new FF\Input('text', 'name', label: 'Name', placeholder: 'columnname', autofocus: true);
            $form->elements[] = new FF\Input('text', 'display_name', label: 'Display name', placeholder: 'Column name');
            $form->elements[] = new FF\Input('text', 'default', label: 'Default value', placeholder: 'Default value');
            $form->elements[] = new FF\Input('checkbox', 'required', label: 'Required');
            break;
    }
    $form->elements[] = new FF\Input('submit', value: 'Add');
    echo $form->getHtml(true);
} else {

    // Add type
    $form = new FF\Form('GET');
    $form->elements[] = new FF\Input('hidden', 'page', 'edit_table');
    $form->elements[] = new FF\Input('hidden', 'table', $_GET['table']);
    $form->elements[] = $s = new FF\Select('add_column_type', label: 'Add column of type', selected: 'text');
    $s->options[] = ['checkbox', 'checkbox', 'A checkbox'];
    $s->options[] = ['date', 'date', 'A date'];
    $s->options[] = ['datetime', 'datetime', 'A date and time'];
    $s->options[] = ['number', 'number', 'A whole number'];
    $s->options[] = ['text', 'text', 'A string of maximum 255 characters'];
    $s->options[] = ['time', 'time', 'A time'];
    $form->elements[] = new FF\Input('submit', value: 'Go');
    echo $form->getHtml();
}

// Columns list
$table = new Table($_GET['table']);
$columnList = '';
foreach ($table->columns as $column)
    $columnList .= sprintf(
        '<tr><td>%s</td><td>%s</td></tr>',
        $column->name,
        htmlspecialchars($column->display_name),
    );
?>
<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Display name</th>
        </tr>
    </thead>
    <tbody>
        <?php echo $columnList; ?>
    </tbody>
</table>
