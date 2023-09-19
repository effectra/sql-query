<?php

declare(strict_types=1);

namespace Effectra\SqlQuery\Build;

use Effectra\SqlQuery\Attribute;
use Effectra\SqlQuery\Syntax;
use Effectra\SqlQuery\Validation\ArraysValidation;

/**
 * Class InsertQueryBuilder
 *
 * Represents a query builder for generating SQL INSERT statements.
 *
 * @package Effectra\SqlQuery\Build
 */
class InsertQueryBuilder extends Attribute
{
    use QueryBuilderTrait, ArraysValidation;

    /**
     * InsertQueryBuilder constructor.
     *
     * @param array $attributes An array of attributes for the INSERT query.
     * @param Syntax $syntax The syntax handler for constructing SQL queries.
     */
    public function __construct(protected array $attributes, protected Syntax $syntax)
    {
    }

    /**
     * Get the type of INSERT operation.
     *
     * @return int The type of INSERT operation (1 for VALUES, 2 for DATA).
     */
    public function getInsertType(): int
    {
        return $this->getAttribute('insert_type');
    }

    /**
     * Generate the initial part of the INSERT query.
     *
     * @return string The generated initial part of the INSERT query.
     */
    public function start()
    {
        return $this->syntax->getCommand('insert');
    }

    /**
     * Generate the "OR" clause for the INSERT query.
     *
     * @return string The generated "OR" clause.
     */
    public function or()
    {
        return '';
    }

    /**
     * Generate the "INTO" clause for the INSERT query.
     *
     * @return string The generated "INTO" clause.
     */
    public function intoTable()
    {
        return $this->syntax->getCommand('into', 1) .  $this->attributes['table_name'];
    }

     /**
     * Generate the column list for the INSERT query.
     *
     * @return string The generated column list.
     */
    public function columns()
    {
        if (!$this->hasAttribute('columns')) {
            return '';
        }
        $cols = join(', ', $this->attributes['columns']);
        return "($cols)";
    }

    /**
     * Generate the "VALUES" clause for the INSERT query.
     *
     * @return string The generated "VALUES" clause.
     */
    public function values()
    {
        $result = [];
        $values = $this->attributes['values'];

        if ($values === 'default') {
            return $this->syntax->getCommand('default', 3) . $this->syntax->getCommand('values', 3);
        }

        if (!$this->isArrayOfArrays($values)) {
            $values = [$values];
        }

        foreach ($values as $value) {
            $result[] = $this->syntax->getCommand('values', 3) . "(" . (new ValueBuilder($value))->getAsOneLine() . ")";
        }

        return  join(', ', $result);
    }

    /**
     * Generate the table name and "SET" clause for the INSERT query.
     *
     * @return string The generated table name and "SET" clause.
     */
    public function tableName()
    {
        return  $this->syntax->getCommand('into', 1) .
            $this->attributes['table_name'] .
            $this->syntax->getCommand('set', 2);
    }

    /**
     * Build the SQL query for inserting data using "VALUES" syntax.
     *
     * @return string The generated SQL query for inserting data using "VALUES" syntax.
     */
    public function buildForValues(): string
    {
        return sprintf(
            '%s %s %s %s %s  ',
            $this->start(),
            $this->or(),
            $this->intoTable(),
            $this->columns(),
            $this->values(),

        );
    }

    /**
     * Build the SQL query for inserting data using "DATA" syntax.
     *
     * @return string The generated SQL query for inserting data using "DATA" syntax.
     */
    public function buildForData(): string
    {
        return sprintf(
            '%s %s %s %s',
            $this->start(),
            $this->or(),
            $this->tableName(),
            $this->setData()
        );
    }

    /**
     * Build the SQL INSERT query based on the specified insert type.
     *
     * @return string The generated SQL INSERT query.
     */
    public function build(): string
    {
        if ($this->getInsertType() === 1) {
            return $this->buildForValues();
        }
        if ($this->getInsertType() === 2) {
            return $this->buildForData();
        }
    }

    /**
     * Convert the query builder to its string representation.
     *
     * @return string The string representation of the query builder.
     */
    public function __toString()
    {
        return $this->build();
    }
}
