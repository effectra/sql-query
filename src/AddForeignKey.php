<?php

declare(strict_types=1);

namespace Effectra\SqlQuery;

use PDO;

/**
 * Class AddForeignKey
 * Represents a SQL query for adding a foreign key constraint to a table.
 */
class AddForeignKey
{
    private const ALTER_TABLE = "ALTER TABLE ";
    private const ADD_CONSTRAINT = "ADD CONSTRAINT ";

    private string $query = '';
    private string $table = '';
    private string $constraintName = '';
    private string $column = '';
    private string $referencedTable = '';
    private string $referencedColumn = '';
    private string $onDelete = '';

    /**
     * AddForeignKey constructor.
     *
     * @param string $table The name of the table to add the foreign key constraint to.
     */
    public function __construct(string $table)
    {
        $this->table = $table;
    }

    /**
     * Get the generated SQL query.
     *
     * @return string The SQL query.
     */
    public function getQuery(): string
    {
        return $this->query;
    }

    /**
     * Get the name of the table.
     *
     * @return string The name of the table.
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * Set the name of the foreign key constraint.
     *
     * @param string $constraintName The name of the constraint.
     * @return self
     */
    public function constraintName(string $constraintName): self
    {
        $this->constraintName = $constraintName;
        return $this;
    }

    /**
     * Set the column to add the foreign key constraint to.
     *
     * @param string $column The name of the column.
     * @return self
     */
    public function column(string $column): self
    {
        $this->column = $column;
        return $this;
    }

    /**
     * Set the referenced table and column for the foreign key constraint.
     *
     * @param string $referencedTable The name of the referenced table.
     * @param string $referencedColumn The name of the referenced column.
     * @return self
     */
    public function references(string $referencedTable, string $referencedColumn): self
    {
        $this->referencedTable = $referencedTable;
        $this->referencedColumn = $referencedColumn;
        return $this;
    }

    /**
     * Set the ON DELETE action for the foreign key constraint.
     *
     * @param string $action The ON DELETE action.
     * @return self
     */
    public function onDelete(string $action): self
    {
        $this->onDelete = $action;
        return $this;
    }

    /**
     * Get the string representation of the object.
     *
     * @return string The string representation.
     */
    public function __toString(): string
    {
        $this->buildQuery();
        return $this->query;
    }

    /**
     * Execute the SQL query.
     *
     * @param PDO $pdo The PDO object to execute the query with.
     * @return bool True if the query was successfully executed, false otherwise.
     */
    public function execute(PDO $pdo): bool
    {
        $this->buildQuery();

        $stmt = $pdo->prepare($this->query);
        $success = $stmt->execute();

        return $success;
    }

    /**
     * Build the SQL query.
     *
     * @return void
     */
    private function buildQuery(): void
    {
        $this->query = self::ALTER_TABLE . $this->table . ' ' . self::ADD_CONSTRAINT;
        $this->query .= '`' . $this->constraintName . '` ';
        $this->query .= 'FOREIGN KEY (`' . $this->column . '`) ';
        $this->query .= 'REFERENCES `' . $this->referencedTable . '` (`' . $this->referencedColumn . '`)';

        if (!empty($this->onDelete)) {
            $this->query .= ' ON DELETE ' . $this->onDelete;
        }
    }
}
