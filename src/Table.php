<?php

declare(strict_types=1);

namespace Effectra\SqlQuery;


class Table
{

    protected string $tableName;
    protected array $cols = [];
    protected array $columns = [];

    public function __construct(string $tableName)
    {
        $this->tableName = $tableName;
    }

    public function setTableName($tableName)
    {
        $this->tableName = $tableName;
    }

    public function getTableName()
    {
        return $this->tableName;
    }

    public function setColumns($columns)
    {
        $this->columns = $columns;
    }

    public function getColumns()
    {
        return $this->columns;
    }

    public function columnsExists($columns)
    {
        return in_array($columns, $this->getColumns());
    }

    public function id($name = 'id')
    {
        return $this->bigInteger($name)->size(20);
    }

    public function autoIncrement($name = 'id')
    {
        $col = ['name' => $name, 'type' => 'bigint', 'size' => 20, 'auto_increment' => true, 'key' => 'primary'];
        $this->cols[] = $col;
        return $this;
    }

    public function text($name)
    {
        $col = ['name' => $name, 'type' => 'text'];
        $this->cols[] = $col;
        return $this;
    }

    public function string($name)
    {
        return $this->varchar($name);
    }

    public function varchar($name)
    {
        $col = ['name' => $name, 'type' => 'varchar', 'size' => 255];
        $this->cols[] = $col;
        return $this;
    }

    public function char($name)
    {
        $col = ['name' => $name, 'type' => 'char', 'size' => 4];
        $this->cols[] = $col;
        return $this;
    }

    public function longText($name)
    {
        $col = ['name' => $name, 'type' => 'longtext'];
        $this->cols[] = $col;
        return $this;
    }

    public function decimal($name, $total = 8, $places = 2)
    {
        $col = ['name' => $name, 'type' => 'decimal', 'size' => "$total,$places"];
        $this->cols[] = $col;
        return $this;
    }

    public function boolean($name)
    {
        return $this->tinyint($name)->size(1);
    }

    public function integer($name)
    {
        return $this->int($name);
    }

    public function int($name)
    {
        $col = ['name' => $name, 'type' => 'int'];
        $this->cols[] = $col;
        return $this;
    }

    public function tinyint($name)
    {
        $col = ['name' => $name, 'type' => 'tinyint', 'size' => 1];
        $this->cols[] = $col;
        return $this;
    }

    public function bigInteger($name)
    {
        $col = ['name' => $name, 'type' => 'bigint', 'size' => 20];
        $this->cols[] = $col;
        return $this;
    }

    public function blob($name)
    {
        $col = ['name' => $name, 'type' => 'blob'];
        $this->cols[] = $col;
        return $this;
    }
    public function timestamp($name, $default_current_time = false)
    {
        $col = ['name' => $name, 'type' => 'timestamp', 'nullable' => true, 'default' => 'NULL'];
        if ($default_current_time) {
            $col['default'] = 'CURRENT_TIMESTAMP';
        }

        $this->cols[] = $col;

        return $this;
    }
    public function timestamps($default_current_time = true)
    {
        $created_at = ['name' => 'created_at', 'type' => 'timestamp', 'nullable' => true, 'default' => 'NULL'];
        $updated_at = ['name' => 'updated_at', 'type' => 'timestamp', 'nullable' => true, 'default' => 'NULL'];

        if ($default_current_time) {
            $created_at['default'] = 'CURRENT_TIMESTAMP';
            $updated_at['default'] = 'CURRENT_TIMESTAMP';
        }

        $this->cols[] = $created_at;
        $this->cols[] = $updated_at;

        return $this;
    }

    public function date($name)
    {
        $col = ['name' => $name, 'type' => 'date'];
        $this->cols[] = $col;
        return $this;
    }

    public function time($name)
    {
        $col = ['name' => $name, 'type' => 'time'];
        $this->cols[] = $col;
        return $this;
    }

    public function year($name)
    {
        $col = ['name' => $name, 'type' => 'year'];
        $this->cols[] = $col;
        return $this;
    }

    public function nullable()
    {
        $lastCol = &$this->cols[count($this->cols) - 1];
        $lastCol['nullable'] = true;
        return $this;
    }

    public function useCurrentTime()
    {
        $lastCol = &$this->cols[count($this->cols) - 1];
        $lastCol['default'] = 'CURRENT_TIMESTAMP';
        return $this;
    }

    public function currentTime($name)
    {
        $col = ['name' => $name, 'type' => 'timestamp', 'default' => 'CURRENT_TIMESTAMP'];
        $this->cols[] = $col;
        return $this;
    }

    public function json($name)
    {
        $col = [
            'name' => $name,
            'type' => 'longtext',
            'check' => "json_valid(`$name`)"
        ];
        $this->cols[] = $col;
        return $this;
    }

    public function enum($name, array $values)
    {
        $col = [
            'name' => $name,
            'type' => '',
            'enum_values' => $values
        ];
        $this->cols[] = $col;
        return $this;
    }

    public function enumStatus($name = 'status')
    {
        $col = [
            'name' => $name,
            'type' => '',
            'enum_values' => ['pending', 'approved', 'declined', 'removed'],
        ];
        $this->cols[] = $col;
        return $this->default('pending');
    }

    public function default($value)
    {

        $lastCol = &$this->cols[count($this->cols) - 1];

        if (is_string($value)) {
            $value = "'" . $value . "'";
        }

        if (is_array($value) || $lastCol['type'] === 'json') {
            $value = "'" . json_encode($value) . "'";
        }

        $lastCol['default'] =  $value;
        return $this;
    }

    public function size($size = 255)
    {
        $lastCol = &$this->cols[count($this->cols) - 1];
        $lastCol['size'] = $size;
        return $this;
    }

    public function collate($value = 'utf8mb4_unicode_ci')
    {
        $lastCol = &$this->cols[count($this->cols) - 1];
        $lastCol['collate'] = $value;
        return $this;
    }

    public function unique()
    {
        $lastCol = &$this->cols[count($this->cols) - 1];
        $lastCol['key'] = 'unique';
        return $this;
    }

    public function unsigned()
    {
        $lastCol = &$this->cols[count($this->cols) - 1];
        $lastCol['unsigned'] = true;
        return $this;
    }

    public function after($columnName)
    {
        $lastCol = &$this->cols[count($this->cols) - 1];
        $lastCol['after'] = $columnName;
        return $this;
    }

    public function primaryKey()
    {
        $lastCol = &$this->cols[count($this->cols) - 1];
        // $lastCol['name'] = $columnName;
        $lastCol['key'] = 'primary';
        return $this;
    }

    public function charset($charset)
    {
        $lastCol = &$this->cols[count($this->cols) - 1];
        $lastCol['charset'] = $charset;
        return $this;
    }

    public function drop()
    {
        $col = ['name' => $this->tableName, 'modify' => 'drop', 'act' => 'table'];
        $this->cols[] = $col;
        return $this;
    }

    public function dropIfExists()
    {
        $col = ['name' => $this->tableName, 'modify' => 'drop', 'act' => 'table_if_exists'];
        $this->cols[] = $col;
        return $this;
    }

    public function dropColumn($name)
    {
        $col = ['name' => $name, 'modify' => 'drop', 'act' => 'column'];
        $this->cols[] = $col;
        return $this;
    }

    public function dropKey($name, $type)
    {
        $col = ['name' => $name, 'modify' => 'drop', 'act' => 'key', 'type' => $type];
        $this->cols[] = $col;
        return $this;
    }

    public function renameColumn($from, $to)
    {
        $col = ['tableName' => $from, 'to' => $to, 'act' => 'rename_table'];
        $this->cols[] = $col;
        return $this;
    }

    public function addForeignKey($columnName, $foreignTable, $foreignColumn)
    {
        $lastCol = &$this->cols[count($this->cols) - 1];
        $lastCol['foreign_key'] = [
            'column_name' => $columnName,
            'foreign_table' => $foreignTable,
            'foreign_column' => $foreignColumn
        ];
        return $this;
    }

    public function constraintName($name)
    {
        $lastCol = &$this->cols[count($this->cols) - 1];
        $lastCol['constraint_name'] = $name;
        return $this;
    }

    public function references($columnName, $foreignTable, $foreignColumn)
    {
        $lastCol = &$this->cols[count($this->cols) - 1];
        $lastCol['references'] = [
            'column_name' => $columnName,
            'foreign_table' => $foreignTable,
            'foreign_column' => $foreignColumn
        ];
        return $this;
    }

    public function buildQuery($act = 'create')
    {
        $query = '';
        if ($act === 'modify') {
            foreach ($this->cols as $col) {
                $alter = new Alter($this->tableName);

                if (isset($col['modify']) && $col['modify'] === 'drop') {
                    if (isset($col['act']) && $col['act'] === 'column')  $query .= (string) $alter->dropColumn($col['name']) . ';';

                    if (isset($col['act']) && $col['act'] === 'key')  $query .= (string) $alter->dropKey($col['name'], $col['type']) . ';';
                }
                if (!isset($col['modify'])) {
                    if ($this->columnsExists($col['name'])) {
                        $query .= (string) $alter->modifyColumn((string) new Column($col) . $this->keysQuery($col, false)) . ';';
                    }
                    if (!$this->columnsExists($col['name'])) {
                        $query .= (string) $alter->addColumn((string) new Column($col) . $this->keysQuery($col, false)) . ';';
                    }
                }
            }

            return $query;
        }
        if ($act === 'create') {
            return $this->createTableQuery();
        }
    }


    public function columnsQuery()
    {
        return array_map(fn ($col) =>  (string) new Column($col), $this->cols);
    }

    public function keysQuery($col, $withColumnName = true)
    {
        return isset($col['key']) ? (string) (new Key($col['name'], $col['key']))->withColumnName($withColumnName)->build() : '';
    }

    public function keysQueryTable()
    {
        return array_map(fn ($col) => $this->keysQuery($col), $this->cols);
    }

    public function createTableQuery()
    {
        return (string) new CreateTable($this->tableName, $this->columnsQuery(), $this->keysQueryTable());
    }

    public function dropColumnInTableQuery()
    {
        $queryCols = [];
        foreach ($this->cols as $col) {
            $alter = new Alter($this->tableName);
            $queryCols[] = (string) $alter->dropColumn($col['name']);
        }
        return join(';', $queryCols);
    }

    public function modifyColumnInTableQuery()
    {
        $queryCols = [];
        foreach ($this->cols as $col) {
            $alter = new Alter($this->tableName);
            $queryCols[] = (string) $alter->modifyColumn((string) new Column($col) . $this->keysQuery($col, false));
        }
        return join(';', $queryCols);
    }

    public function addColumnInTableQuery()
    {
        $queryCols = [];
        foreach ($this->cols as $col) {
            $alter = new Alter($this->tableName);
            $queryCols[] =  (string) $alter->modifyColumn((string) new Column($col) . $this->keysQuery($col, false));
        }
        return join(';', $queryCols);
    }



    public function __toString()
    {
        return $this->buildQuery();
    }
}
