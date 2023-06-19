<?php

declare(strict_types=1);

namespace Effectra\SqlQuery;

class Delete
{
    private const DELETE_FROM = "DELETE FROM ";

    private string $query = '';
    private string $table = '';
    private ?string $condition = null;

    /**
     * Delete constructor.
     *
     * @param string $table The table name.
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
     * @return string The table name.
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * Set the condition for the WHERE clause.
     *
     * @param string $condition The condition for the WHERE clause.
     * @return $this The Delete instance.
     */
    public function where(string $condition): self
    {
        $this->condition = $condition;
        return $this;
    }

    /**
     * Set the query to truncate the table.
     *
     * @return $this The Delete instance.
     */
    public function truncate(): self
    {
        $this->query = "TRUNCATE TABLE {$this->table};";
        return $this;
    }

    /**
     * Set the query to delete by ID.
     *
     * @param int|string $id The ID to delete.
     * @return $this The Delete instance.
     */
    public function deleteById(int|string $id): self
    {
        $this->query = self::DELETE_FROM . $this->table . " WHERE id = {$id};";
        return $this;
    }

    /**
     * Set the query to delete by condition.
     *
     * @return $this The Delete instance.
     */
    public function deleteByCondition(): self
    {
        $this->query = self::DELETE_FROM . $this->table . " WHERE {$this->condition};";
        return $this;
    }

    /**
     * Get the generated SQL query.
     *
     * @return string The SQL query.
     */
    public function __toString(): string
    {
        return $this->query;
    }
}
