<?php
loginRequired('admin');

// List columns
$table = new Table($_GET['table']);
$columnList = '';
foreach ($table->columns as $column)
  $columnList .= sprintf(
    '<tr><td>%s</td><td>%s</td></tr>',
    $column->name,
    htmlspecialchars($column->display_name),
  );

// Add column form
if (isset($_GET['add_column_type'])) {
  $type = $_GET['add_column_type'];
  echo '<form method="POST">';
  echo '<table>';
  switch ($type) {
    case 'text':
      echo '<tr><th>Name</th><td><input type="text" name="name" placeholder="columnname" autofocus></td></tr>';
      echo '<tr><th>Display name</th><td><input type="text" name="display_name" placeholder="Column name"></tr>';
      echo '<tr><th>Default value</th><td><input type="text" name="default" placeholder="Default value"></tr>';
      echo '<tr><th>Required</th><td><input type="checkbox" name="required"></tr>';
      break;
  }
  echo '<tr><td></td><td><input type="submit" value="Add"></td></tr>';
  echo '</table>';
  echo '</form>';
} else {

  // Add type  
?>
  <form method="GET">
    <input type="hidden" name="page" value="edit_table">
    <input type="hidden" name="table" value="<?php echo $_GET['table']; ?>">
    <label for="type">Add column of type</label>
    <select name="add_column_type" id="type">
      <option title="A checkbox">checkbox</option>
      <option title="A date">date</option>
      <option title="A date and time">datetime</option>
      <option title="A whole number">number</option>
      <option title="A string of maximum 255 characters" selected>text</option>
      <option title="A time">time</option>
    </select>
    <input type="submit" value="Go">
  </form>

<?php } ?>

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
