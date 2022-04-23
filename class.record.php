<?php
class Record {
  public Table $table;
  public $id;
  public $data = [];

  function __construct(Table $table, $id = 0) {
    $this->table = $table;
    $this->id = $id;
    if ($id) $this->loadData();
  }

  function loadData() {
    global $dbh;
    $select = '`' . join('`, `', array_column($this->table->columns, 'name')) . '`';
    $sth = $dbh->prepare("SELECT $select FROM `" . $this->table->name . "` WHERE `id` = ?");
    $sth->execute([$this->id]);
    $this->data = $sth->fetch(PDO::FETCH_ASSOC);
  }
}
