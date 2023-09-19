<?php

declare(strict_types=1);

namespace Effectra\SqlQuery\Build;

use Effectra\SqlQuery\Attribute;
use Effectra\SqlQuery\Driver;
use Effectra\SqlQuery\Operations\Alter;
use Effectra\SqlQuery\Operations\Select;
use Effectra\SqlQuery\Syntax;

/**
 * Class DatabaseQueryBuilder
 *
 * Represents a query builder for generating SQL database-related statements (e.g., CREATE DATABASE, DROP DATABASE, etc.).
 *
 * @package Effectra\SqlQuery\Build
 */
class DatabaseQueryBuilder extends Attribute
{

    /**
     * DatabaseQueryBuilder constructor.
     *
     * @param array $attributes An array of attributes for the database query.
     * @param Syntax $syntax The syntax handler for constructing SQL queries.
     */
    public function __construct(protected array $attributes, protected Syntax $syntax)
    {
    }

     /**
     * Generate the SQL query for creating a database.
     *
     * @return string The generated SQL query for creating a database.
     */
    public function create(): string
    {
        return $this->syntax->getCommand('createDatabase', 1) . $this->getAttribute('db_name');
    }

    /**
     * Generate the SQL query for dropping a database.
     *
     * @return string The generated SQL query for dropping a database.
     */
    public function drop(): string
    {
        return $this->syntax->getCommand('dropDatabase', 1) . $this->getAttribute('db_name');
    }

    /**
     * Generate the SQL query for renaming a database (PostgreSQL specific).
     *
     * @return string The generated SQL query for renaming a database.
     * @throws \Exception If the current driver does not support database renaming.
     */
    public function rename(): string
    {
        $driver = $this->syntax->getDriver();
        if ($driver !== Driver::PostgreSQL) {
            throw new \Exception("Error Processing Query, driver '$driver' doesn't has statement for rename database");
        }
        return (string) (new Alter())->database($this->getAttribute('db_name'))->renameDB($this->getAttribute('rename'));
    }

    /**
     * Generate the SQL query for retrieving a list of tables in the database.
     *
     * @return string The generated SQL query for retrieving tables.
     * @throws \Exception If the current driver is not recognized.
     */
    public function getTables(): string
    {
        $driver = $this->syntax->getDriver();
        if ($driver === Driver::MySQL) {
            return $this->syntax->getCommand('show', 1) .$this->syntax->getCommand('tables', 1) ;
        }
        if ($driver === Driver::PostgreSQL) {
            return (string) (new Select('table_name'))->columns(['table_schema'])->from('information_schema.tables')->where(['table_schema '=>'public']);
        }
        if ($driver === Driver::SQLite) {
            return (string) (new Select(''))->columns(['name'])->from('sqlite_master ')->where(['type '=>'table']);
        }
        throw new \Exception("Error Processing Query,driver not exists", 1);
    }

    /**
     * Build the SQL database-related query.
     *
     * @return string The generated SQL query.
     */
    public function build(): string
    {

        if ($this->getAttribute('operation') === 'create') {
            return $this->create();
        }

        if ($this->getAttribute('operation') === 'drop') {
            return $this->drop();
        }

        if ($this->getAttribute('operation') === 'rename') {
            return $this->rename();
        }

        if ($this->getAttribute('operation') === 'get_tables') {
            return $this->getTables();
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
