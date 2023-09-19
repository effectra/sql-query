<?php

declare(strict_types=1);

namespace Effectra\SqlQuery;

use Effectra\SqlQuery\Operations\Select;
use Effectra\SqlQuery\Operations\Insert;
use Effectra\SqlQuery\Operations\Update;
use Effectra\SqlQuery\Operations\Alter;
use Effectra\SqlQuery\Operations\Drop;
use Effectra\SqlQuery\Operations\CreateTable;
use Effectra\SqlQuery\Operations\Transaction;
use Effectra\SqlQuery\Operations\UpdateTable;
use Effectra\SqlQuery\Structure\Database;
use Effectra\SqlQuery\Structure\Table;

/**
 * Class Query
 *
 * The main class for creating SQL queries.
 */
class Query
{

    /**
     * @var string The currently set database driver.
     */
    protected static string $driver = Driver::MySQL;

    /**
     * @var string The generated SQL query string.
     */
    protected static string $query;

    /**
     * Set the database driver to be used for generating queries.
     *
     * @param string $driver The name of the database driver (e.g., 'mysql', 'postgresql').
     * @throws \Exception If the specified driver is not available in the package.
     */
    public static function driver(string $driver): void
    {
        if (!in_array($driver, Driver::getAvailableDrivers())) {
            throw new \Exception("This driver ($driver) not available on this package ");
        }
        static::$driver = $driver;
        Syntax::setDriver($driver);
    }

    /**
     * Get the currently set database driver.
     *
     * @return string The name of the currently set database driver.
     */
    public static function getDriver(): string
    {
        return static::$driver;
    }

    /**
     * Create a new database instance.
     *
     * @param string $name The name of the database.
     * @return Database A Database instance.
     */
    public static function database(string $name): Database
    {
        return new Database($name);
    }

    /**
     * Create a new table instance.
     *
     * @param string $name The name of the table.
     * @return Table A Table instance.
     */
    public static function table(string $name): Table
    {
        return new Table($name);
    }

    /**
     * Create a new SELECT query builder for a table.
     *
     * @param string $table The name of the table.
     * @return Select A Select query builder.
     */
    public static function select(string $table): Select
    {
        return new Select($table);
    }

    /**
     * Create a new INSERT query builder for a table.
     *
     * @param string $table The name of the table.
     * @param int $insert_type The type of INSERT statement (default is INSERT_VALUES).
     * @return Insert An Insert query builder.
     */
    public static function insert(string $table, int $insert_type = Insert::INSERT_VALUES): Insert
    {
        return new Insert($table, $insert_type);
    }

    /**
     * Create a new DROP query builder.
     *
     * @return Drop A Drop query builder.
     */
    public static function drop(): Drop
    {
        return new Drop();
    }

    /**
     * Create a new UPDATE query builder for a table.
     *
     * @param string $table The name of the table.
     * @return Update An Update query builder.
     */
    public static function update(string $table): Update
    {
        return new Update($table);
    }

    /**
     * Create a new ALTER query builder.
     *
     * @return Alter An Alter query builder.
     */
    public static function alter(): Alter
    {
        return new Alter();
    }

    /**
     * Create a new CREATE TABLE query builder.
     *
     * @param string $table_name The name of the table to create.
     * @param callable $table A callback function to define table columns and constraints.
     * @return CreateTable A CreateTable query builder.
     */
    public static function createTable(string $table_name, callable $table): CreateTable
    {
        return new CreateTable($table_name, $table);
    }

    /**
     * Create a new UPDATE TABLE query builder.
     *
     * @param string $table_name The name of the table to update.
     * @param callable $table A callback function to define table column modifications.
     * @return UpdateTable An UpdateTable query builder.
     */
    public static function updateTable(string $table_name, callable $table): UpdateTable
    {
        return new UpdateTable($table_name, $table);
    }

    /**
     * Create a new transaction instance.
     *
     * @return Transaction A Transaction instance.
     */
    public static function transaction(): Transaction
    {
        return new Transaction();
    }

    /**
     * Check if a column exists in a table within the database.
     *
     * @param string $table_name The name of the table to check.
     * @param string $column_name The name of the column to check.
     * @return Select A Select object configured to check for the existence of the specified column.
     */
    public function checkIfTheColumnExistsInTheTable($table_name, $column_name): Select
    {
        return (new Select($table_name))->columns(['COLUMN_NAME'])->from('INFORMATION_SCHEMA.COLUMNS')->whereTable($table_name)->whereColumn($column_name);
    }
}
