<?php
class Column {
  public $table;
  public $name;
  public $display_name;

  function __construct($table, $name, $load = true) {
    $this->table = $table;
    $this->name = $name;
    if ($load) $this->load();
  }

  function load() {
    global $dbh;

    $sth = $dbh->prepare("SELECT * FROM `s_column` WHERE `table` = ? AND `name` = ?");
    if (!$sth->execute([$this->table, $this->name])) die(dump($sth->errorInfo()));
    $column = $sth->fetch(PDO::FETCH_ASSOC);
    $this->table = $column['table'];
    $this->name = $column['name'];
    $this->display_name = $column['display_name'];
  }
}
