<?php
class Column {
  public string $table;
  public string $name;
  public string $display_name;
  public string $type;

  function __construct(Table $table, string $name, bool $new = false) {
    $this->table = $table->name;
    $this->name = $name;
    $this->display_name = ucfirst($name);

    if (!$new) $this->load();
  }

  function load(): void {
    global $dbh;

    $sth = $dbh->prepare('SELECT `table`, `name`, `display_name`, `type` FROM `s_column` WHERE `table` = ? AND `name` = ?');
    $sth->execute([$this->table, $this->name]);
    $column = $sth->fetch(PDO::FETCH_ASSOC);
    $this->table = $column['table'];
    $this->name = $column['name'];
    $this->display_name = $column['display_name'];
    $this->type = $column['type'];
  }
}
