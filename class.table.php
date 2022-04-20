<?php
class Table {
  public $name;
  public $display_name;
  public $new;
  public $columns = [];

  function __construct($name, $new = false) {
    $this->name = $name;
    $this->display_name = ucfirst($name);
    $this->new = $new;

    if (!$new) $this->load();
  }

  function load() {
    global $dbh;

    // Load table
    $sth = $dbh->prepare("SELECT * FROM `s_table` WHERE `name` = ?");
    if (!$sth->execute([$this->name])) die(dump($sth->errorInfo()));
    $table = $sth->fetch(PDO::FETCH_ASSOC);
    $this->name = $table['name'];
    $this->display_name = $table['display_name'];

    // Load columns
    $sth = $dbh->prepare("SELECT `name`, `type` FROM `s_column` WHERE `table` = ?");
    if (!$sth->execute([$this->name])) die(dump($sth->errorInfo()));
    $columns = $sth->fetchAll(PDO::FETCH_ASSOC);
    foreach ($columns as $column) {
      $this->columns[] = new Column($this->name, $column['name']);
    }
  }

  function save() {
    global $dbh;

    if ($this->new) {
      // Save table
      foreach ($this->columns as $column)
        $columnstring[] = "`$column->name` $column->sqlType";
      $columnstring = join(', ', $columnstring);
      $sth = $dbh->prepare("CREATE TABLE `$this->name` ($columnstring)");
      if (!$sth->execute()) die(dump($sth->errorInfo()));

      // Save metadata table
      $sth = $dbh->prepare("INSERT INTO `s_table` (`name`, `display_name`) VALUES (?, ?)");
      if (!$sth->execute([$this->name, $this->display_name])) die(dump($sth->errorInfo()));

      // Save metadata columns
      foreach ($this->columns as $column) {
        $sth = $dbh->prepare("INSERT INTO `s_column` (`table`, `name`, `display_name`) VALUES (?, ?, ?)");
        if (!$sth->execute([$column->table, $column->name, $column->display_name])) die(dump($sth->errorInfo()));
      }
    }
  }
}
