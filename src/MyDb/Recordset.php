<?php

namespace MyDb;

use \PDO;

class Recordset
{
    /** @var Record[] $records */
    public array $records = [];
    public int $recordcount;

    function __construct(
        private string $tableName,
        private array $select = [],
        private int $page = 1,
        private int $pagesize = 25,
    ) {
        $this->load();
    }

    function load()
    {
        global $dbh;

        // Count records
        $this->recordcount = $dbh->query(sprintf('SELECT COUNT(*) FROM `%s`', $this->tableName))->fetchColumn();

        // Build query
        if (count($this->select)) {
            $select = addBackticks('id,' . implode(',', $this->select));
        } else {
            $table = new Table($this->tableName);
            $select = ['`id`'];
            foreach ($table->columns as $column) {
                $select[] = "`$column->name`";
            }
            $select = join(', ', $select);
        }
        $sth = $dbh->prepare(
            sprintf(
                'SELECT %s FROM `%s` LIMIT :offset, :limit',
                $select,
                $this->tableName,
            )
        );
        $sth->bindValue('offset', ($this->page - 1) * $this->pagesize, PDO::PARAM_INT);
        $sth->bindValue('limit', $this->pagesize, PDO::PARAM_INT);
        $sth->execute();
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
        foreach ($data as $recordData) {
            $record = new Record($this->tableName);
            $record->setData($recordData);
            $this->records[] = $record;
        }
    }
}
