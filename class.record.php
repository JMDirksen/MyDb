<?php
class Record {
  public array $columns;
  public array $data;

  function __construct(public string $tableName, public int $id = 0) {
    $this->columns = (new Table($tableName))->columns;
    if ($id) $this->load();
  }

  function load() {
    global $dbh;
    $select = '`' . join('`, `', array_column($this->columns, 'name')) . '`';
    $sth = $dbh->prepare("SELECT $select FROM `$this->tableName` WHERE `id` = ?");
    $sth->execute([$this->id]);
    $this->data = $sth->fetch(PDO::FETCH_ASSOC);
  }

  function setData(array $data) {
    if (isset($data['id'])) {
      $this->id = $data['id'];
      unset($data['id']);
    }
    $this->data = $data;
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
    $sth = $dbh->prepare("UPDATE `$this->tableName` SET $columns WHERE `id` = ?");
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
    $sth = $dbh->prepare("INSERT INTO `$this->tableName` ($columns) VALUES ($placeholders)");
    $sth->execute(array_values($this->data));
    $this->id = $dbh->lastInsertId();
  }

  function delete() {
    global $dbh;
    $sth = $dbh->prepare("DELETE FROM `$this->tableName` WHERE `id` = ?");
    $sth->execute([$this->id]);
  }
}
