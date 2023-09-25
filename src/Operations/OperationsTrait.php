<?php

declare(strict_types=1);

namespace Effectra\SqlQuery\Operations;

use Effectra\SqlQuery\Condition;

trait OperationsTrait
{
    /**
     * Add a custom SQL query to the attributes.
     *
     * @param string $query The custom SQL query to add.
     */
    public function addQuery(string $query)
    {
        $this->setAttribute('query', $query);
    }

    public function whereConditions(Condition $conditions):self
    {
        $condition = $conditions->getAttributes() ;
        foreach ($condition['where'] as $attr) {
           $this->addToAttribute('where',$attr);
        }
        return $this;
    }

    /**
     * Add a WHERE clause to the SQL query.
     *
     * @param mixed $columns The columns to filter on. Accepts various formats.
     * @param mixed $flags Flags for combining multiple WHERE conditions (e.g., 'and', 'or').
     * @param string $operator The comparison operator (e.g., 'equal', 'not_equal', 'greater_than', etc.).
     *
     * @return self
     */
    public function where($columns = null, $flags = null, string $operator = 'equal'): self
    {

        if (!$columns) {
            $this->setAttribute('where', []);
        }

        if (is_object($columns)) {
            $columns = (array) $columns;
        }

        if (is_array($columns)) {

            $firstItem = reset($columns);

            if (!$firstItem) {
                $this->addToAttribute('where', [
                    'col' => array_keys($columns)[0],
                    $operator => $firstItem
                ]);
            } else {

                if (is_string(key($columns)) && is_scalar($firstItem)) {
                    foreach ($columns as $key => $value) {
                        $this->addToAttribute('where', [
                            'col' => $key,
                            $operator => $value
                        ]);
                    }
                }

                if (is_array($firstItem) && count($firstItem) > 0) {
                    foreach ($columns as $column) {
                        foreach ($column as $key => $value) {
                            $this->addToAttribute('where', [
                                'col' => $key,
                                $operator => $value
                            ]);
                        }
                        if ($flags && in_array($flags, ['and', 'or'])) {
                            $this->sort($flags);
                        }
                    }
                }
            }
        }

        if (is_string($columns)) {
            $this->setAttribute('where', $columns);
        }

        return $this;
    }

    /**
     * Add a WHERE clause to filter columns where values are equal.
     *
     * @param mixed $columns The columns to filter on. Accepts various formats.
     * @param mixed $flags Flags for combining multiple WHERE conditions (e.g., 'and', 'or').
     *
     * @return self
     */
    public function whereEqual($columns, $flags = null): self
    {
        return $this->where($columns, $flags);
    }

    /**
     * Add a WHERE clause to filter columns where values are not equal.
     *
     * @param mixed $columns The columns to filter on. Accepts various formats.
     * @param mixed $flags Flags for combining multiple WHERE conditions (e.g., 'and', 'or').
     *
     * @return self
     */
    public function whereNotEqual($columns, $flags = null): self
    {
        return $this->where($columns, $flags, 'not_equal');
    }

    /**
     * Add a WHERE clause to filter columns where values are greater than a specified value.
     *
     * @param mixed $columns The columns to filter on. Accepts various formats.
     * @param mixed $flags Flags for combining multiple WHERE conditions (e.g., 'and', 'or').
     *
     * @return self
     */
    public function whereGreaterThan($columns, $flags = null): self
    {
        return $this->where($columns, $flags, 'greater_than');
    }

    /**
     * Add a WHERE clause to filter columns where values are less than a specified value.
     *
     * @param mixed $columns The columns to filter on. Accepts various formats.
     * @param mixed $flags Flags for combining multiple WHERE conditions (e.g., 'and', 'or').
     *
     * @return self
     */
    public function whereLessThan($columns, $flags = null): self
    {
        return $this->where($columns, $flags, 'less_than');
    }

    /**
     * Add a WHERE clause to filter columns where values are greater than or equal to a specified value.
     *
     * @param mixed $columns The columns to filter on. Accepts various formats.
     * @param mixed $flags Flags for combining multiple WHERE conditions (e.g., 'and', 'or').
     *
     * @return self
     */
    public function whereGreaterThanOrEqual($columns, $flags = null): self
    {
        return $this->where($columns, $flags, 'greater_than_or_equal');
    }

    /**
     * Add a WHERE clause to filter columns where values are less than or equal to a specified value.
     *
     * @param mixed $columns The columns to filter on. Accepts various formats.
     * @param mixed $flags Flags for combining multiple WHERE conditions (e.g., 'and', 'or').
     *
     * @return self
     */
    public function whereLessThanOrEqual($columns, $flags = null): self
    {
        return $this->where($columns, $flags, 'less_than_or_equal');
    }

    /**
     * Add a WHERE clause to filter columns with a "NOT" condition.
     *
     * @param mixed $columns The columns to filter on. Accepts various formats.
     * @param mixed $flags Flags for combining multiple WHERE conditions (e.g., 'and', 'or').
     *
     * @return self
     */
    public function whereNot($columns, $flags = null): self
    {

        return $this->where($columns, $flags, 'not');
    }

    /**
     * Add a WHERE clause to filter columns where values are not null.
     *
     * @param mixed $columns The columns to filter on. Accepts various formats.
     * @param mixed $flags Flags for combining multiple WHERE conditions (e.g., 'and', 'or').
     *
     * @return self
     */
    public function whereIsNotNull($columns, $flags = null): self
    {
        foreach ($columns as $key => $column) {
            $columns[] = [$column => ''];
            unset($columns[$key]);
        }
        return $this->where($columns, $flags, 'not_null');
    }

    /**
     * Add a WHERE clause to filter columns where values are in a specified list.
     *
     * @param mixed $columns The columns to filter on. Accepts various formats.
     * @param mixed $flags Flags for combining multiple WHERE conditions (e.g., 'and', 'or').
     *
     * @return self
     */
    public function whereIn($columns, $flags = null): self
    {
        return $this->where($columns, $flags, 'in');
    }

    /**
     * Add a WHERE clause to filter columns where values match a specified pattern.
     *
     * @param mixed $columns The columns to filter on. Accepts various formats.
     * @param mixed $flags Flags for combining multiple WHERE conditions (e.g., 'and', 'or').
     *
     * @return self
     */
    public function whereLike($columns, $flags = null): self
    {
        return $this->where($columns, $flags, 'like');
    }

    /**
     * Add a WHERE clause to filter columns based on a related column from another table.
     *
     * @param string $column The column to filter on.
     * @param string $table_joined The name of the joined table.
     * @param string $column_joined The column in the joined table to compare with.
     *
     * @return self
     */
    public function whereFromColumnTable(string $column, string $table_joined, string $column_joined)
    {
        $this->setAttribute(
            'where',
            [
                'col' => $column,
                'from' =>  ['table' => $table_joined, 'column_joined' => $column_joined]
            ]
        );
        return $this;
    }

    /**
     * Add a WHERE clause to filter columns with values within a specified range.
     *
     * @param string $column The column to filter on.
     * @param string|int|float $from The lower bound of the range.
     * @param string|int|float $to The upper bound of the range.
     *
     * @return self
     *
     * @throws \Exception If $to is less than $from.
     */
    public function inBetween(string $column, string|int|float $from, string|int|float $to): self
    {
        if ($to < $from) {
            throw new \Exception('The $to value must be greater than the $from value.');
        }

        $this->addToAttribute('where', [
            'col' => $column,
            'in_between' => ['from' => $from, 'to' => $to]
        ]);
        return $this;
    }

    /**
     * Add a WHERE clause to filter columns with values within a specified range.
     *
     * @param string $column The column to filter on.
     * @param string|int|float $from The lower bound of the range.
     * @param string|int|float $to The upper bound of the range.
     *
     * @return self
     *
     * @throws \Exception If $to is less than $from.
     */
    public function whereInBetween(string $column, string|int|float $from, string|int|float $to): self
    {
        return $this->inBetween($column, $from, $to);
    }

    /**
     * Set the target column for a WHERE clause.
     *
     * @param string $column The name of the target column.
     *
     * @return self
     */
    public function whereColumn(string $column)
    {
        $this->setAttribute('where_column', $column);
        return $this;
    }

    /**
     * Set the target table for a WHERE clause.
     *
     * @param string $table The name of the target table.
     *
     * @return self
     */
    public function whereTable(string $table)
    {
        $this->setAttribute('where_table', $table);
        return $this;
    }

    
}
