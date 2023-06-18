<?php

declare(strict_types=1);

namespace Effectra\SqlQuery;

trait ConditionsTrait
{

    public function conditionIsString(string $conditions): string
    {
        return $conditions;
    }

    public function conditionIsObject(array $conditions, string $statement = '='): string
    {
        $query= '';
        foreach ($conditions as $key => $value) {
            $query .= " $key  $statement  '$value' AND";
        }
       return rtrim($query, 'AND');
    }

    public function hasConditions(string|array $conditions): bool
    {
        return !empty($conditions);
    }

    public function setConditions(string|array $conditions, string $statement = '=')
    {
        if (is_string($conditions)) {
           return $this->conditionIsString($conditions);
        }
        if (is_array($conditions)) {
            return $this->conditionIsObject($conditions, $statement);
        }
    }

    public function setParams(array $params): void
    {
        $this->query .= ' SET ';

        foreach (array_keys($params) as $key) {
            $this->query .= " $key  = :$key ,";
        }
        $this->query = rtrim($this->query, ',');
    }
}
