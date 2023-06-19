<?php

declare(strict_types=1);

namespace Effectra\SqlQuery;

/**
 * Class Alter
 * Represents a SQL query for altering a table.
 */
class Alter
{
    private $tableName;
    private $query;

    /**
     * Alter constructor.
     *
     * @param string $tableName The name of the table to be altered.
     */
    public function __construct(string $tableName)
    {
        $this->tableName = $tableName;
        $this->query = "ALTER TABLE $tableName";
    }

    /**
     * Clear the query.
     *
     * @return void
     */
    public function clear(): void
    {
        $this->query = '';
    }

    /**
     * Add a column to the table.
     *
     * @param string $column The column definition.
     * @return self
     */
    public function addColumn(string $column): self
    {
        $this->query .= " ADD $column";
        return $this;
    }

    /**
     * Modify a column in the table.
     *
     * @param string $column The column definition.
     * @return self
     */
    public function modifyColumn(string $column): self
    {
        $this->query .= " MODIFY $column";
        return $this;
    }

    /**
     * Drop a column from the table.
     *
     * @param string $columnName The name of the column to be dropped.
     * @return self
     */
    public function dropColumn(string $columnName): self
    {
        $this->query .= " DROP COLUMN $columnName";
        return $this;
    }

    /**
     * Add a primary key constraint to the table.
     *
     * @param string $columnName The name of the column to be used as the primary key.
     * @return self
     */
    public function addPrimaryKey(string $columnName): self
    {
        $this->query .= " ADD PRIMARY KEY ($columnName)";
        return $this;
    }

    /**
     * Add a foreign key constraint to the table.
     *
     * @param string $columnName        The name of the column to be used as the foreign key.
     * @param string $referencedTable   The name of the referenced table.
     * @param string $referencedColumn  The name of the referenced column.
     * @param string $constraintName    The name of the foreign key constraint.
     * @return self
     */
    public function addForeignKey(string $columnName, string $referencedTable, string $referencedColumn, string $constraintName): self
    {
        $this->query .= " ADD CONSTRAINT $constraintName FOREIGN KEY ($columnName) REFERENCES $referencedTable($referencedColumn)";
        return $this;
    }

    /**
     * Add a unique key constraint to the table.
     *
     * @param string $columnName The name of the column to be used as the unique key.
     * @return self
     */
    public function addUniqueKey(string $columnName): self
    {
        $this->query .= " ADD UNIQUE ($columnName)";
        return $this;
    }

    /**
     * Drop the primary key constraint from the table.
     *
     * @return self
     */
    public function dropPrimaryKey(): self
    {
        $this->query .= " DROP PRIMARY KEY";
        return $this;
    }

    /**
     * Drop a foreign key constraint from the table.
     *
     * @param string $constraintName The name of the foreign key constraint to be dropped.
     * @return self
     */
    public function dropForeignKey(string $constraintName): self
    {
        $this->query .= " DROP FOREIGN KEY $constraintName";
        return $this;
    }

    /**
     * Drop a unique key constraint from the table.
     *
     * @param string $keyName The name of the unique key constraint to be dropped.
     * @return self
     */
    public function dropUniqueKey(string $keyName): self
    {
        $this->query .= " DROP INDEX $keyName";
        return $this;
    }

    /**
     * Drop a key constraint from the table based on its type.
     *
     * @param string $name The name of the key constraint to be dropped.
     * @param string $type The type of the key constraint ('primary', 'unique', or 'foreign').
     * @return self
     */
    public function dropKey(string $name, string $type): self
    {
        if ($type === 'primary') {
            return $this->dropPrimaryKey();
        }

        if ($type === 'unique') {
            return $this->dropUniqueKey($name);
        }

        if ($type === 'foreign') {
            return $this->dropForeignKey($name);
        }

        return $this;
    }

    /**
     * Drop all key constraints from the table.
     *
     * @return self
     */
    public function dropAllKeys(): self
    {
        $this->query .= " DROP PRIMARY KEY, DROP FOREIGN KEY, DROP INDEX";
        return $this;
    }

    /**
     * Get the string representation of the object.
     *
     * @return string The string representation of the object.
     */
    public function __toString(): string
    {
        return $this->query;
    }
}
