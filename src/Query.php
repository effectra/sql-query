<?php

declare(strict_types=1);

namespace Effectra\SqlQuery;

/**
 * Class Query
 *
 * The main class for creating SQL queries.
 */
class Query
{
    public const CURRENT_TIMESTAMP = 'current_timestamp()';

    /**
     * Create a "CREATE DATABASE" query.
     *
     * @param string $name The name of the database.
     * @return string The SQL query.
     */
    public static function createDatabase(string $name): string
    {
        return sprintf('CREATE DATABASE %s', $name);
    }

    /**
     * Create a "SELECT" query.
     *
     * @param string $table The name of the table to select from.
     * @return Select The Select instance.
     */
    public static function select(string $table): Select
    {
        return new Select($table);
    }

    /**
     * Create an "UPDATE" query.
     *
     * @param string $table The name of the table to update.
     * @return Update The Update instance.
     */
    public static function update(string $table): Update
    {
        return new Update($table);
    }

 /**
     * Create a transaction query.
     *
     * @return Transaction The Transaction instance.
     */
    public static function transaction(): Transaction
    {
        return new Transaction();
    }

    /**
     * Create a "DELETE" query.
     *
     * @param string $table The name of the table to delete from.
     * @return Delete The Delete instance.
     */
    public static function delete(string $table): Delete
    {
        return new Delete($table);
    }

    /**
     * Create an "INSERT" query.
     *
     * @param string $table The name of the table to insert into.
     * @return Insert The Insert instance.
     */
    public static function insert(string $table): Insert
    {
        return new Insert($table);
    }

    /**
     * Create a "DROP" query.
     *
     * @param string $table The name of the table to drop.
     * @param string|null $action The drop action (e.g., "CASCADE", "RESTRICT").
     * @return Drop The Drop instance.
     */
    public static function drop(string $table, ?string $action = null): Drop
    {
        return new Drop($table, $action);
    }

    /**
     * Create an "ALTER" query.
     *
     * @param string $table The name of the table to alter.
     * @return Alter The Alter instance.
     */
    public static function alter(string $table): Alter
    {
        return new Alter($table);
    }

    /**
     * Create a column definition for a table.
     *
     * @param array $cols The columns .
     * @return Column The Column instance.
     */
    public static function column(array $cols): Column
    {
        return new Column($cols);
    }

    /**
     * Create a table instance.
     *
     * @param string $table The name of the table.
     * @return Table The Table instance.
     */
    public static function table(string $table): Table
    {
        return new Table($table);
    }

    /**
     * Create a "CREATE TABLE" query.
     *
     * @param string $table The name of the table.
     * @param array $columns The columns of the table.
     * @param array $keys The keys of the table.
     * @return CreateTable The CreateTable instance.
     */
    public static function createTable(string $table, array $columns, array $keys = []): CreateTable
    {
        return new CreateTable($table, $columns, $keys);
    }

    /**
     * Create a key instance.
     *
     * @param string $table The name of the table.
     * @param string $column The name of the column.
     * @return Key The Key instance.
     */
    public static function key(string $table, string $column): Key
    {
        return new Key($table, $column);
    }

    /**
     * Create an extractor instance to parse a query.
     *
     * @param string $query The SQL query to extract information from.
     * @return Extractor The Extractor instance.
     */
    public static function extract(string $query): Extractor
    {
        return new Extractor($query);
    }

    /**
     * Generate a "DESCRIBE" query.
     *
     * @param string $name The name of the table or database.
     * @return string The SQL query.
     */
    public static function describe(string $name): string
    {
        return sprintf('DESCRIBE %s', $name);
    }
}
