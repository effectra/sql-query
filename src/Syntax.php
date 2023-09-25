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
            "abs" => "ABS",
            "add" => "ADD",
            "all" => "ALL",
            "alter" => "ALTER",
            "alterDatabase" => "ALTER DATABASE",
            "alterTable" => "ALTER TABLE",
            "and" => "AND",
            "any" => "ANY",
            "aliases" => "AS",
            "as" => "AS",
            "asc" => "ASC",
            "avg" => "AVG",
            "begin" => "BEGIN",
            "between" => "BETWEEN",
            "case" => "CASE",
            "character" => "CHARACTER",
            "charset" => "CHARSET",
            "check" => "CHECK",
            "collate" => "COLLATE",
            "column" => "COLUMN",
            "columns" => "COLUMNS",
            "column_name" => "COLUMN_NAME",
            "commit" => "COMMIT",
            "count" => "COUNT",
            "connection_limit"=>"CONNECTION LIMIT",
            "create" => "CREATE",
            "createDatabase" => "CREATE DATABASE",
            "createIndex" => "CREATE INDEX",
            "createTable" => "CREATE TABLE",
            "crossJoin" => "CROSS JOIN",
            "database" => "DATABASE",
            "databases" => "DATABASES",
            "data_type" => "DATA TYPE",
            "default" => "DEFAULT",
            "defaultCharset" => "DEFAULT CHARSET",
            "delete" => "DELETE",
            "desc" => "DESC",
            "describe" => "DESCRIBE",
            "disk" => "DISK",
            "drop" => "DROP",
            "dropDatabase" => "DROP DATABASE",
            "dynamic" => "DYNAMIC",
            "else" => "ELSE",
            "end" => "END",
            "end_if" => "END IF",
            "engine" => "ENGINE=",
            "encoding" => "ENCODING",
            "exists" => "EXISTS",
            "fixed" => "FIXED",
            "format" => "FORMAT",
            "from" => "FROM",
            "groupBy" => "GROUP BY",
            "having" => "HAVING",
            "if" => "IF",
            "ifExists" => "IF EXISTS",
            "if_not" => "IF NOT",
            "ifNotExists" => "IF NOT EXISTS",
            "in" => "IN",
            "index" => "INDEX",
            "Indexes" => "INDEXES",
            "insert" => "INSERT",
            "into" => "INTO",
            "invisible" => "INVISIBLE",
            "is" => "IS",
            "join" => "JOIN",
            "joins" => "JOIN",
            "key" => "KEY",
            "lc_collate"=>"LC_COLLATE",
            "lc_ctype"=>"LC_CTYPE",
            "leftJoin" => "LEFT JOIN",
            "like" => "LIKE",
            "limit" => "LIMIT",
            "max" => "MAX",
            "memory" => "MEMORY",
            "min" => "MIN",
            "not" => "NOT",
            "not_null" => "NOT NULL",
            "null" => "NULL",
            "on" => "ON",
            "or" => "OR",
            "order" => "ORDER",
            "orderBy" => "ORDER BY",
            "owner"=>"OWNER",
            "pragma" => "PRAGMA",
            "rename" => "RENAME",
            "rightJoin" => "RIGHT JOIN",
            "rollback" => "ROLLBACK",
            "row_count" => "ROW_COUNT",
            "select" => "SELECT",
            "selfJoin" => "SELF JOIN",
            "set" => "SET",
            "show" => "SHOW",
            "storage" => "STORAGE",
            "sum" => "SUM",
            "table" => "TABLE",
            "tables" => "TABLES",
            "table_name" => "TABLE_NAME",
            "template"=>"TEMPLATE",
            "than" => "THAN",
            "then" => "THEN",
            "to" => "TO",
            "truncate" => "TRUNCATE",
            "union" => "UNION",
            "unsigned" => "UNSIGNED",
            "update" => "UPDATE",
            "values" => "VALUES",
            "visible" => "VISIBLE",
            "wildcards" => "%",
            "when" => "WHEN",
            "where" => "WHERE",
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
