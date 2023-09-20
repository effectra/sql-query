<?php

declare(strict_types=1);

namespace Effectra\SqlQuery\Build;

use Effectra\SqlQuery\Attribute;
use Effectra\SqlQuery\Syntax;

/**
 * Class DeleteQueryBuilder
 *
 * Represents a query builder for generating SQL Delete statements.
 *
 */
class DeleteQueryBuilder extends Attribute
{

    use QueryBuilderTrait;

    /**
     * Constructor for the DeleteQueryBuilder.
     *
     * @param array $attributes An array of attributes used in the query.
     * @param Syntax $syntax The syntax handler for generating SQL syntax.
     */
    public function __construct(protected array $attributes, protected Syntax $syntax)
    {
    }

    /**
     * Get the SQL command to start a DELETE statement.
     *
     * @return string The SQL command for DELETE.
     */
    public function start():string
    {
        return $this->syntax->getCommand('delete');
    }

    /**
     * Get the SQL command for specifying the source table in the DELETE statement.
     *
     * @return string The SQL command for specifying the source table.
     */
    public function fromTable():string
    {
        return $this->syntax->getCommand('from', 3) . $this->attributes['table_name'];
    }

    /**
     * Build the final SQL query based on the SELECT statement attributes.
     *
     * @return string The generated SQL query.
     */
    public function build(): string
    {
        return sprintf(
            '%s %s %s',
            $this->start(),
            $this->fromTable(),
            $this->where()
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