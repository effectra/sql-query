<?php

declare(strict_types=1);

namespace Effectra\SqlQuery;

class CreateTable
{
    private const CREATE_TABLE = "CREATE TABLE ";
    private const IF_NOT_EXISTS = " IF NOT EXISTS ";
    private const OPENING_BRACKET = " (";
    private const CLOSING_BRACKET = ")";
    private const ENGINE = " ENGINE=";
    private const CHARSET = " DEFAULT CHARSET=";

    private string $query = '';
    private string $table = '';
    private string $engine = 'InnoDB';
    private string $charset = 'utf8mb4';

    private bool $ifNotExists = true;

    private array $columns = [];
    private array $keys = [];

    /**
     * CreateTable constructor.
     *
     * @param string $table The name of the table.
     * @param array $columns An array of column definitions.
     * @param array $keys An array of keys to add to the table (optional).
     */
    public function __construct(string $table, array $columns, array $keys = [])
    {
        $this->table = $table;
        $this->columns = $columns;
        $this->keys = $this->filter($keys);
    }

    /**
     * Filters the array to remove empty or non-string keys.
     *
     * @param array $keys The array of keys to filter.
     * @return array The filtered array.
     */
    public function filter(array $keys): array
    {
        return array_filter($keys, function ($key) {
            return is_string($key) && !empty($key);
        });
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
     * Set the table's engine.
     *
     * @param string $engine The engine to set.
     * @return $this The CreateTable instance.
     */
    public function engine(string $engine): self
    {
        $this->engine = $engine;
        return $this;
    }

    /**
     * Set the table's charset.
     *
     * @param string $charset The charset to set.
     * @return $this The CreateTable instance.
     */
    public function charset(string $charset): self
    {
        $this->charset = $charset;
        return $this;
    }

    /**
     * Set whether the table should be created only if it doesn't exist.
     *
     * @param bool $act The flag to set.
     * @return $this The CreateTable instance.
     */
    public function exists(bool $act = false): self
    {
        $this->ifNotExists = !$act;
        return $this;
    }

    /**
     * Generate the SQL query.
     *
     * @return string The generated SQL query.
     */
    public function __toString(): string
    {
        $this->buildQuery();
        return $this->query;
    }

    /**
     * Build the SQL query.
     *
     * @return void
     */
    private function buildQuery(): void
    {
        $this->query = self::CREATE_TABLE;

        if ($this->ifNotExists) {
            $this->query .= self::IF_NOT_EXISTS;
        }

        $this->query .= $this->table . self::OPENING_BRACKET;

        $this->query .= join(', ', $this->columns);

        if (!empty($this->keys)) {
            $this->query .= ',' . join(',', $this->keys);
        }

        $this->query .= self::CLOSING_BRACKET;

        if (!empty($this->engine)) {
            $this->query .= self::ENGINE . $this->engine;
        }

        if (!empty($this->charset)) {
            $this->query .= self::CHARSET . $this->charset;
        }
    }
}
