<?php
class Record {
  public string $table;
  public int $id;
  public array $columns;
  public array $data;

  function __construct(Table $table, int $id = 0) {
    $this->table = $table->name;
    $this->id = $id;
    $this->columns = $table->columns;
    if ($id) $this->load();
  }

  function load() {
    global $dbh;
    $select = '`' . join('`, `', array_column($this->columns, 'name')) . '`';
    $sth = $dbh->prepare("SELECT $select FROM `$this->table` WHERE `id` = ?");
    $sth->execute([$this->id]);
    $this->data = $sth->fetch(PDO::FETCH_ASSOC);
  }

  function save() {
    if ($this->id) $this->update();
    else $this->insert();
  }

  function update() {
    global $dbh;
    $columns = $values = [];
    foreach ($this->data as $column => $value) {
      $columns[] = "`$column` = ?";
      $values[] = $value;
    }
    $columns = join(', ', $columns);
    $values[] = $this->id;
    $sth = $dbh->prepare("UPDATE `$this->table` SET $columns WHERE `id` = ?");
    $sth->execute($values);
  }

  function insert() {
    global $dbh;
    $columns = $values = [];
    foreach ($this->data as $column => $value) {
      $columns[] = "`$column`";
      $placeholders[] = '?';
    }
    $columns = join(', ', $columns);
    $placeholders = join(', ', $placeholders);
    $sth = $dbh->prepare("INSERT INTO `$this->table` ($columns) VALUES ($placeholders)");
    $sth->execute(array_values($this->data));
    $this->id = $dbh->lastInsertId();
  }
}
