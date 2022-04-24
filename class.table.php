<?php
class Table {
  public string $display_name;
  public bool $new;
  public array $columns;

  function __construct(public string $name, bool $new = false) {
    $this->display_name = ucfirst($name);
    $this->new = $new;

    if (!$new) $this->load();
  }

  function load() {
    global $dbh;

    // Load table
    $sth = $dbh->prepare('SELECT `name`, `display_name` FROM `s_table` WHERE `name` = ?');
    $sth->execute([$this->name]);
    $table = $sth->fetch(PDO::FETCH_ASSOC);
    $this->name = $table['name'];
    $this->display_name = $table['display_name'];

    // Load columns
    $sth = $dbh->prepare('SELECT `name` FROM `s_column` WHERE `table` = ?');
    $sth->execute([$this->name]);
    $columns = $sth->fetchAll(PDO::FETCH_ASSOC);
    foreach ($columns as $column) {
      $this->columns[$column['name']] = new Column($this, $column['name']);
    }
  }

  function save() {
    global $dbh;

    if ($this->new) {
      try {
        if(!$dbh->beginTransaction()) die('Unable to start transaction');

        // Save metadata table
        $sth = $dbh->prepare('INSERT INTO `s_table` (`name`, `display_name`) VALUES (?, ?)');
        $sth->execute([$this->name, $this->display_name]);

        // Save metadata columns
        foreach ($this->columns as $column) {
          $sth = $dbh->prepare('INSERT INTO `s_column` (`table`, `name`, `display_name`, `type`) VALUES (?, ?, ?, ?)');
          $sth->execute([$column->table, $column->name, $column->display_name, $column->type]);
        }

        // Save table
        foreach ($this->columns as $column)
          $columnstring[] = "`$column->name` $column->sqlType";
        $columnstring = join(', ', $columnstring);
        $sth = $dbh->prepare("CREATE TABLE `$this->name` (`id` INT AUTO_INCREMENT PRIMARY KEY, $columnstring)");
        $sth->execute();

        $dbh->commit();
      } catch (Exception $e) {
        @$dbh->rollBack();
        die("Failed: " . $e->getMessage());
      }
    }
  }

  function getRecord(int $id) {
    return new Record($this->name, $id);
  }

  function addRecord(array $values) {
    $record = new Record($this->name);
    $record->data = $values;
    $record->save();
    return $record;
  }

  function deleteRecord(int $id) {
    $record = new Record($this->name, $id);
    $record->delete();
  }

  function getRecordset() {
    return new Recordset($this->name);
  }
}
