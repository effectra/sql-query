<?php

declare(strict_types=1);

namespace Effectra\SqlQuery\Build;

use Effectra\SqlQuery\Attribute;
use Effectra\SqlQuery\Driver;
use Effectra\SqlQuery\Operations\Alter;
use Effectra\SqlQuery\Operations\Info;
use Effectra\SqlQuery\Syntax;

/**
 * Class DatabaseQueryBuilder
 *
 * Represents a query builder for generating SQL database-related statements (e.g., CREATE DATABASE, DROP DATABASE, etc.).
 *
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

        $query = $this->syntax->getCommand('createDatabase', 1) . $this->getAttribute('db_name');

        $options = $this->getAttribute('options') ?? [];


        if($this->syntax->getDriver() === Driver::MySQL){

            if(isset($options['character'])){
                $query .=  $this->syntax->getCommand('character', 1) .  $this->syntax->getCommand('set', 1). $options['character'];
            }
            if(isset($options['collate'])){
                $query .=  $this->syntax->getCommand('collate', 1) . $options['collate'];
            }
        }

        if($this->syntax->getDriver() === Driver::MySQL){

            if(isset($options['encoding'])){
                $query .=  $this->syntax->getCommand('encoding', 1) .  $this->syntax->getOperator('equal', 1). $options['encoding'];
            }
            if(isset($options['lc_collate'])){
                $query .=  $this->syntax->getCommand('lc_collate', 1) .  $this->syntax->getOperator('equal', 1). $options['lc_collate'];
            }
            if(isset($options['lc_ctype'])){
                $query .=  $this->syntax->getCommand('lc_ctype', 1) .  $this->syntax->getOperator('equal', 1). $options['lc_ctype'];
            }
            if(isset($options['owner'])){
                $query .=  $this->syntax->getCommand('owner', 1) .  $this->syntax->getOperator('equal', 1). $options['owner'];
            }
            if(isset($options['template'])){
                $query .=  $this->syntax->getCommand('template', 1) .  $this->syntax->getOperator('equal', 1). $options['template'];
            }
            if(isset($options['connection_limit'])){
                $query .=  $this->syntax->getCommand('connection_limit', 1) .  $this->syntax->getOperator('equal', 1). $options['connection_limit'];
            }
          
        }


        $query = (string) match($this->syntax->getDriver()){
            Driver::MySQL => $query,
            Driver::PostgreSQL =>  $query,
            Driver::SQLite => '',
        };

        if(empty($query)){
            throw new \Exception("Error Processing Query, driver '{$this->syntax->getDriver()}' doesn't has statement for create database");
        }
        return $query;
    }

    /**
     * Generate the SQL query for dropping a database.
     *
     * @return string The generated SQL query for dropping a database.
     */
    public function drop(): string
    {
        $query = (string) match($this->syntax->getDriver()){
            Driver::MySQL => $this->syntax->getCommand('dropDatabase', 1) . $this->getAttribute('db_name'),
            Driver::PostgreSQL => '',
            Driver::SQLite => '',
        };

        if(empty($query)){
            throw new \Exception("Error Processing Query, driver '{$this->syntax->getDriver()}' doesn't has statement for drop database");
        }
        return $query;
    }

    /**
     * Generate the SQL query for renaming a database (PostgreSQL specific).
     *
     * @return string The generated SQL query for renaming a database.
     * @throws \Exception If the current driver does not support database renaming.
     */
    public function rename(): string
    {
        $query = (string) match($this->syntax->getDriver()){
            Driver::MySQL => (new Alter())->database($this->getAttribute('db_name'))->renameDatabase($this->getAttribute('rename')),
            Driver::PostgreSQL => '',
            Driver::SQLite => '',
        };

        if(empty($query)){
            throw new \Exception("Error Processing Query, driver '{$this->syntax->getDriver()}' doesn't has statement for rename database");
        }
        return $query;
    }

    /**
     * Generate the SQL query for retrieving a list of tables in the database.
     *
     * @return string The generated SQL query for retrieving tables.
     * @throws \Exception If the current driver is not recognized.
     */
    public function getTables(): string
    {
       return (string) (new Info())->listTables();
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

        throw new \Exception("Error Processing Query,there is no database statement");
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
