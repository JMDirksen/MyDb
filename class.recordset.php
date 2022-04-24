<?php
class Recordset {
  public array $records = [];

  function __construct(public string $tableName) {
    $this->load();
  }

  function load() {
    global $dbh;

    $sth = $dbh->prepare(sprintf('SELECT * FROM `%s`', $this->tableName));
    $sth->execute();
    $data = $sth->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $recordData) {
      $record = new Record($this->tableName);
      $record->setData($recordData);
      $this->records[] = $record;
    }
  }
}
