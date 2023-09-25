<?php

declare(strict_types=1);

namespace Effectra\SqlQuery\Build;

use Effectra\SqlQuery\Attribute;
use Effectra\SqlQuery\Syntax;

/**
 * Class SelectQueryBuilder
 *
 * Represents a query builder for constructing SELECT statements in SQL queries.
 */
class SelectQueryBuilder extends Attribute
{
    use QueryBuilderTrait;

    /**
     * Constructor for the SelectQueryBuilder.
     *
     * @param array $attributes An array of attributes used in the query.
     * @param Syntax $syntax The syntax handler for generating SQL syntax.
     */
    public function __construct(protected array $attributes, protected Syntax $syntax)
    {
    }

    /**
     * Get the SQL command to start a SELECT statement.
     *
     * @return string The SQL command for SELECT.
     */
    public function start():string
    {
        return $this->syntax->getCommand('select');
    }

    /**
     * Get the list of columns selected in the SELECT statement.
     *
     * @return string|array The selected columns or '*' if all columns are selected.
     */
    public function columnsSelected():string|array
    {
        $cols = $this->getAttribute('column_selected');
        if($cols === '*'){
            return '*';
        }
        foreach ($cols as $colK => $colV) {
            if ($colK !== $colV) {
                $colV = $colK . $this->syntax->getCommand('as', 1) . $colV;
                $cols[$colK] = $colV;
            }
        }
        return join(', ', array_values($cols));
    }

    /**
     * Get the SQL command for specifying the source table in the SELECT statement.
     *
     * @return string The SQL command for specifying the source table.
     */
    public function fromTable():string
    {
        return $this->syntax->getCommand('from', 3) . $this->getAttribute('table_name');
    }

     /**
     * Get the SQL command for specifying the GROUP BY clause in the SELECT statement.
     *
     * @return string The SQL command for GROUP BY, or an empty string if not specified.
     */
    public function groupBy():string
    {
        if (!$this->hasAttribute('group_by')) {
            return '';
        }
        return $this->syntax->getCommand('groupBy', 3) . join(', ',$this->getAttribute('group_by') );
    }

    /**
     * Get the SQL command for specifying the ORDER BY clause in the SELECT statement.
     *
     * @return string The SQL command for ORDER BY, or an empty string if not specified.
     */
    public function orderBy():string
    {
        if (!$this->hasAttribute('order_by')) {
            return '';
        }
        return $this->syntax->getCommand('orderBy', 3) .
            join(', ', $this->getAttribute('order_by')['cols']) .
            $this->syntax->getCommand($this->getAttribute('order_by')['direction'], 2);
    }

    /**
     * Get the SQL command for specifying the LIMIT clause in the SELECT statement.
     *
     * @return string The SQL command for LIMIT, or an empty string if not specified.
     */
    public function limit():string
    {
        if (!$this->hasAttribute('limit')) {
            return '';
        }
        $count_until = $this->getAttribute('limit')['count_until'] ?? null;
        $count = $count_until ? ', ' . $count_until : $count_until;
        return $this->syntax->getCommand('limit', 3)
            . $this->getAttribute('limit')['start_from']
            . $count;
    }

    /**
     * Build the final SQL query based on the SELECT statement attributes.
     *
     * @return string The generated SQL query.
     */
    public function build(): string
    {
        return sprintf(
            '%s %s %s %s %s %s %s',
            $this->start(),
            $this->columnsSelected(),
            $this->fromTable(),
            $this->where(),
            $this->groupBy(),
            $this->orderBy(),
            $this->limit(),
        );
    }

    /**
     * Convert the object to its string representation (generates the SQL query).
     *
     * @return string The generated SQL query.
     */
    public function __toString()
    {
        return $this->build();
    }
}
