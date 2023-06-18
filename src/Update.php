<?php

declare(strict_types=1);

namespace Effectra\SqlQuery;

use PDO;

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
 
    public function combineColumnsValues($data = [])
    {
        $combine =  array_combine($this->columns, $this->values);
        return array_merge($combine, $data);
    }

    // public function flattenValues(): array
    // {
    //     $flattenedValues = [];
    //     foreach ($this->values as $valueSet) {
    //         $flattenedValues = array_merge($flattenedValues, $valueSet);
    //     }

    //     return $flattenedValues;
    // }

    public function set(array $values): self
    {
        $this->values = $values;
        return $this;
    }

    public function where(string|array $condition): self
    {
        $this->condition = $condition;
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
        $success = $stmt->execute($this->values);

        return $success;
    }

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
