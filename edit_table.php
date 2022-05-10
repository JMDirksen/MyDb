<?php
loginRequired('admin');

// Add column form
if (isset($_GET['add_column_type'])) {
    $type = $_GET['add_column_type'];
    $form = new Form();
    switch ($type) {
        case 'text':
            $form->element[] = new Input('text', 'name', label: 'Name', placeholder: 'columnname', autofocus: true);
            $form->element[] = new Input('text', 'display_name', label: 'Display name', placeholder: 'Column name');
            $form->element[] = new Input('text', 'default', label: 'Default value', placeholder: 'Default value');
            $form->element[] = new Input('checkbox', 'required', label: 'Required');
            break;
    }
    $form->element[] = new Input('submit', value: 'Add');
    echo $form->getHtml(true);
} else {

    // Add type
    $form = new Form('GET');
    $form->element[] = new Input('hidden', 'page', 'edit_table');
    $form->element[] = new Input('hidden', 'table', $_GET['table']);
    $form->element[] = $s = new Select('add_column_type', label: 'Add column of type', selected: 'text');
    $s->option[] = ['checkbox', 'checkbox', 'A checkbox'];
    $s->option[] = ['date', 'date', 'A date'];
    $s->option[] = ['datetime', 'datetime', 'A date and time'];
    $s->option[] = ['number', 'number', 'A whole number'];
    $s->option[] = ['text', 'text', 'A string of maximum 255 characters'];
    $s->option[] = ['time', 'time', 'A time'];
    $form->element[] = new Input('submit', value: 'Go');
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
