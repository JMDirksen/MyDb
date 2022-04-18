<?php
if (!valid($table = $_GET['t'])) die("Invalid table name");
$id = $_GET['id'];

echo "<h1>$table - $id</h1>";
?>
<form method="POST" action="action.php">
  <input type="hidden" name="table" value="<?php echo $table; ?>">
  <input type="hidden" name="id" value="<?php echo $id; ?>">
  <table>
    <?php
    $sth = $dbh->prepare("SELECT * FROM $table WHERE id = ?");
    $sth->execute([$id]);
    $row = $sth->fetch(PDO::FETCH_ASSOC);
    foreach ($row as $name => $value) {
      echo "<tr>\n";
      echo "<td>$name</td>\n";
      echo "<td><input type=\"text\" name=\"column_$name\" value=\"$value\"></td>\n";
      echo "</tr>\n";
    }
    ?>
    <tr>
      <td></td>
      <td><input type="submit" name="edit_record" value="Save"></td>
    </tr>
  </table>

</form>