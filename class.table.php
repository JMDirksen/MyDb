<?php
class Table {
  public $name;
  public $display_name;

  function __construct($table_name) {
    global $dbh;
    $sth = $dbh->prepare("SELECT * FROM s_table WHERE name = ?");
    if (!$sth->execute([$table_name])) die(dump($sth->errorInfo()));
    $table = $sth->fetch(PDO::FETCH_ASSOC);
    $this->name = $table['name'];
    $this->display_name = $table['display_name'];
  }
}
