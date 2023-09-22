<?php

declare(strict_types=1);

namespace Effectra\SqlQuery\Build;

use Effectra\SqlQuery\Attribute;
use Effectra\SqlQuery\Destruct\ColumnDestruct;
use Effectra\SqlQuery\Driver;
use Effectra\SqlQuery\Operations\Alter;
use Effectra\SqlQuery\Operations\Drop;
use Effectra\SqlQuery\Operations\Select;
use Effectra\SqlQuery\Syntax;

/**
 * Class TableQueryBuilder
 *
 * Represents a query builder for creating, updating, and retrieving information about database tables.
 *
 * @package Effectra\SqlQuery\Build
 */
class TableQueryBuilder extends Attribute
{

    /**
     * Constructor for the TableQueryBuilder.
     *
     * @param array $attributes An array of attributes used in the query.
     * @param Syntax $syntax The syntax handler for generating SQL syntax.
     */
    public function __construct(protected array $attributes, protected Syntax $syntax)
    {
        $cols = $this->getAttribute('cols');
        if ($cols) {
            $this->setAttribute('cols', $this->removeDuplicatesByKey($cols, 'column_name'));
        }
    }

    /**
     * Remove duplicate columns based on a specified key.
     *
     * @param array $array The array containing columns.
     * @param string $keyToCheck The key to check for duplicates.
     *
     * @return array The array with duplicate columns removed.
     */
    public function removeDuplicatesByKey($array, $keyToCheck): array
    {
        $result = [];
        $keyIndex = [];

        foreach ($array as $item) {
            $keyValue = $item[$keyToCheck];

            // Store the last added item for the key
            $keyIndex[$keyValue] = $item;

            // Overwrite the previous value for the same key
            $result[$keyValue] = $item;
        }

        // Return only the values from the result array to reset keys
        return array_values($result);
    }


    /**
     * Get the operation associated with the query (create_table, update_table, info_table, etc.).
     *
     * @return string The operation associated with the query.
     */
    public function getOperation(): string
    {
        return $this->getAttribute('operation');
    }

    /**
     * Get the SQL command to start creating a table.
     *
     * @return string The SQL command for creating a table.
     */
    public function start()
    {
        return $this->syntax->getCommand('createTable');
    }

    /**
     * Build the final SQL query based on the operation and attributes.
     *
     * @return string The generated SQL query.
     */
    public function tableName(): string
    {
        return $this->getAttribute('table_name');
    }

    /**
     * Convert the object to its string representation (generates the SQL query).
     *
     * @return string The generated SQL query.
     */
    public function columns(): string
    {
        $cols = [];
        foreach ($this->getAttribute('cols') as $col) {
            $cols[] = (string) new ColumnDestruct($col);
        }
        return join(",\n", $cols);
    }

    /**
     * Get the SQL command for updating the table structure.
     *
     * @return string The SQL command for updating the table.
     */
    public function update(): string
    {
        $result = [];
        foreach ($this->getAttributes() as $attributeKey => $attributeValue) {
            if ($attributeKey === 'rename_table') {
                $result[] = (string) (new Alter())
                    ->table($this->getAttribute('table_name'))
                    ->renameTable($attributeValue);
            }
            if ($attributeKey === 'rename_column') {
                $result[] =  (string) (new Alter())
                    ->table($this->getAttribute('table_name'))
                    ->column($attributeValue['old'])
                    ->renameColumn($attributeValue['new']);
            }
            if ($attributeKey === 'drop_column') {
                $drop = new Drop();
                $drop->table($this->getAttribute('table_name'))->column($attributeValue)->dropColumn();
                $result[] = (string) $drop;
            }

            if ($attributeKey === 'cols') {
                $cols = [];
                foreach ($attributeValue as $col) {
                    $cols[] =  (string) (new Alter())->table($this->getAttribute('table_name'))->addColumn($col['column_name'], $col);
                }
                $result[] = join(';', $cols);
            }

            if ($attributeKey === 'drop_table') {
                $drop = new Drop();
                $drop->table($this->getAttribute('table_name'))->dropTable();
                $result[] = (string) $drop;
            }

            if ($attributeKey === 'drop_key') {
                $drop = new Drop();
                $drop->table($this->getAttribute('table_name'))->column($attributeValue);

                if ($this->getAttribute('drop_key') === 'primary') {
                    $drop->dropPrimaryKey();
                }
                if ($this->getAttribute('drop_key') === 'foreign') {
                    $drop->dropForeignKey();
                }
                if ($this->getAttribute('drop_key') === 'unique') {
                    $drop->dropUniqueKey();
                }
                if ($this->getAttribute('drop_key') === 'index') {
                    $drop->dropIndex();
                }
                
                if ($this->getAttribute('drop_key') === 'key') {
                    $drop->dropKey();
                }
                $result[] = (string) $drop;
            }
        }
        return join(';', $result);
    }

    /**
     * Get the engine (storage engine) specification for the table.
     *
     * @return string The SQL specification for the table engine.
     */
    public function engine(): string
    {
        if($this->syntax->getDriver() === Driver::SQLite){
            return '';
        }
        return $this->hasAttribute('engine') ? 'ENGINE=' . $this->getAttribute('engine') : '';
    }

    /**
     * Get the character set specification for the table.
     *
     * @return string The SQL specification for the table character set.
     */
    public function charset(): string
    {
        if($this->syntax->getDriver() === Driver::SQLite){
            return '';
        }
        return $this->hasAttribute('charset') ? 'DEFAULT CHARSET=' . $this->getAttribute('charset') : '';
    }

    /**
     * Build the final SQL query based on the operation and attributes.
     *
     * @return string The generated SQL query.
     */
    public function buildCreateTable(): string
    {
        return sprintf(
            "%s %s ( %s ) %s %s",
            $this->start(),
            $this->tableName(),
            $this->columns(),
            $this->engine(),
            $this->charset(),
        );
    }

    /**
     * Build the final SQL query based on the operation and attributes.
     *
     * @return string The generated SQL query.
     */
    public function buildModifyTable(): string
    {
        return sprintf(
            '%s',
            $this->update(),
        );
    }

    /**
     * Build the final SQL query based on the operation and attributes.
     *
     * @return string The generated SQL query.
     */
    public function build(): string
    {
        if ($this->getOperation() === 'create_table') {
            return $this->buildCreateTable();
        }
        if ($this->getOperation() === 'update_table') {
            return $this->buildModifyTable();
        }
        
        throw new \Exception("Error Processing query attribute operation");
    }

    /**
     * Convert the object to its string representation (generates the SQL query).
     *
     * @return string The generated SQL query.
     */
    public function __toString()
    {
        return $this->build();
    }
}
