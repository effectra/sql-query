<?php

declare(strict_types=1);

namespace Effectra\SqlQuery;

use PDO;

class AddForeignKey {
    private const ALTER_TABLE = "ALTER TABLE ";
    private const ADD_CONSTRAINT = "ADD CONSTRAINT ";

    private string $query = '';
    private string $table = '';
    private string $constraintName = '';
    private string $column = '';
    private string $referencedTable = '';
    private string $referencedColumn = '';
    private string $onDelete = '';

    public function __construct(string $table) {
        $this->table = $table;
    }

    public function getQuery(): string
    {
        return $this->query;
    }

    public function getTable(): string
    {
        return $this->table;
    }

    public function constraintName(string $constraintName): self
    {
        $this->constraintName = $constraintName;
        return $this;
    }

    public function column(string $column): self
    {
        $this->column = $column;
        return $this;
    }

    public function references(string $referencedTable, string $referencedColumn): self
    {
        $this->referencedTable = $referencedTable;
        $this->referencedColumn = $referencedColumn;
        return $this;
    }

    public function onDelete(string $action): self
    {
        $this->onDelete = $action;
        return $this;
    }

    public function __toString(): string
    {
        $this->buildQuery();
        return $this->query;
    }

    public function execute(PDO $pdo): bool
    {
        $this->buildQuery();

        $stmt = $pdo->prepare($this->query);
        $success = $stmt->execute();

        return $success;
    }

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
