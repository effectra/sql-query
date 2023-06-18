<?php

declare(strict_types=1);

namespace Effectra\SqlQuery;

class Alter
{
    private $tableName;
    private $query;

    public function __construct($tableName)
    {
        $this->tableName = $tableName;
        $this->query = "ALTER TABLE $tableName";
    }

    public function clear()
    {
        $this->query = '';
    }

    public function addColumn($column)
    {
        $this->query .= " ADD $column";
        return $this;
    }

    public function modifyColumn($column)
    {
        $this->query .= " MODIFY $column";
        return $this;
    }

    public function dropColumn($columnName)
    {
        $this->query .= " DROP COLUMN $columnName";
        return $this;
    }

    public function addPrimaryKey($columnName)
    {
        $this->query .= " ADD PRIMARY KEY ($columnName)";
        return $this;
    }

    public function addForeignKey($columnName, $referencedTable, $referencedColumn, $constraintName)
    {
        $this->query .= " ADD CONSTRAINT $constraintName FOREIGN KEY ($columnName) REFERENCES $referencedTable($referencedColumn)";
        return $this;
    }

    public function addUniqueKey($columnName)
    {
        $this->query .= " ADD UNIQUE ($columnName)";
        return $this;
    }

    public function dropPrimaryKey()
    {
        $this->query .= " DROP PRIMARY KEY";
        return $this;
    }

    public function dropForeignKey($constraintName)
    {
        $this->query .= " DROP FOREIGN KEY $constraintName";
        return $this;
    }

    public function dropUniqueKey($keyName)
    {
        $this->query .= " DROP INDEX $keyName";
        return $this;
    }

    public function dropKey($name, $type)
    {
        if($type === 'primary'){
            return $this->dropPrimaryKey($name);
        }
        if($type === 'unique'){
            return $this->dropUniqueKey($name);
        }
        if($type === 'foreign'){
            return $this->dropForeignKey($name);
        }
        return '';
    }

    public function dropAllKeys()
    {
        $this->query .= " DROP PRIMARY KEY, DROP FOREIGN KEY, DROP INDEX";
        return $this;
    }

    public function __toString()
    {
        return $this->query;
    }
}
