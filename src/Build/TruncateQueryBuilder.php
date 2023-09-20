<?php

declare(strict_types=1);

namespace Effectra\SqlQuery\Build;

use Effectra\SqlQuery\Attribute;
use Effectra\SqlQuery\Syntax;

/**
 * Class TruncateQueryBuilder
 *
 * Represents a query builder for constructing TRUNCATE statements in SQL queries.
 */
class TruncateQueryBuilder extends Attribute
{

    /**
     * Constructor for the TruncateQueryBuilder.
     *
     * @param array $attributes An array of attributes used in the query.
     * @param Syntax $syntax The syntax handler for generating SQL syntax.
     */
    public function __construct(protected array $attributes, protected Syntax $syntax)
    {
    }

    /**
     * Get the SQL command to start a TRUNCATE statement.
     *
     * @return string The SQL command for TRUNCATE.
     */
    public function start(): string
    {
        return $this->syntax->getCommand('truncate');
    }

    /**
     * Build the final SQL query based on the TRUNCATE statement attributes.
     *
     * @return string The generated SQL query.
     */
    public function build(): string
    {
        return sprintf(
            '%s %s',
            $this->start(),
            $this->getAttribute('table_name')
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
