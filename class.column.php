<?php
class Column {
  public $table;
  public $name;
  public $display_name;
  public $type;
  public $sqlType;
  public $new;

  function __construct($table, $name, $new = false) {
    $this->table = $table;
    $this->name = $name;
    $this->display_name = ucfirst($name);
    $this->new = $new;

    if (!$new) $this->load();
  }

  function setType($type) {
    $this->type = $type;
    $this->sqlType = str_replace(['text', 'number'], ['VARCHAR(255)', 'INT'], $type);
  }

  function load() {
    global $dbh;

    $sth = $dbh->prepare('SELECT `table`, `name`, `display_name` FROM `s_column` WHERE `table` = ? AND `name` = ?');
    $sth->execute([$this->table, $this->name]);
    $column = $sth->fetch(PDO::FETCH_ASSOC);
    $this->table = $column['table'];
    $this->name = $column['name'];
    $this->display_name = $column['display_name'];
  }
}
