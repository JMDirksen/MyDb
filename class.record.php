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
    if ($id) $this->loadData();
  }

  function loadData() {
    global $dbh;
    $select = '`' . join('`, `', array_column($this->columns, 'name')) . '`';
    $sth = $dbh->prepare("SELECT $select FROM `$this->table` WHERE `id` = ?");
    $sth->execute([$this->id]);
    $this->data = $sth->fetch(PDO::FETCH_ASSOC);
  }
}
