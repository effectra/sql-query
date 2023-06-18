<?php

declare(strict_types=1);

namespace Effectra\SqlQuery;


class Query
{

    public const CURRENT_TIMESTAMP = 'current_timestamp()';

    public static function createDatabase($name)
    {
        return sprintf('CREATE DATABASE %s', $name);
    }

    public static function select($table)
    {
        return new Select($table);
    }

    public static function update($table)
    {
        return new Update($table);
    }

    public static function delete($table)
    {
        return new Delete($table);
    }

    public static function insert($table)
    {
        return new Insert($table);
    }

    public static function drop($table, $action = null)
    {
        return new Drop($table, $action);
    }

    public static function alter($table)
    {
        return new Alter($table);
    }

    public static function column($name, $type)
    {
        return new Column($name, $type);
    }

    public static function table($table)
    {
        return new Table($table);
    }

    public static function createTable($table, $columns, $keys = [])
    {
        return new CreateTable($table, $columns, $keys);
    }

    public static function key($table, $column)
    {
        return new Key($table, $column);
    }

    public static function extract(string $query)
    {
        return new Extractor($query);
    }

    public static function describe(string $name)
    {
        return sprintf('DESCRIBE %s', $name);
    }
}
