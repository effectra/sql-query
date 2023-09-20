<?php

declare(strict_types=1);

namespace Effectra\SqlQuery;

/**
 * Class Syntax
 *
 * A class for managing SQL query syntax and keywords.
 */
class Syntax
{
    use DriverTrait;

    // Constants for spacing and conjunctions
    public const SPACE_BETWEEN = 1;
    public const SPACE_LEFT = 2;
    public const SPACE_RIGHT = 3;
    public const NEW_LINE = 4;

    public const BETWEEN_COLUMN_AND = 'and';
    public const BETWEEN_COLUMN_OR = 'or';

    public const ORDER_BY_ASC = 'asc';
    public const ORDER_BY_DESC = 'desc';

    /**
     * Add spacing to a keyword or operator based on the specified type.
     *
     * @param string $word The keyword or operator.
     * @param int|null $type The spacing type (e.g., self::SPACE_BETWEEN).
     * @return string The spaced keyword or operator.
     */
    public static function space($word, $type = null)
    {
        return match ($type) {
            self::SPACE_BETWEEN => " $word ",
            self::SPACE_RIGHT => "$word ",
            self::SPACE_LEFT => " $word",
            self::NEW_LINE => "$word\n",
            default => "$word"
        };
    }

    /**
     * Get a specific command with optional spacing.
     *
     * @param string $name The name of the command.
     * @param int|null $space The spacing type (e.g., self::SPACE_BETWEEN).
     * @return string The formatted command.
     */
    public function getCommand($name, $space = null): string
    {
        $command =  $this->commands()[$name];
        return $this->space($command, $space) ?? "";
    }

    /**
     * Get a specific operator with optional spacing.
     *
     * @param string $name The name of the operator.
     * @param int|null $space The spacing type (e.g., self::SPACE_BETWEEN).
     * @return string The formatted operator.
     */
    public function getOperator($name, $space = null): string
    {
        $command =  $this->operators()[$name];
        return $this->space($command, $space) ?? "";
    }

    /**
     * Get a specific key with optional spacing.
     *
     * @param string $name The name of the key.
     * @param int|null $space The spacing type (e.g., self::SPACE_BETWEEN).
     * @return string The formatted key.
     */
    public function getKey($name, $space = null): string
    {
        $command =  $this->keys()[$name];
        return $this->space($command, $space) ?? "";
    }

    /**
     * Get an array of available SQL commands.
     *
     * @return array An array of SQL commands.
     */
    public function commands(): array
    {
        return [
            'database' => 'DATABASE',
            'table' => 'TABLE',
            'tables' => 'TABLES',
            'table_name' => 'TABLE_NAME',
            'column' => 'COLUMN',
            'column_name' => 'COLUMN_NAME',
            'index' => 'INDEX',
            'key' => 'KEY',
            'rename' => 'RENAME',
            'select' => 'SELECT',
            'update' => 'UPDATE',
            'delete' => 'DELETE',
            'truncate' => 'TRUNCATE',
            'insert' => 'INSERT',
            'into' => 'INTO',
            'alter' => 'ALTER',
            'data_type' => 'DATA TYPE',
            'createDatabase' => 'CREATE DATABASE',
            'alterDatabase' => 'ALTER DATABASE',
            'createTable' => 'CREATE TABLE',
            'alterTable' => 'ALTER TABLE',
            'drop' => 'DROP',
            'dropDatabase' => 'DROP DATABASE',
            'createIndex' => 'CREATE INDEX',
            'orderBy' => 'ORDER BY',
            'Index' => 'INDEX',
            'limit' => 'LIMIT',
            'min' => 'MIN',
            'max' => 'MAX',
            'count' => 'COUNT',
            'avg' => 'AVG',
            'sum' => 'SUM',
            'like' => 'LIKE',
            'wildcards' => '%',
            'in' => 'IN',
            'if' => 'IF',
            'if_not' => 'IF NOT',
            'end_if' => 'END IF',
            'than' => 'THAN',
            'where' => 'WHERE',
            'between' => 'BETWEEN',
            'aliases' => 'AS',
            'joins' => 'JOIN',
            'union' => 'UNION',
            'groupBy' => 'GROUP BY',
            'having' => 'HAVING',
            'exists' => 'EXISTS',
            'ifExists' => 'IF EXISTS',
            'ifNotExists' => 'IF NOT EXISTS',
            'add' => 'ADD',
            'any' => 'ANY',
            'all' => 'ALL',
            'and' => 'AND',
            'or' => 'OR',
            'to' => 'TO',
            'on' => 'ON',
            'as' => 'AS',
            'case' => 'CASE',
            'show' => 'SHOW',
            'describe' => 'DESCRIBE',
            'pragma' => 'PRAGMA',
            'selfJoin' => 'SELF JOIN',
            'leftJoin' => 'LEFT JOIN',
            'rightJoin' => 'RIGHT JOIN',
            'crossJoin' => 'CROSS JOIN',
            'engine' => 'ENGINE=',
            'defaultCharset' => 'DEFAULT CHARSET',
            'begin' => 'BEGIN,',
            'commit' => 'COMMIT,',
            'from' => 'FROM',
            'asc' => 'ASC',
            'desc' => 'DESC',
            'abs' => 'ABS',
            'when' => 'WHEN',
            'then' => 'THEN',
            'else' => 'ELSE',
            'end' => 'END',
            'not' => 'NOT',
            'is' => 'IS',
            'null' => 'NULL',
            'values' => 'VALUES',
            'default' => 'DEFAULT',
            'set' => 'SET',
            'unsigned' => 'UNSIGNED',
            'visible' => 'VISIBLE',
            'invisible' => 'INVISIBLE',
            'format' => 'FORMAT',
            'storage' => 'STORAGE',
            'fixed' => 'FIXED',
            'dynamic' => 'DYNAMIC',
            'disk' => 'DISK',
            'memory' => 'MEMORY',
            'charset' => 'CHARSET',
            'character' => 'CHARACTER',
            'collate' => 'COLLATE',
            'begin' => 'BEGIN',
            'commit' => 'COMMIT',
            'rollback' => 'ROLLBACK',
            'row_count' => 'ROW_COUNT',
            'else' => 'ELSE',
            'check' => 'CHECK',
        ];
    }

    /**
     * Get an array of available SQL operators.
     *
     * @return array An array of SQL operators.
     */
    public function operators(): array
    {
        return [
            'add' => '+',
            'subtract' => '-',
            'multiply' => '*',
            'divide' => '/',
            'modulo' => '%',
            'bitwise_and' => '&',
            'bitwise_or' => '|',
            'bitwise_xor' => '^',
            'equal' => '=',
            'greater_than' => '>',
            'less_than' => '<',
            'greater_than_or_equal' => '>=',
            'less_than_or_equal' => '<=',
            'not_equal' => '!=',
            'not_equal_2' => '<>',
        ];
    }

    /**
     * Get an array of available SQL date functions.
     *
     * @return array An array of SQL date functions.
     */
    public function dateFunctions(): array
    {
        return [
            'current_timestamp_upper' =>    'CURRENT_TIMESTAMP',
            'now' =>                        'NOW()',
            'curDate' =>                    'CURDATE()',
            'curTime' =>                    'CURTIME()',
            'sysDate' =>                    'SYSDATE()',
            'getDate' =>                    'GETDATE()',
            'current_timestamp' =>          'current_timestamp()',
        ];
    }

    /**
     * Get an array of available SQL keys and constraints.
     *
     * @return array An array of SQL keys and constraints.
     */
    public function keys(): array
    {
        return [
            'primary' => 'PRIMARY KEY',
            'unique' => 'UNIQUE',
            'foreign' => 'FOREIGN KEY',
            'auto_increment' => match ($this->getDriver()) {
                'mysql' => 'AUTO_INCREMENT',
                'sqlite' => 'AUTOINCREMENT',
                'postgresql' => 'SERIAL',
                default => 'AUTO_INCREMENT',
            }
        ];
    }
}
