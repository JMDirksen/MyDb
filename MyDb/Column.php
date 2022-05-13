<?php

namespace MyDb;

use \PDO;

class Column
{

    function __construct(
        public string $table,
        public string $name,
        bool $new = false,
        public string $type = '',
        public string $display_name = '',
    ) {
        if (!isset($this->display_name)) $this->display_name = ucfirst($name);
        if (!$new) $this->load();
    }

    function load(): void
    {
        global $dbh;

        $sth = $dbh->prepare(
            'SELECT `table`, `name`, `display_name`, `type` FROM `s_column` WHERE `table` = ? AND `name` = ?'
        );
        $sth->execute([$this->table, $this->name]);
        $column = $sth->fetch(PDO::FETCH_ASSOC);
        $this->table = $column['table'];
        $this->name = $column['name'];
        $this->display_name = $column['display_name'];
        $this->type = $column['type'];
    }

    function getHtmlType(): string
    {
        switch ($this->type) {
            case 'datetime':
                return 'datetime-local';
            default:
                return $this->type;
        }
    }

    function getSqlType(): string
    {
        switch ($this->type) {
            case 'text':
                return 'VARCHAR(255)';
            case 'number':
                return 'INT';
            case 'checkbox':
                return 'BOOLEAN';
            default:
                return strtoupper($this->type);
        }
    }
}
