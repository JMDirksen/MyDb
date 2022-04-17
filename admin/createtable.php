<?php
if (isset($_GET['n']) && isset($_GET['c'])) {
?>
  <form method="POST" action="action.php">
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

<?php } else { ?>

  <form method="GET" action="createtable.php">
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