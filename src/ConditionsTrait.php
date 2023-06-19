<?php

declare(strict_types=1);

namespace Effectra\SqlQuery;

/**
 * Trait ConditionsTrait
 * Provides methods for handling conditions and parameters in SQL queries.
 */
trait ConditionsTrait
{
    /**
     * Return the conditions as a string.
     *
     * @param string $conditions The conditions string.
     * @return string The conditions string.
     */
    public function conditionIsString(string $conditions): string
    {
        return $conditions;
    }

    /**
     * Generate conditions from an associative array.
     *
     * @param array $conditions The conditions array.
     * @param string $statement The comparison statement (default is '=').
     * @return string The generated conditions string.
     */
    public function conditionIsObject(array $conditions, string $statement = '='): string
    {
        $query = '';
        foreach ($conditions as $key => $value) {
            $query .= " $key $statement '$value' AND";
        }
        return rtrim($query, 'AND');
    }

    /**
     * Check if conditions exist.
     *
     * @param string|array $conditions The conditions to check.
     * @return bool True if conditions exist, false otherwise.
     */
    public function hasConditions(string|array $conditions): bool
    {
        return !empty($conditions);
    }

    /**
     * Set the conditions based on the provided input.
     *
     * @param string|array $conditions The conditions to set.
     * @param string $statement The comparison statement (default is '=').
     * @return string The generated conditions string.
     */
    public function setConditions(string|array $conditions, string $statement = '=')
    {
        if (is_string($conditions)) {
            return $this->conditionIsString($conditions);
        }
        if (is_array($conditions)) {
            return $this->conditionIsObject($conditions, $statement);
        }
    }

    /**
     * Set the parameters for the query.
     *
     * @param array $params The parameters to set.
     * @return void
     */
    public function setParams(array $params): void
    {
        $this->query .= ' SET ';

        foreach (array_keys($params) as $key) {
            $this->query .= " $key = :$key ,";
        }
        $this->query = rtrim($this->query, ',');
    }
}
