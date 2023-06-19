<?php

declare(strict_types=1);

namespace Effectra\SqlQuery;

class Drop
{
    private const DROP_TABLE = "DROP TABLE ";
    private const DROP_INDEX = "DROP INDEX ";
    private const DROP_KEY = "ALTER TABLE ";
    private const IF_EXISTS = " IF EXISTS ";

    private string $query = '';
    private string $table = '';
    private string $index = '';
    private string $key = '';

    private ?array $action;

    /**
     * Drop constructor.
     *
     * @param string $table The table name.
     * @param array|null $action The action parameters.
     */
    public function __construct(string $table, ?array $action = null)
    {
        $this->table = $table;
        $this->action = $action;
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
     * Set the table name.
     *
     * @param string $table The table name.
     * @return $this The Drop instance.
     */
    public function table(string $table): self
    {
        $this->table = $table;
        return $this;
    }

    /**
     * Set the index name.
     *
     * @param string $index The index name.
     * @return $this The Drop instance.
     */
    public function index(string $index): self
    {
        $this->index = $index;
        return $this;
    }

    /**
     * Set the foreign key name.
     *
     * @param string $key The foreign key name.
     * @return $this The Drop instance.
     */
    public function foreignKey(string $key): self
    {
        $this->key = $key;
        return $this;
    }

    /**
     * Set the query to drop a table.
     *
     * @param bool $if_exists Whether to add IF EXISTS clause.
     * @return $this The Drop instance.
     */
    public function dropTable(bool $if_exists = false): self
    {
        $exists = $if_exists ? self::IF_EXISTS : '';
        $this->query = self::DROP_TABLE . $this->table . $exists . " ;";
        return $this;
    }

    /**
     * Set the query to drop a column.
     *
     * @param string $column The column name.
     * @return $this The Drop instance.
     */
    public function dropColumn(string $column): self
    {
        $this->query = "ALTER TABLE {$this->table} DROP COLUMN {$column};";
        return $this;
    }

    /**
     * Set the query to drop an index.
     *
     * @return $this The Drop instance.
     */
    public function dropIndex(): self
    {
        $this->query = self::DROP_INDEX . $this->index . ";";
        return $this;
    }

    /**
     * Set the query to drop a primary key.
     *
     * @return $this The Drop instance.
     */
    public function dropPrimaryKey(): self
    {
        $this->query = self::DROP_KEY . $this->table . " DROP PRIMARY KEY " . $this->key . ";";
        return $this;
    }

    /**
     * Set the query to drop a foreign key.
     *
     * @return $this The Drop instance.
     */
    public function dropForeignKey(): self
    {
        $this->query = self::DROP_KEY . $this->table . " DROP FOREIGN KEY " . $this->key . ";";
        return $this;
    }

    /**
     * Get the generated SQL query.
     *
     * @return string The SQL query.
     */
    public function __toString(): string
    {
        $this->buildQuery();
        return $this->query;
    }

    /**
     * Build the query based on the provided action.
     *
     * @return $this The Drop instance.
     */
    public function buildQuery(): self
    {
        if ($this->action) {
            if ($this->action['act'] === 'column') {
                return $this->dropColumn($this->action['name']);
            }
            if ($this->action['act'] === 'table') {
                return $this->dropTable();
            }
            if ($this->action['act'] === 'table_if_exists') {
                return $this->dropTable(true);
            }
        }
        return $this;
    }

}
