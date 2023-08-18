<?php

declare(strict_types=1);

namespace Effectra\SqlQuery;

/**
 * Class Table
 * Represents a database table and provides methods to define its structure and generate SQL queries.
 */
class Table
{

    protected string $tableName;
    protected array $cols = [];
    protected array $columns = [];
    /**
     * Table constructor.
     * @param string $tableName The name of the table.
     */
    public function __construct(string $tableName)
    {
        $this->tableName = $tableName;
    }

    /**
     * Sets the name of the table.
     * @param string $tableName The name of the table.
     */
    public function setTableName($tableName)
    {
        $this->tableName = $tableName;
    }
    /**
     * Retrieves the name of the table.
     * @return string The name of the table.
     */
    public function getTableName()
    {
        return $this->tableName;
    }
    /**
     * Sets the columns for the table.
     * @param array $columns The columns for the table.
     */
    public function setColumns($columns)
    {
        $this->columns = $columns;
    }
    /**
     * Retrieves the columns for the table.
     * @return array The columns for the table.
     */
    public function getColumns()
    {
        return $this->columns;
    }
    /**
     * Checks if a column exists in the table.
     * @param string $column The name of the column.
     * @return bool True if the column exists, false otherwise.
     */
    public function columnsExists($columns)
    {
        return in_array($columns, $this->getColumns());
    }
    /**
     * Adds an "id" column to the table.
     * @param string $name The name of the column.
     * @return $this The current instance of the Table class.
     */
    public function id($name = 'id')
    {
        return $this->bigInteger($name)->size(20);
    }
    /**
     * Adds an auto-incrementing column to the table.
     * @param string $name The name of the column.
     * @return $this The current instance of the Table class.
     */
    public function autoIncrement($name = 'id')
    {
        $col = ['name' => $name, 'type' => 'bigint', 'size' => 20, 'auto_increment' => true, 'key' => 'primary'];
        $this->cols[] = $col;
        return $this;
    }
    /**
     * Adds a "text" column to the table.
     * @param string $name The name of the column.
     * @return $this The current instance of the Table class.
     */
    public function text($name)
    {
        $col = ['name' => $name, 'type' => 'text'];
        $this->cols[] = $col;
        return $this;
    }
    /**
     * Adds a "string" column to the table.
     * @param string $name The name of the column.
     * @return $this The current instance of the Table class.
     */
    public function string($name)
    {
        return $this->varchar($name);
    }
    /**
     * Adds a "varchar" column to the table.
     * @param string $name The name of the column.
     * @param int $size The size of the column.
     * @return $this The current instance of the Table class.
     */
    public function varchar($name)
    {
        $col = ['name' => $name, 'type' => 'varchar', 'size' => 255];
        $this->cols[] = $col;
        return $this;
    }
    /**
     * Adds a "char" column to the table.
     * @param string $name The name of the column.
     * @return $this The current instance of the Table class.
     */
    public function char($name)
    {
        $col = ['name' => $name, 'type' => 'char', 'size' => 4];
        $this->cols[] = $col;
        return $this;
    }
    /**
     * Adds a "longtext" column to the table.
     * @param string $name The name of the column.
     * @return $this The current instance of the Table class.
     */
    public function longText($name)
    {
        $col = ['name' => $name, 'type' => 'longtext'];
        $this->cols[] = $col;
        return $this;
    }
    /**
     * Adds a "decimal" column to the table.
     * @param string $name The name of the column.
     * @param int $total The total number of digits.
     * @param int $places The number of decimal places.
     * @return $this The current instance of the Table class.
     */
    public function decimal($name, $total = 8, $places = 2)
    {
        $col = ['name' => $name, 'type' => 'decimal', 'size' => "$total,$places"];
        $this->cols[] = $col;
        return $this;
    }
    /**
     * Adds a "boolean" column to the table.
     * @param string $name The name of the column.
     * @return $this The current instance of the Table class.
     */
    public function boolean($name)
    {
        return $this->tinyint($name)->size(1);
    }
    /**
     * Adds an "integer" column to the table.
     * @param string $name The name of the column.
     * @return $this The current instance of the Table class.
     */
    public function integer($name)
    {
        return $this->int($name);
    }
    /**
     * Adds an "integer" column to the table.
     * @param string $name The name of the column.
     * @return $this The current instance of the Table class.
     */
    public function int($name)
    {
        $col = ['name' => $name, 'type' => 'int'];
        $this->cols[] = $col;
        return $this;
    }
    /**
     * Adds a "tinyint" column to the table.
     * @param string $name The name of the column.
     * @return $this The current instance of the Table class.
     */
    public function tinyint($name)
    {
        $col = ['name' => $name, 'type' => 'tinyint', 'size' => 1];
        $this->cols[] = $col;
        return $this;
    }
    /**
     * Adds a "bigint" column to the table.
     * @param string $name The name of the column.
     * @return $this The current instance of the Table class.
     */
    public function bigInteger($name)
    {
        $col = ['name' => $name, 'type' => 'bigint', 'size' => 20];
        $this->cols[] = $col;
        return $this;
    }
    /**
     * Adds a "blob" column to the table.
     * @param string $name The name of the column.
     * @return $this The current instance of the Table class.
     */
    public function blob($name)
    {
        $col = ['name' => $name, 'type' => 'blob'];
        $this->cols[] = $col;
        return $this;
    }
    /**
     * Adds a "timestamp" column to the table.
     * @param string $name The name of the column.
     * @param bool $default_current_time Whether to set the default value to the current timestamp.
     * @return $this The current instance of the Table class.
     */
    public function timestamp($name, $default_current_time = false)
    {
        $col = ['name' => $name, 'type' => 'timestamp', 'nullable' => true, 'default' => 'NULL'];
        if ($default_current_time) {
            $col['default'] = 'CURRENT_TIMESTAMP';
        }

        $this->cols[] = $col;

        return $this;
    }
    /**
     * Adds a "timestamp" column to the table.
     * @param string $name The name of the column.
     * @param bool $default_current_time Whether to set the default value to the current timestamp.
     * @return $this The current instance of the Table class.
     */
    public function timestamps($default_current_time = true)
    {
        $created_at = ['name' => 'created_at', 'type' => 'timestamp', 'nullable' => true, 'default' => 'NULL'];
        $updated_at = ['name' => 'updated_at', 'type' => 'timestamp', 'nullable' => true, 'default' => 'NULL'];

        if ($default_current_time) {
            $created_at['default'] = 'CURRENT_TIMESTAMP';
            $updated_at['default'] = 'CURRENT_TIMESTAMP';
        }

        $this->cols[] = $created_at;
        $this->cols[] = $updated_at;

        return $this;
    }
    /**
     * Adds a "date" column to the table.
     * @param string $name The name of the column.
     * @return $this The current instance of the Table class.
     */
    public function date($name)
    {
        $col = ['name' => $name, 'type' => 'date'];
        $this->cols[] = $col;
        return $this;
    }
    /**
     * Adds a "time" column to the table.
     * @param string $name The name of the column.
     * @return $this The current instance of the Table class.
     */
    public function time($name)
    {
        $col = ['name' => $name, 'type' => 'time'];
        $this->cols[] = $col;
        return $this;
    }
    /**
     * Adds a "year" column to the table.
     * @param string $name The name of the column.
     * @return $this The current instance of the Table class.
     */
    public function year($name)
    {
        $col = ['name' => $name, 'type' => 'year'];
        $this->cols[] = $col;
        return $this;
    }
    /**
     * Makes the last added column nullable.
     * @return $this The current instance of the Table class.
     */
    public function nullable()
    {
        $lastCol = &$this->cols[count($this->cols) - 1];
        $lastCol['nullable'] = true;
        return $this;
    }
    /**
     * Sets the default value of the last added column to the current timestamp.
     * @return $this The current instance of the Table class.
     */
    public function useCurrentTime()
    {
        $lastCol = &$this->cols[count($this->cols) - 1];
        $lastCol['default'] = 'CURRENT_TIMESTAMP';
        return $this;
    }
    /**
     * Adds a "timestamp" column with the default value set to the current timestamp.
     * @param string $name The name of the column.
     * @return $this The current instance of the Table class.
     */
    public function currentTime($name)
    {
        $col = ['name' => $name, 'type' => 'timestamp', 'default' => 'CURRENT_TIMESTAMP'];
        $this->cols[] = $col;
        return $this;
    }
    /**
     * Adds a "json" column.
     * @param string $name The name of the column.
     * @return $this The current instance of the Table class.
     */
    public function json($name)
    {
        $col = [
            'name' => $name,
            'type' => 'longtext',
            'check' => "json_valid(`$name`)"
        ];
        $this->cols[] = $col;
        return $this;
    }
    /**
     * Adds an "enum" column.
     * @param string $name The name of the column.
     * @param array $values The allowed values for the enum column.
     * @return $this The current instance of the Table class.
     */
    public function enum($name, array $values)
    {
        $col = [
            'name' => $name,
            'type' => '',
            'enum_values' => $values
        ];
        $this->cols[] = $col;
        return $this;
    }
    /**
     * Adds an "enum" column with predefined values for status.
     * @param string $name The name of the column (default: 'status').
     * @return $this The current instance of the Table class.
     */
    public function enumStatus($name = 'status')
    {
        $col = [
            'name' => $name,
            'type' => '',
            'enum_values' => ['pending', 'approved', 'declined', 'removed'],
        ];
        $this->cols[] = $col;
        return $this->default('pending');
    }
    /**
     * Sets the default value for the last added column.
     * @param mixed $value The default value.
     * @return $this The current instance of the Table class.
     */
    public function default($value)
    {

        $lastCol = &$this->cols[count($this->cols) - 1];

        if (is_string($value)) {
            $value = "'" . $value . "'";
        }

        if (is_array($value) || $lastCol['type'] === 'json') {
            $value = "'" . json_encode($value) . "'";
        }

        $lastCol['default'] =  $value;
        return $this;
    }
    /**
     * Sets the size for the last added column.
     * @param int $size The size of the column (default: 255).
     * @return $this The current instance of the Table class.
     */
    public function size($size = 255)
    {
        $lastCol = &$this->cols[count($this->cols) - 1];
        $lastCol['size'] = $size;
        return $this;
    }
    /**
     * Sets the collation for the last added column.
     * @param string $value The collation value (default: 'utf8mb4_unicode_ci').
     * @return $this The current instance of the Table class.
     */
    public function collate($value = 'utf8mb4_unicode_ci')
    {
        $lastCol = &$this->cols[count($this->cols) - 1];
        $lastCol['collate'] = $value;
        return $this;
    }
    /**
     * Adds a unique constraint to the last added column.
     * @return $this The current instance of the Table class.
     */
    public function unique()
    {
        $lastCol = &$this->cols[count($this->cols) - 1];
        $lastCol['key'] = 'unique';
        return $this;
    }
    /**
     * Sets the "unsigned" attribute for the last added column.
     * @return $this The current instance of the Table class.
     */
    public function unsigned()
    {
        $lastCol = &$this->cols[count($this->cols) - 1];
        $lastCol['unsigned'] = true;
        return $this;
    }
    /**
     * Specifies the column to be placed after another column.
     * @param string $columnName The name of the column to place the current column after.
     * @return $this The current instance of the Table class.
     */
    public function after($columnName)
    {
        $lastCol = &$this->cols[count($this->cols) - 1];
        $lastCol['after'] = $columnName;
        return $this;
    }
    /**
     * Specifies the last added column as the primary key.
     * @return $this The current instance of the Table class.
     */
    public function primaryKey()
    {
        $lastCol = &$this->cols[count($this->cols) - 1];
        // $lastCol['name'] = $columnName;
        $lastCol['key'] = 'primary';
        return $this;
    }
    /**
     * Sets the character set for the last added column.
     * @param string $charset The character set to use.
     * @return $this The current instance of the Table class.
     */
    public function charset($charset)
    {
        $lastCol = &$this->cols[count($this->cols) - 1];
        $lastCol['charset'] = $charset;
        return $this;
    }
    /**
     * Drops the table.
     * @return $this The current instance of the Table class.
     */
    public function drop()
    {
        $col = ['name' => $this->tableName, 'modify' => 'drop', 'act' => 'table'];
        $this->cols[] = $col;
        return $this;
    }
    /**
     * Drops the table if it exists.
     * @return $this The current instance of the Table class.
     */
    public function dropIfExists()
    {
        $col = ['name' => $this->tableName, 'modify' => 'drop', 'act' => 'table_if_exists'];
        $this->cols[] = $col;
        return $this;
    }
    /**
     * Drops a specific column from the table.
     * @param string $name The name of the column to drop.
     * @return $this The current instance of the Table class.
     */
    public function dropColumn($name)
    {
        $col = ['name' => $name, 'modify' => 'drop', 'act' => 'column'];
        $this->cols[] = $col;
        return $this;
    }
    /**
     * Drops a specific key from the table.
     * @param string $name The name of the key to drop.
     * @param string $type The type of the key (e.g., 'primary', 'unique', 'index', 'foreign').
     * @return $this The current instance of the Table class.
     */
    public function dropKey($name, $type)
    {
        $col = ['name' => $name, 'modify' => 'drop', 'act' => 'key', 'type' => $type];
        $this->cols[] = $col;
        return $this;
    }
    /**
     * Renames a column in the table.
     * @param string $from The current name of the column.
     * @param string $to The new name of the column.
     * @return $this The current instance of the Table class.
     */
    public function renameColumn($from, $to)
    {
        $col = ['name' => $from, 'to' => $to, 'act' => 'rename_table'];
        $this->cols[] = $col;
        return $this;
    }
    /**
     * Adds a foreign key constraint to the table.
     * @param string $columnName The name of the column to add the foreign key constraint.
     * @param string $foreignTable The name of the foreign table.
     * @param string $foreignColumn The name of the foreign column.
     * @return $this The current instance of the Table class.
     */
    public function addForeignKey($columnName, $foreignTable, $foreignColumn)
    {
        $lastCol = &$this->cols[count($this->cols) - 1];
        $lastCol['foreign_key'] = [
            'column_name' => $columnName,
            'foreign_table' => $foreignTable,
            'foreign_column' => $foreignColumn
        ];
        return $this;
    }
    /**
     * Specifies the name of a constraint for the last added column.
     * @param string $name The name of the constraint.
     * @return $this The current instance of the Table class.
     */
    public function constraintName($name)
    {
        $lastCol = &$this->cols[count($this->cols) - 1];
        $lastCol['constraint_name'] = $name;
        return $this;
    }
    /**
     * Specifies a foreign key reference for the last added column.
     * @param string $columnName The name of the column to create the foreign key reference.
     * @param string $foreignTable The name of the foreign table.
     * @param string $foreignColumn The name of the foreign column.
     * @return $this The current instance of the Table class.
     */
    public function references($columnName, $foreignTable, $foreignColumn)
    {
        $lastCol = &$this->cols[count($this->cols) - 1];
        $lastCol['references'] = [
            'column_name' => $columnName,
            'foreign_table' => $foreignTable,
            'foreign_column' => $foreignColumn
        ];
        return $this;
    }
    /**
     * Build the SQL query based on the specified action.
     *
     * @param string $act The action to perform (create or modify)
     * @return string The generated SQL query
     */
    public function buildQuery($act = 'create')
    {
        $query = '';
        if ($act === 'modify') {
            foreach ($this->cols as $col) {
                $alter = new Alter($this->tableName);

                if (isset($col['modify']) && $col['modify'] === 'drop') {
                    if (isset($col['act']) && $col['act'] === 'table'){
                        $query = (string) Query::drop($col['name'])->dropTable() ;
                    }
                    if (isset($col['act']) && $col['act'] === 'column')  $query .= (string) $alter->dropColumn($col['name']) . ';';
                    if (isset($col['act']) && $col['act'] === 'key')  $query .= (string) $alter->dropKey($col['name'], $col['type']) . ';';
                }
                if (!isset($col['modify'])) {
                    if ($this->columnsExists($col['name'])) {
                        $query .= (string) $alter->modifyColumn((string) new Column($col) . $this->keysQuery($col, false)) . ';';
                    }
                    if (!$this->columnsExists($col['name'])) {
                        $query .= (string) $alter->addColumn((string) new Column($col) . $this->keysQuery($col, false)) . ';';
                    }
                }
            }

            return $query;
        }
        if ($act === 'create') {
            return $this->createTableQuery();
        }
    }
    /**
     * Generate column queries.
     *
     * @return array An array of column queries as strings
     */
    public function columnsQuery()
    {
        return array_map(fn ($col) =>  (string) new Column($col), $this->cols);
    }
    /**
     * Generate key query for a column.
     *
     * @param array $col The column definition
     * @param bool $withColumnName Whether to include the column name in the key query
     * @return string The key query for the column
     */
    public function keysQuery($col, $withColumnName = true)
    {
        return isset($col['key']) ? (string) (new Key($col['name'], $col['key']))->withColumnName($withColumnName)->build() : '';
    }
    /**
     * Generate key queries for all columns.
     *
     * @return array An array of key queries as strings
     */
    public function keysQueryTable()
    {
        return array_map(fn ($col) => $this->keysQuery($col), $this->cols);
    }
    /**
     * Generate the create table query.
     *
     * @return string The create table query
     */
    public function createTableQuery()
    {
        return (string) new CreateTable($this->tableName, $this->columnsQuery(), $this->keysQueryTable());
    }
    /**
     * Generate the drop column queries for all columns.
     *
     * @return string The drop column queries
     */
    public function dropColumnInTableQuery()
    {
        $queryCols = [];
        foreach ($this->cols as $col) {
            $alter = new Alter($this->tableName);
            $queryCols[] = (string) $alter->dropColumn($col['name']);
        }
        return join(';', $queryCols);
    }
    /**
     * Generate the modify column queries for all columns.
     *
     * @return string The modify column queries
     */
    public function modifyColumnInTableQuery()
    {
        $queryCols = [];
        foreach ($this->cols as $col) {
            $alter = new Alter($this->tableName);
            $queryCols[] = (string) $alter->modifyColumn((string) new Column($col) . $this->keysQuery($col, false));
        }
        return join(';', $queryCols);
    }
    /**
     * Convert the Table object to a string.
     *
     * @return string The generated SQL query
     */
    public function addColumnInTableQuery()
    {
        $queryCols = [];
        foreach ($this->cols as $col) {
            $alter = new Alter($this->tableName);
            $queryCols[] =  (string) $alter->modifyColumn((string) new Column($col) . $this->keysQuery($col, false));
        }
        return join(';', $queryCols);
    }
    /**
     * Convert the Table object to a string.
     *
     * @return string The generated SQL query
     */
    public function __toString()
    {
        return $this->buildQuery();
    }
}
