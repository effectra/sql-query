<?php

declare(strict_types=1);

namespace Effectra\SqlQuery;

use PDO;

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

    public function __construct($table, $action = null)
    {
        $this->table = $table;
        $this->action = $action;
    }

    public function getQuery(): string
    {
        return $this->query;
    }

    public function table(string $table): self
    {
        $this->table = $table;
        return $this;
    }

    public function index(string $index): self
    {
        $this->index = $index;
        return $this;
    }

    public function foreignKey(string $key): self
    {
        $this->key = $key;
        return $this;
    }

    public function dropTable($if_exists = false): self
    {
        $exists = $if_exists ? self::IF_EXISTS : '';
        $this->query = self::DROP_TABLE . $this->table . $exists . " ;";
        return $this;
    }

    public function dropColumn(string $column): self
    {
        $this->query = "ALTER TABLE {$this->table} DROP COLUMN {$column};";
        return $this;
    }

    public function dropIndex(): self
    {
        $this->query = self::DROP_INDEX . $this->index . ";";
        return $this;
    }

    public function dropPrimaryKey(): self
    {
        $this->query = self::DROP_KEY . $this->table . " DROP PRIMARY KEY " . $this->key . ";";
        return $this;
    }

    public function dropForeignKey(): self
    {
        $this->query = self::DROP_KEY . $this->table . " DROP FOREIGN KEY " . $this->key . ";";
        return $this;
    }

    public function __toString(): string
    {
        $this->buildQuery();
        return $this->query;
    }

    public function buildQuery()
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
    }

    public function execute(PDO $pdo): bool
    {
        $stmt = $pdo->prepare($this->query);
        $success = $stmt->execute();

        return $success;
    }
}
