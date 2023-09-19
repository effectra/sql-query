<?php

declare(strict_types=1);

namespace Effectra\SqlQuery\Build;

use Effectra\SqlQuery\Attribute;
use Effectra\SqlQuery\Syntax;
use Effectra\SqlQuery\Validation\ArraysValidation;
use Effectra\SqlQuery\ValueBuilderTrait\ValueBuilder;

/**
 * Class DropQueryBuilder
 *
 * Represents a query builder for generating SQL DROP statements (e.g., DROP TABLE, DROP COLUMN, etc.).
 *
 * @package Effectra\SqlQuery\Build
 */
class DropQueryBuilder extends Attribute
{

    use QueryBuilderTrait, ArraysValidation;

    /**
     * DropQueryBuilder constructor.
     *
     * @param array $attributes An array of attributes for the DROP query.
     * @param Syntax $syntax The syntax handler for constructing SQL queries.
     */
    public function __construct(protected array $attributes, protected Syntax $syntax)
    {
    }

    /**
     * Get the target of the DROP operation (e.g., table, column, database, index, key).
     *
     * @return string The target of the DROP operation.
     */
    public function target()
    {
        $result = '';

        if ($this->hasTarget('column')) {
            $result = $this->column();
        }

        if ($this->hasTarget('table')) {
            $result = $this->table();
        }

        if ($this->hasTarget('database')) {
            $result = $this->database();
        }

        if ($this->hasTarget('index')) {
            $result = $this->index();
        }

        if ($this->hasTarget('key')) {
            $result = $this->key();
        }

        return $result;
    }

    /**
     * Check if the DROP operation has the specified target.
     *
     * @param string $value The target to check (e.g., column, table, database, index, key).
     * @return bool True if the DROP operation has the specified target; otherwise, false.
     * @throws \Exception If the specified target is not defined in the query.
     */
    public function hasTarget($value): bool
    {
        if ($this->getAttribute('target') === $value) {
            return true;
            if (!$this->hasAttribute($value)) {
                throw new \Exception("Error Processing Query, $value not defined");
            }
        }
        return false;
    }

    /**
     * Generate the SQL query for dropping a database.
     *
     * @return string The generated SQL query for dropping a database.
     */
    public function database(): string
    {
        return $this->syntax->getCommand('drop', 1) . $this->syntax->getCommand('database', 2) . $this->getAttribute('database');
    }

    /**
     * Generate the SQL query for dropping a table.
     *
     * @return string The generated SQL query for dropping a table.
     */
    public function table(): string
    {
        return $this->syntax->getCommand('drop', 1) . $this->syntax->getCommand('table', 1) . $this->getAttribute('table');
    }

    /**
     * Generate the SQL query for dropping a column.
     *
     * @return string The generated SQL query for dropping a column.
     * @throws \Exception If the table is not defined in the query.
     */
    public function column(): string
    {
        if (!$this->getAttribute('table')) {
            throw new \Exception("Error Processing Query, table not defined");
        }
        return  $this->syntax->getCommand('alterTable', 1) .  $this->getAttribute('table') .
            $this->syntax->getCommand('drop', 1) .
            $this->syntax->getCommand('column', 1) . $this->getAttribute('column');
    }

    /**
     * Generate the SQL query for dropping an index.
     *
     * @return string The generated SQL query for dropping an index.
     * @throws \Exception If the table is not defined in the query.
     */
    public function index(): string
    {
        if (!$this->getAttribute('table')) {
            throw new \Exception("Error Processing Query, table not defined");
        }
        return  $this->syntax->getCommand('drop', 1) .
            $this->syntax->getCommand('index', 1) . $this->getAttribute('index') .
            $this->syntax->getCommand('on', 1) . $this->getAttribute('table');
    }

    /**
     * Generate the SQL query for dropping a key (primary, foreign, or unique).
     *
     * @return string The generated SQL query for dropping a key.
     * @throws \Exception If the table is not defined in the query, or if the index is not defined for a unique key.
     */
    public function key(): string
    {
        if (!$this->getAttribute('table')) {
            throw new \Exception("Error Processing Query, table not defined");
        }

        $type = "";

        if ($this->getAttribute('type') === 'primary_key') {
            $type = $this->syntax->getKey('primary', 1);
        }

        if ($this->getAttribute('type') === 'foreign_key') {
            $type = $this->syntax->getKey('foreign', 1) .  $this->getAttribute('key');
        }

        if ($this->getAttribute('type') === 'unique_key') {
            if (!$this->getAttribute('index')) {
                throw new \Exception("Error Processing Query, index not defined");
            }
            $type =  $this->syntax->getCommand('index', 1) .  $this->getAttribute('index');
        }

        return  $this->syntax->getCommand('alterTable', 1) .  $this->getAttribute('table') .
            $this->syntax->getCommand('drop', 1) . $type;
    }

    /**
     * Build the SQL DROP query.
     *
     * @return string The generated SQL DROP query.
     */
    public function build(): string
    {
        return sprintf(
            '%s ',
            $this->target(),
        );
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
