<?php
class Column {
  public $table;
  public $name;
  public $display_name;

  function __construct($table_name, $column_name) {
    global $dbh;

    $sth = $dbh->prepare("SELECT * FROM `s_column` WHERE `table` = ? AND `name` = ?");
    if (!$sth->execute([$table_name, $column_name])) die(dump($sth->errorInfo()));
    $column = $sth->fetch(PDO::FETCH_ASSOC);
    $this->table = $column['table'];
    $this->name = $column['name'];
    $this->display_name = $column['display_name'];
  }
}
