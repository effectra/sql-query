<?php

declare(strict_types=1);

namespace Effectra\SqlQuery;

class Insert {
    use ToStringTrait;

    private const INSERT_INTO = "INSERT INTO ";

    private string $query = '';
    private string $table = '';
    private array $columns = [];
    private array $values = [];

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

    public function getValues()
    {
        return $this->values;
    }

    public function getColumns()
    {
        return $this->columns;
    }

    public function columns(array $columns): self
    {
        $this->columns = $columns;
        return $this;
    }

    public function values(array $values): self
    {
        $this->values = $values;
        return $this;
    }

    public function __toString(): string
    {
        $this->buildQuery();
        return $this->query;
    }

    private function buildQuery(): void
    {
        $this->query = self::INSERT_INTO . $this->table;

        if (empty($this->columns)) {
            throw new \Exception("No columns specified for insertion.");
        }

        $this->query .= " (" . implode(", ", $this->columns) . ")";

        if (!empty($this->values)) {
            $placeholders = array_fill(0, count($this->columns), "?");
            $this->query .= " VALUES (". $this->valuesList($this->values) .")"  ;
        }

        $this->query .= ';';
    }

    public function flattenValues(): array
    {
        $flattenedValues = [];

        foreach ($this->values as $valueSet) {
            $flattenedValues = array_merge($flattenedValues, $valueSet);
        }

        return $flattenedValues;
    }
}
