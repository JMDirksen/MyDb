<?php
loginRequired("admin");

// Create table
if (isset($_POST['createtable'])) {
  if (!valid($table = $_POST['name'])) die("Invalid table name");
  for ($i = 1; $i <= $_POST['columns']; $i++) {
    if (!valid($name = $_POST['name' . $i])) die("Invalid column name");
    $type = str_replace(["text", "number"], ["VARCHAR(255)", "INT"], $_POST['type' . $i]);
    $columns[] = "$name $type";
  }
  $columnsstring = implode(", ", $columns);
  $sql = "CREATE TABLE $table ($columnsstring)";
  if ($dbh->exec($sql) === false) die(dump($dbh->errorInfo()));
  redirect("/admin");
}

// Form with columns
elseif (isset($_GET['n']) && isset($_GET['c'])) {
  if (!valid($table = $_GET['n'])) die("Invalid table name");
?>
  <form method="POST">
    <input type="hidden" name="columns" value="<?php echo $_GET['c']; ?>">
    <table>
      <tr>
        <td>Name</td>
        <td><input type="text" name="name" value="<?php echo $_GET['n']; ?>" required></td>
      </tr>
    </table>
    <table>
      <?php
      for ($i = 1; $i <= $_GET['c']; $i++) {
        echo "<tr>\n";
        echo "<td>$i</td>\n";
        echo "<td><input type=\"text\" name=\"name$i\" placeholder=\"columnname\" required></td>\n";
        echo "<td><select name=\"type$i\">\n";
        echo "  <option>text</option>\n";
        echo "  <option>number</option>\n";
        echo "</select></td>\n";
        echo "</tr>\n";
      }
      ?>
    </table>
    <input type="submit" name="createtable" value="Create">
  </form>

<?php
}
// Form name and column count
else {
?>
  <form method="GET">
    <input type="hidden" name="p" value="create_table">
    <table>
      <tr>
        <td>Name</td>
        <td><input type="text" name="n" placeholder="tablename" required></td>
      </tr>
      <tr>
        <td>Columns</td>
        <td><input type="number" name="c" value="1" min="1" max="10"></td>
      </tr>
      <tr>
        <td></td>
        <td><input type="submit" value="Next"></td>
      </tr>
    </table>
  </form>

<?php } ?>
