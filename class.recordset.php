<?php
class Recordset {
  public array $records;

  function __construct(public Table $table) {
    $this->load();
  }

  function load() {
    global $dbh;

    $sth = $dbh->prepare(sprintf('SELECT `id` FROM `%s`', $this->table->name));
    $sth->execute();
    $data = $sth->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $recordData) {
      $record = new Record($this->table, $recordData['id']);
      $this->records[] = $record;
    }
  }
}
