<?php
loginRequired('admin');

// Add column form
if (isset($_GET['add_column_type'])) {
  $type = $_GET['add_column_type'];
  $form = new Form();
  switch ($type) {
    case 'text':
      $form->elements[] = new Input('text', 'name', label: 'Name', placeholder: 'columnname', autofocus: true);
      $form->elements[] = new Input('text', 'display_name', label: 'Display name', placeholder: 'Column name');
      $form->elements[] = new Input('text', 'default', label: 'Default value', placeholder: 'Default value');
      $form->elements[] = new Input('checkbox', 'required', label: 'Required');
      break;
  }
  $form->elements[] = new Input('submit', value: 'Add');
  echo $form->getHtml(true);
} else {

  // Add type
  $form = new Form('GET');
  $form->elements[] = new Input('hidden', 'page', 'edit_table');
  $form->elements[] = new Input('hidden', 'table', $_GET['table']);
  $form->elements[] = $s = new Select('add_column_type', label: 'Add column of type', selected: 'text');
  $s->options[] = ['checkbox', 'checkbox', 'A checkbox'];
  $s->options[] = ['date', 'date', 'A date'];
  $s->options[] = ['datetime', 'datetime', 'A date and time'];
  $s->options[] = ['number', 'number', 'A whole number'];
  $s->options[] = ['text', 'text', 'A string of maximum 255 characters'];
  $s->options[] = ['time', 'time', 'A time'];
  $form->elements[] = new Input('submit', value: 'Go');
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
