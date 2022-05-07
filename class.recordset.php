<?php
class Recordset {
  public array $records = [];

  function __construct(public string $tableName, array $select = []) {
    $this->load($select);
  }

  function load(array $select = []) {
    global $dbh;
    if (count($select)) {
      $select = addBackticks('id,' . implode(',', $select));
    } else {
      $table = new Table($this->tableName);
      $select = ['`id`'];
      foreach ($table->columns as $column) {
        $select[] = "`$column->name`";
      }
      $select = join(', ', $select);
    }
    $sth = $dbh->prepare(sprintf('SELECT %s FROM `%s`', $select, $this->tableName));
    $sth->execute();
    $data = $sth->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $recordData) {
      $record = new Record($this->tableName);
      $record->setData($recordData);
      $this->records[] = $record;
    }
  }
}
