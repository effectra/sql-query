<?php

declare(strict_types=1);

namespace Effectra\SqlQuery;

class Delete
{
    private const DELETE_FROM = "DELETE FROM ";

    private string $query = '';
    private string $table = '';
    private ?string $condition = null;

    public function __construct(string $table)
    {
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

    public function where(string $condition): self
    {
        $this->condition = $condition;
        return $this;
    }

    public function truncate(): self
    {
        $this->query = "TRUNCATE TABLE {$this->table};";
        return $this;
    }

    public function deleteById(int|string $id): self
    {
        $this->query = self::DELETE_FROM . $this->table . " WHERE id = {$id};";
        return $this;
    }

    public function deleteByCondition(): self
    {
        $this->query = self::DELETE_FROM . $this->table . " WHERE {$this->condition};";
        return $this;
    }

    public function __toString(): string
    {
        return $this->query;
    }
}
