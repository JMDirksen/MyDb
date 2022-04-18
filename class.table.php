<?php
class Table {
  public $name;
  public $display_name;
  public $columns = [];

  function __construct($table_name) {
    global $dbh;

    // Load table
    $sth = $dbh->prepare("SELECT * FROM `s_table` WHERE `name` = ?");
    if (!$sth->execute([$table_name])) die(dump($sth->errorInfo()));
    $table = $sth->fetch(PDO::FETCH_ASSOC);
    $this->name = $table['name'];
    $this->display_name = $table['display_name'];

    // Load columns
    $sth = $dbh->prepare("SELECT `name` FROM `s_column` WHERE `table` = ?");
    if (!$sth->execute([$table_name])) die(dump($sth->errorInfo()));
    $columns = $sth->fetchAll(PDO::FETCH_ASSOC);
    foreach ($columns as $column) {
      $this->columns[] = new Column($table_name, $column['name']);
    }
  }
}
