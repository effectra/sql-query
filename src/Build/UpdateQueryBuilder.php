<?php

declare(strict_types=1);

namespace Effectra\SqlQuery\Build;

use Effectra\SqlQuery\Attribute;
use Effectra\SqlQuery\Syntax;
use Effectra\SqlQuery\Validation\ArraysValidation;

/**
 * Class UpdateQueryBuilder
 * Builds an SQL UPDATE query based on provided attributes and syntax.
 */
class UpdateQueryBuilder extends Attribute
{
    use QueryBuilderTrait, ArraysValidation;

    /**
     * UpdateQueryBuilder constructor.
     *
     * @param array $attributes The attributes used to build the SQL query.
     * @param Syntax $syntax The syntax object providing SQL commands and formatting.
     */
    public function __construct(protected array $attributes, protected Syntax $syntax)
    {
    }

    /**
     * Get the "UPDATE" command for the SQL query.
     *
     * @return string The "UPDATE" command.
     */
    public function start()
    {
        return $this->syntax->getCommand('update');
    }

    /**
     * Get the "OR" clause for the SQL query (not used in this context).
     *
     * @return string An empty string.
     */
    public function or()
    {
        return '';
    }

    /**
     * Get the table name and "SET" command for the SQL query.
     *
     * @return string The table name and "SET" command.
     */
    public function tableName()
    {
        return  $this->attributes['table_name'] . $this->syntax->getCommand('set', 2);
    }

    /**
     * Build the SQL UPDATE query.
     *
     * @return string The generated SQL UPDATE query.
     */
    public function build(): string
    {
        return sprintf(
            '%s %s %s %s %s  ',
            $this->start(),
            $this->or(),
            $this->tableName(),
            $this->setData(),
            $this->where(),
        );
    }

    /**
     * Convert the UpdateQueryBuilder object to a string, representing the SQL query.
     *
     * @return string The generated SQL UPDATE query.
     */
    public function __toString()
    {
        return $this->build();
    }
}
