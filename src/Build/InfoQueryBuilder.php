<?php

declare(strict_types=1);

namespace Effectra\SqlQuery\Build;

use Effectra\SqlQuery\Attribute;
use Effectra\SqlQuery\Operations\Select;
use Effectra\SqlQuery\Syntax;

/**
 * Class InfoQueryBuilder
 *
 * The InfoQueryBuilder class provides a convenient interface for constructing SQL queries to retrieve database information.
 */
class InfoQueryBuilder extends Attribute
{
    /**
     * InfoQueryBuilder constructor.
     *
     * @param array $attributes An array of attributes for the INFO query.
     * @param Syntax $syntax The syntax handler for constructing SQL queries.
     */
    public function __construct(protected array $attributes, protected Syntax $syntax)
    {
    }

    /**
     * Get the name of the current database.
     *
     * @return string The SQL query to retrieve the current database name.
     */
    public function dbName(): string
    {
        return (string) match ($this->syntax->getDriver()) {
            'mysql' =>  $this->syntax->getCommand('select', 1) . $this->syntax->getCommand('database') . "()",
            'postgresql' => $this->syntax->getCommand('select', 1) . 'current_database()',
            'sqlite' => $this->syntax->getCommand('pragma', 1) . 'database_list',
        };
    }

    /**
     * Get the SQL query to list databases.
     *
     * @return string The SQL query to list databases.
     */
    public function listDatabase(): string
    {
        return (string) match ($this->syntax->getDriver()) {
            'mysql' => $this->syntax->getCommand('show', 1) . $this->syntax->getCommand('databases'),
            'postgresql' => (new Select('pg_database'))->columns(['datname']),
            'sqlite' => '',
        };
    }

    /**
     * Get the SQL query to list tables in a database.
     *
     * @return string The SQL query to list tables.
     */
    public function listTables(): string
    {
        return (string) match ($this->syntax->getDriver()) {
            'mysql' => $this->syntax->getCommand('show', 1) . $this->syntax->getCommand('tables'),
            'postgresql' => (new Select('information_schema.tables'))->columns(['table_name'])->where(['table_schema' => 'public', 'table_type' => 'BASE TABLE']),
            'sqlite' => (new Select('sqlite_master'))->columns(['name'])->where(['type' => 'table']),
        };
    }

     /**
     * Get the SQL query to list columns of a table.
     *
     * @return string The SQL query to list columns.
     */
    public function listCols(): string
    {
        return (string) match ($this->syntax->getDriver()) {
            'mysql' => $this->syntax->getCommand('describe', 1) . $this->getAttribute('table_name'),
            'postgresql' => (new Select('information_schema.columns'))->columns(['column_name'])->where(['table_name' => $this->getAttribute('table_name')]),
            'sqlite' => sprintf(
                '%s %s(%s)',
                $this->syntax->getCommand('pragma', 1),
                'table_info',
                $this->getAttribute('db_name')
            ),
        };
    }

     /**
     * Get the SQL query to retrieve the schema of a table.
     *
     * @return string The SQL query to retrieve table schema.
     */
    public function tableSchema(): string
    {
        return (string) match ($this->syntax->getDriver()) {
            'mysql' => $this->syntax->getCommand('show', 1) . $this->syntax->getCommand('create', 2) . $this->syntax->getCommand('table', 2) . $this->getAttribute('table_name'),
            'postgresql' => (new Select('information_schema.columns'))->columns(['column_name', 'data_type', 'character_maximum_length'])->where(['table_name' => $this->getAttribute('table_name')]),
            'sqlite' => (new Select('sqlite_master'))->columns(['sql'])->where(['type' => 'table', 'name' => $this->getAttribute('table_name')]),
        };
    }

    /**
     * Get the SQL query to retrieve table indexes.
     *
     * @return string The SQL query to retrieve table indexes.
     */
    public function tableIndexes(): string
    {
        return (string) match ($this->syntax->getDriver()) {
            'mysql' => $this->syntax->getCommand('show', 1) . $this->syntax->getCommand('index') . $this->syntax->getCommand('from') . $this->getAttribute('table_name'),
            'postgresql' => (new Select('pg_indexes'))->columns(['indexname'])->where(['table_name' => $this->getAttribute('table_name')]),
            'sqlite' => sprintf(
                '%s %s(%s)',
                $this->syntax->getCommand('pragma', 1),
                'index_list',
                $this->getAttribute('db_name')
            ),
        };
    }

    /**
     * Build the SQL INFO query.
     *
     * @return string The generated SQL query.
     */
    public function build(): string
    {
        return match ($this->getAttribute('info')) {
            'db_name' => $this->dbName(),
            'list_db' => $this->listDatabase(),
            'list_tables' => $this->listTables(),
            'list_cols' => $this->listCols(),
            'table_schema' => $this->tableSchema(),
            'table_indexes' => $this->tableIndexes(),
        };
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
