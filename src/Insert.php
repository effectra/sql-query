<?php

declare(strict_types=1);

namespace Effectra\SqlQuery;

class Insert
{
    use ToStringTrait;

    private const INSERT_INTO = "INSERT INTO ";

    private string $query = '';
    private string $table = '';
    private array $columns = [];
    private array $values = [];

    /**
     * Insert constructor.
     *
     * @param string $table The table to insert into.
     */
    public function __construct(string $table)
    {
        $this->table = $table;
    }

    /**
     * Get the generated query.
     *
     * @return string The generated query.
     */
    public function getQuery(): string
    {
        return $this->query;
    }

    /**
     * Get the table being inserted into.
     *
     * @return string The table name.
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * Get the columns being inserted.
     *
     * @return array The column names.
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * Get the values being inserted.
     *
     * @return array The values.
     */
    public function getValues(): array
    {
        return $this->values;
    }

    /**
     * Set the columns for the insert statement.
     *
     * @param array $columns The column names.
     * @return self
     */
    public function columns(array $columns): self
    {
        $this->columns = $columns;
        return $this;
    }

    /**
     * Set the values for the insert statement.
     *
     * @param array $values The values.
     * @return self
     */
    public function values(array $values): self
    {
        $this->values = $values;
        return $this;
    }

    /**
     * Generate the string representation of the insert statement.
     *
     * @return string The string representation of the insert statement.
     */
    public function __toString(): string
    {
        $this->buildQuery();
        return $this->query;
    }

    /**
     * Build the insert query.
     *
     * @throws \Exception When no columns are specified.
     */
    private function buildQuery(): void
    {
        $this->query = self::INSERT_INTO . $this->table;

        if (empty($this->columns)) {
            throw new \Exception("No columns specified for insertion.");
        }

        $this->query .= " (" . implode(", ", $this->columns) . ")";

        if (!empty($this->values)) {
            $placeholders = array_fill(0, count($this->columns), "?");
            $this->query .= " VALUES (" . $this->valuesList($placeholders) . ")";
        }

        $this->query .= ';';
    }

    /**
     * Flatten the values array.
     *
     * @return array The flattened values.
     */
    public function flattenValues(): array
    {
        $flattenedValues = [];

        foreach ($this->values as $valueSet) {
            $flattenedValues = array_merge($flattenedValues, $valueSet);
        }

        return $flattenedValues;
    }
}
