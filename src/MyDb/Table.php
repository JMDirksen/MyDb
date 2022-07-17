<?php

namespace MyDb;

use \PDO;

class Table
{
    public string $display_name;
    public bool $new;
    /** @var Column[] $columns */
    public array $columns = [];

    function __construct(public string $name, bool $new = false)
    {
        $this->display_name = ucfirst($name);
        $this->new = $new;

        if (!$new) $this->load();
    }

    function load(): void
    {
        global $dbh;

        // Load table
        $sth = $dbh->prepare('SELECT `name`, `display_name` FROM `s_table` WHERE `name` = ?');
        $sth->execute([$this->name]);
        $table = $sth->fetch(PDO::FETCH_ASSOC);
        $this->name = $table['name'];
        $this->display_name = $table['display_name'];

        // Load columns
        $sth = $dbh->prepare('SELECT `name` FROM `s_column` WHERE `table` = ?');
        $sth->execute([$this->name]);
        $columns = $sth->fetchAll(PDO::FETCH_ASSOC);
        foreach ($columns as $column) {
            $this->columns[$column['name']] = new Column($this->name, $column['name']);
        }
    }

    function save(): void
    {
        global $dbh;

        if (str_starts_with($this->name, 's_')) die('Table prefix s_ is reserved for system tables');

        if ($this->new) {
            if (!$dbh->beginTransaction()) die('Unable to start transaction');

            // Save metadata table
            $sth = $dbh->prepare('INSERT INTO `s_table` (`name`, `display_name`) VALUES (?, ?)');
            $sth->execute([$this->name, $this->display_name]);

            // Save metadata columns
            if (count($this->columns)) {
                foreach ($this->columns as $column) {
                    $sth = $dbh->prepare('INSERT INTO `s_column` (`table`, `name`, `display_name`, `type`) VALUES (?, ?, ?, ?)');
                    $sth->execute([$column->table, $column->name, $column->display_name, $column->type]);
                }
            }

            $dbh->commit();

            // Save table
            foreach ($this->columns as $column) {
                $name = $column->name;
                $sqlType = $column->getSqlType();
                $columnstring[] = "`$name` $sqlType";
            }
            $columnstring = (isset($columnstring)) ? ', ' . join(', ', $columnstring) : '';
            $sth = $dbh->prepare("CREATE TABLE `$this->name` (`id` INT AUTO_INCREMENT PRIMARY KEY $columnstring)");
            $sth->execute();
        }
    }

    function addColumn(Column $column): void
    {
        global $dbh;

        // Save metadata column
        $sth = $dbh->prepare(
            'INSERT INTO `s_column` (`table`, `name`, `display_name`, `type`) VALUES (?, ?, ?, ?)'
        );
        $sth->execute([$column->table, $column->name, $column->display_name, $column->type]);

        // Save column
        $sth = $dbh->prepare(sprintf(
            'ALTER TABLE `%s` ADD `%s` %s',
            $this->name,
            $column->name,
            $column->getSqlType(),
        ));
        $sth->execute();

        $this->columns[] = $column;
    }

    function getRecord(int $id): Record
    {
        return new Record($this->name, $id);
    }

    function addRecord(array $values): Record
    {
        $record = new Record($this->name);
        $record->data = $values;
        $record->save();
        return $record;
    }

    function deleteRecord(int $id): void
    {
        $record = new Record($this->name, $id);
        $record->delete();
    }
}
