<?php

declare(strict_types=1);

namespace Effectra\SqlQuery;

class Update
{
    use ConditionsTrait;

    private const UPDATE = "UPDATE ";
    private const SET = "SET ";
    private const WHERE = "WHERE ";

    private string $query = '';
    private string $table = '';
    private array $values = [];
    private array $columns = [];
    private $condition = null;

    /**
     * Update constructor.
     *
     * @param string $table The name of the table to update.
     */
    public function __construct(string $table)
    {
        $this->table = $table;
    }

    /**
     * Get the built SQL query.
     *
     * @return string The SQL query.
     */
    public function getQuery(): string
    {
        return $this->query;
    }

    /**
     * Get the name of the table to update.
     *
     * @return string The table name.
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * Get the values for the update operation.
     *
     * @return array The update values.
     */
    public function getValues(): array
    {
        return $this->values;
    }

    /**
     * Get the columns to be updated.
     *
     * @return array The columns to be updated.
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * Set the columns to be updated.
     *
     * @param array $columns The columns to be updated.
     * @return self
     */
    public function columns(array $columns): self
    {
        $this->columns = $columns;
        return $this;
    }

    /**
     * Set the values for the update operation.
     *
     * @param array $values The update values.
     * @return self
     */
    public function values(array $values): self
    {
        $this->values = $values;
        return $this;
    }

    /**
     * Combine the columns and values with additional data.
     *
     * @param array $data Additional data to combine with columns and values.
     * @return array The combined data.
     */
    public function combineColumnsValues(array $data = []): array
    {
        $combine = array_combine($this->columns, $this->values);
        return array_merge($combine, $data);
    }

    /**
     * Set the values for the update operation.
     *
     * @param array $values The update values.
     * @return self
     */
    public function set(array $values): self
    {
        $this->values = $values;
        return $this;
    }

    /**
     * Set the condition for the update operation.
     *
     * @param string|array $condition The condition for the update operation.
     * @return self
     */
    public function where(string|array $condition): self
    {
        $this->condition = $condition;
        return $this;
    }

    /**
     * Get the string representation of the update query.
     *
     * @return string The string representation of the update query.
     */
    public function __toString(): string
    {
        $this->buildQuery();
        return $this->query;
    }


    /**
     * Build the update query.
     *
     * @return void
     */
    private function buildQuery(): void
    {
        $this->query = self::UPDATE . $this->table . ' ' . self::SET;

        $setStatements = [];

        foreach ($this->columns as $column) {
            $setStatements[] = "`{$column}` = :{$column}";
        }

        $this->query .= implode(', ', $setStatements);

        if ($this->condition !== null) {
            $this->query .= ' ' . self::WHERE . $this->setConditions($this->condition);
        }
    }
}
