<?php
loginRequired('admin');

// Create table
if (isset($_POST['create_table'])) {
  if (!valid($tablename = strtolower($_POST['name']))) die('Invalid table name');

  $table = new Table($tablename, true);

  for ($i = 1; $i <= (int)$_POST['columns']; $i++) {
    if (!valid($name = strtolower($_POST["name$i"]))) die('Invalid column name');
    $column = new Column($table, $name, true);
    $column->type = $_POST["type$i"];
    $table->columns[] = $column;
  }

  $table->save();

  redirect('/?page=admin');
}

// Form with columns
elseif (isset($_GET['name']) && isset($_GET['columns'])) {
  if (!valid($table = strtolower($_GET['name']))) die('Invalid table name');
  $columnCount = (int)$_GET['columns'];
?>
  <form method="POST">
    <input type="hidden" name="columns" value="<?php echo $columnCount; ?>">
    <table>
      <tr>
        <td>Name</td>
        <td><input type="text" name="name" value="<?php echo $table; ?>" required></td>
      </tr>
    </table>
    <table>
      <?php
      for ($i = 1; $i <= $columnCount; $i++) {
        echo "<tr>\n";
        echo "<td>$i</td>\n";
        echo "<td><input type=\"text\" name=\"name$i\" placeholder=\"columnname\" required></td>\n";
        echo "<td><select name=\"type$i\">\n";
        echo "  <option title=\"A string of maximum 255 characters\">text</option>\n";
        echo "  <option title=\"A whole number\">number</option>\n";
        echo "</select></td>\n";
        echo "</tr>\n";
      }
      ?>
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
