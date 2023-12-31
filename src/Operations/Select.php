<?php

declare(strict_types=1);

namespace Effectra\SqlQuery\Operations;

use Effectra\SqlQuery\Attribute;
use Effectra\SqlQuery\Build\BuildAction;
use Effectra\SqlQuery\Build\RunBuilder;
use Effectra\SqlQuery\Validation\ArraysValidation;

/**
 * Class Select
 *
 * This class represents an SQL "SELECT" operation for querying data from a database table.
 *
 */
class Select extends Attribute
{
    use ArraysValidation,OperationsTrait;

    /**
     * Constructor for the Select class.
     *
     * @param string $table The name of the table to query data from.
     */
    public function __construct(string $table)
    {
        $this->setAttribute('table_name', $table);
        $this->setAttribute('operation', 'select');
    }

     /**
     * Select all columns from the table.
     *
     * @return self
     */
    public function all(): self
    {
        $this->setAttribute('column_selected', '*');
        return $this;
    }

    /**
     * Select specific columns from the table.
     *
     * @param array $columns An array of column names to select.
     * @return self
     */
    public function columns(array $columns): self
    {
        foreach ($columns as $key => $value) {
            if (is_int($key)) {
                unset($columns[$key]);
                $columns[$value] =  $value;
            }
        }
        $this->setAttribute('column_selected', $columns);
        return $this;
    }

    /**
     * Set a LIMIT clause for the query.
     *
     * @param int $start_from The starting row for the LIMIT clause.
     * @param int|null $count_until The number of rows to include in the LIMIT clause.
     * @return self
     */
    public function limit(int $start_from, ?int $count_until = null): self
    {
        $this->setAttribute('limit', [
            'start_from' => $start_from,
            'count_until' => $count_until,
        ]);
        return $this;
    }

    /**
     * Add a GROUP BY clause to the query.
     *
     * @param string $column The column to group by.
     * @param mixed ...$columns Additional columns to group by.
     * @return self
     */
    public function groupBy(string $column, ...$columns): self
    {
        $this->setAttribute('group_by', [$column, ...$columns]);
        return $this;
    }

    /**
     * Add an ORDER BY clause to the query.
     *
     * @param array|string $column The column(s) to order by.
     * @param mixed $direction The ordering direction.
     * @return self
     */
    public function orderBy(array|string $column, $direction): self
    {
        $this->setAttribute('order_by', [
            'cols' => is_string($column) ? [$column] : $column,
            'direction' => $direction
        ]);
        return $this;
    }

    /**
     * Add an "OR" condition to the query.
     *
     * @return self
     */
    public function or(): self
    {
        $this->sort('or');
        return $this;
    }

    /**
     * Add an "AND" condition to the query.
     *
     * @return self
     */
    public function and(): self
    {
        $this->sort('and');
        return $this;
    }

     /**
     * Set the sorting type for conditions (AND or OR).
     *
     * @param string $type The sorting type ('and' or 'or').
     */
    public function sort(string $type): void
    {
        $col_selected = $this->getAttribute('where');
        if ($col_selected == null) {
            throw new \Exception("You cannot sign a conditions without select statement");
        }
        $this->addToAttribute('where_sort', [
            'operator' => $type,
            'after_conditions' => end($col_selected)['col']
        ]);
    }

    /**
     * Set the table to query data from.
     *
     * @param mixed $value The name of the table.
     * @return self
     */
    public function from($value)
    {
        $this->setAttribute('table_name', $value);
        return $this;
    }

    /**
     * Get the SQL query generated by the Select operation.
     *
     * @return string
     */
    public function getQuery(): string
    {
        return (string) new RunBuilder($this->getAttributes(), BuildAction::SELECT);
    }

    /**
     * Convert the Select operation to a string, returning the generated SQL query.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->getQuery();
    }
}
