<?php

declare(strict_types=1);

namespace Effectra\SqlQuery\Build;

use Effectra\SqlQuery\Driver;
use Effectra\SqlQuery\Operations\Insert;

/**
 * Trait QueryBuilderTrait
 *
 * A trait used by SQL query builders to handle common query building tasks.
 *
 */
trait QueryBuilderTrait
{
    /**
     * Generate the SET clause for INSERT or UPDATE statements.
     *
     * @return string The generated SET clause.
     */
    public function setData()
    {
        $result = [];

        $safeMode =  $this->getAttribute('insert_data_mode')  === Insert::INSERT_VALUES_MODE_SAFE ? true : false;

        $columns = $this->getAttribute('columns');
        $values = $this->getAttribute('values');

        $data = array_combine($columns, $values);

        foreach ($data as $col => $value) {
            if ($safeMode) {
                $result[] = $col . $this->syntax->getOperator('equal', 1) . ':' . $col;
            } else {
                $result[] = $col . $this->syntax->getOperator('equal', 1) . (new ValueBuilder([$value]))->getAsOneLine();
            }
        }
        return join(",\n", $result);
    }

    /**
     * Generate the WHERE clause for SELECT, INSERT, UPDATE, or DELETE statements.
     *
     * @return string The generated WHERE clause.
     */
    public function where()
    {
        $converted = [];
        $result = '';

        //Check if the column exists in the table
        if ($this->hasAttribute('where_table') && $this->hasAttribute('where_column')) {
            return $this->syntax->getCommand('where', 3) .
                $this->syntax->getCommand('table_name', 1) . $this->syntax->getOperator('equal', 1) . (new ValueBuilder([$this->getAttribute('where_table')]))->getAsOneLine() .
                $this->syntax->getCommand('and', 1) .
                $this->syntax->getCommand('column_name', 1) . $this->syntax->getOperator('equal', 1) . (new ValueBuilder([$this->getAttribute('where_column')]))->getAsOneLine();
        }

        if (!$this->hasAttribute('where')) {
            return '';
        }

        if (is_array($this->getAttribute('where'))) {
            foreach ($this->getAttribute('where') as $attribute) {

                $col = $attribute['col'] ?? null;
                if (!$col) {
                    throw new \Exception("no col selected");
                }

                if (isset($attribute['equal'])) {
                    $converted[] = $this->whereEqual($attribute);
                }

                if (isset($attribute['greater_than'])) {
                    $converted[] = $this->whereGreaterThan($attribute);
                }

                if (isset($attribute['greater_than_or_equal'])) {
                    $converted[] = $this->whereGreaterThanOrEqual($attribute);
                }

                if (isset($attribute['less_than'])) {
                    $converted[] = $this->whereLessThan($attribute);
                }

                if (isset($attribute['less_than_or_equal'])) {
                    $converted[] = $this->whereLessThanOrEqual($attribute);
                }

                if (isset($attribute['not_equal'])) {
                    $converted[] = $this->whereNotEqual($attribute);
                }

                if (isset($attribute['not_null'])) {
                    $converted[] = $this->whereIsNotNull($attribute);
                }

                if (isset($attribute['in_between'])) {
                    $converted[] = $this->whereInBetween($attribute);
                }

                if (isset($attribute['like'])) {
                    $converted[] = $this->whereLike($attribute);
                }

                if (isset($attribute['from'])) {
                    $converted[] = $this->whereLike($attribute);
                }

                if (isset($attribute['not'])) {
                    $converted[] = $this->whereNot($attribute);
                }
            }

            $sortedSyntax = array_map(fn ($op) => $this->syntax->getCommand($op, 1), $this->getWhereSortedConditions());

            foreach ($converted as $key => $condition) {
                if ($key > 0 && $condition !== null) {
                    $result .=  $sortedSyntax[$key - 1] ?? $this->syntax->getCommand('and', 1);
                }
                $result .= $condition;
            }
        }

        if (is_string($this->getAttribute('where'))) {
            $result = $this->getAttribute('where');
        }


        return $this->syntax->getCommand('where', 3) . $result;
    }

    private function whereWithOperator($attribute, $operator): string
    {
        return  $attribute['col'] . $this->syntax->getOperator($operator, 1) . (new ValueBuilder([$attribute[$operator]]))->getAsOneLine();
    }

    public function whereEqual($attribute): string
    {
        return $this->whereWithOperator($attribute, 'equal');
    }

    public function whereNotEqual($attribute): string
    {
        return $this->whereWithOperator($attribute, 'not_equal');
    }

    public function whereGreaterThan($attribute): string
    {
        return $this->whereWithOperator($attribute, 'greater_than');
    }

    public function whereLessThan($attribute): string
    {
        return $this->whereWithOperator($attribute, 'less_than');
    }

    public function whereGreaterThanOrEqual($attribute): string
    {
        return $this->whereWithOperator($attribute, 'greater_than_or_equal');
    }

    public function whereLessThanOrEqual($attribute): string
    {
        return $this->whereWithOperator($attribute, 'less_than_or_equal');
    }

    public function whereNot($attribute): string
    {
        return $attribute['col'] . $this->syntax->getCommand('not', 1) . $attribute['not'];
    }

    public function whereIsNotNull($attribute): string
    {
        return $attribute['col'] .
            $this->syntax->getCommand('is', 1) .
            $this->syntax->getCommand('not', 1) .
            $this->syntax->getCommand('null', 3);
    }

    public function whereIn($attribute): string
    {
        return $this->whereWithOperator($attribute, 'equal');
    }


    public function whereInBetween($attribute): string|null
    {
        $col = $attribute['col'] ?? null;
        $in_between = $attribute['in_between'] ?? null;
        if ($in_between) {
            return $col . $this->syntax->getCommand('between', 1) . $in_between['from'] . $this->syntax->getCommand('and', 1) . $in_between['to'];
        }
        return null;
    }

    public function whereLike($attribute): string|null
    {
        return $attribute['col'] . $this->syntax->getCommand('like', 1) . (new ValueBuilder(['%' . $attribute['like'] . '%']))->getAsOneLine();
    }

    public function whereFromColumnTable($attribute)
    {
        return $this->attributes . '.' . $attribute['col'] .
            $this->syntax->getOperator('equal', 1) .
            $attribute['from']['table_joined'] . '.' . $attribute['from']['column_joined'];
    }

    public function getWhereSortedConditions(): array
    {
        if (!isset($this->attributes['where_sort'])) {
            return [];
        }
        return array_map(fn ($cond) => $cond['operator'], $this->attributes['where_sort']);
    }

    /**
     * Check if a sub-attribute within an attribute exists in the query builder's attributes.
     *
     * @param string $sub_attribute The name of the sub-attribute to check.
     * @param string $attribute The name of the attribute within the sub-attribute.
     *
     * @return bool True if the sub-attribute and attribute exist, false otherwise.
     */
    public function subAttributeHasAttribute($sub_attribute, $attribute): bool
    {
        $constraints = $this->getAttribute($sub_attribute);
        foreach ($constraints as $constraint) {
            if (is_array($constraint)) {
                // Check if the attribute exists in the nested array
                if (array_key_exists($attribute, $constraint)) {
                    return true;
                }
            } elseif ($constraint === $attribute) {
                // Check if the attribute matches a non-array value in the constraints array
                return true;
            }
        }

        return false;
    }

    /**
     * Generate a string for checking conditions in a SQL query.
     *
     * @param string $column      The name of the column to check.
     * @param array  $expressions An array of conditions to check.
     * @param array  $checkSort   An array specifying the order of logical operators (optional).
     *
     * @return string The generated SQL check conditions string.
     *
     * @throws \Exception If an empty expression is encountered.
     */
    public function checkQuery(string $column, array $expressions, array $checkSort = []): string
    {
        // If SQLite, return an empty string since SQLite doesn't support check conditions.
        if ($this->syntax->getDriver() === Driver::SQLite) {
            return '';
        }

        // If no expressions provided, return an empty string.
        if (empty($expressions)) {
            return '';
        }

        $result = '';
        $expressionsResult = [];

        foreach ($expressions as $expression) {
            // Ensure expression is not empty.
            if (empty($expression)) {
                throw new \Exception("Error Processing Query, check expression is empty");
            }

            // If the expression is 'json', convert it to 'json_valid(column)'.
            if ($expression === 'json') {
                $expression = "json_valid($column)";
            }

            $expressionsResult[] = $expression;
        }

        // Set a default value for $checkSort if not provided.
        if (empty($checkSort)) {
            $checkSort = ['and']; // Default to 'AND' operator.
        }

        // Remove the first element of $checkSort if it's empty.
        if (!empty($checkSort)) {
            array_shift($checkSort);
        }

        // Generate sorted syntax based on the logical operators in $checkSort.
        $sortedSyntax = array_map(fn ($operator) => $this->syntax->getCommand($operator, 1), $checkSort);

        foreach ($expressionsResult as $key => $condition) {
            if ($key > 0 && $condition !== null) {
                $result .= $sortedSyntax[$key - 1] ?? $this->syntax->getCommand('and', 1);
            }
            $result .= $condition;
        }

        return $result;
    }
}
