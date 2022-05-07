<?php
loginRequired('admin');

// Create table
if (isset($_POST['create_table'])) {
  if (!valid($tablename = strtolower($_POST['name']))) die('Invalid table name');

  $table = new Table($tablename, true);
  $table->display_name = htmlspecialchars($_POST['display_name']);
  for ($i = 1; $i <= (int)$_POST['columns']; $i++) {
    if (!valid($name = strtolower($_POST["name$i"]))) die('Invalid column name');
    $column = new Column($table, $name, true);
    $column->type = $_POST["type$i"];
    $column->display_name = htmlspecialchars($_POST["display_name$i"]);
    $table->columns[] = $column;
  }

  $table->save();

  redirect('/?page=admin');
}

// Form with columns
elseif (isset($_GET['name']) && isset($_GET['columns'])) {
  if (!valid($table = strtolower($_GET['name']))) die('Invalid table name');
  $columnCount = (int)$_GET['columns'];
  $display_name = ucfirst($table);
  $columnsHTML = '';
  for ($i = 1; $i <= $columnCount; $i++) {
    $columnsHTML .= sprintf(
      '<tr>' .
        '<td>%1$d</td>' .
        '<td><input type="text" name="name%1$d" placeholder="columnname" required></td>' .
        '<td><select name="type%1$d">' .
        '<option title="A checkbox">checkbox</option>' .
        '<option title="A date">date</option>' .
        '<option title="A date and time">datetime</option>' .
        '<option title="A whole number">number</option>' .
        '<option title="A string of maximum 255 characters" selected>text</option>' .
        '<option title="A time">time</option>' .
        '</select></td>' .
        '<td><input type="text" name="display_name%1$d" placeholder="Display name" required></td>' .
        '</tr>',
      $i
    );
  }

?>
  <form method="POST">
    <input type="hidden" name="columns" value="<?php echo $columnCount; ?>">
    <table>
      <tr>
        <th>Name</th>
        <td><input type="text" name="name" value="<?php echo $table; ?>" required></td>
      </tr>
      <tr>
        <th>Display name</th>
        <td><input type="text" name="display_name" value="<?php echo $display_name; ?>" required></td>
      </tr>
    </table>
    <table>
      <tr>
        <th>#</th>
        <th>Column name</th>
        <th>Type</th>
        <th>Display name</th>
      </tr>
      <?php echo $columnsHTML; ?>
    </table>
    <input type="submit" name="create_table" value="Create">
  </form>

<?php
}
// Form name and column count
else {
?>
  <form method="GET">
    <input type="hidden" name="page" value="create_table">
    <table>
      <tr>
        <td>Name</td>
        <td><input type="text" name="name" placeholder="tablename" required></td>
      </tr>
      <tr>
        <td>Columns</td>
        <td><input type="number" name="columns" value="1" min="1" max="10"></td>
      </tr>
      <tr>
        <td></td>
        <td><input type="submit" value="Next"></td>
      </tr>
    </table>
  </form>

<?php } ?>
