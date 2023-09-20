<?php

declare(strict_types=1);

namespace Effectra\SqlQuery\Build;

use Effectra\SqlQuery\Attribute;
use Effectra\SqlQuery\Charset;
use Effectra\SqlQuery\Driver;
use Effectra\SqlQuery\Syntax;
use Effectra\SqlQuery\Types\DataTypes;
use Effectra\SqlQuery\Validation\DataTypeSizeValidation;

/**
 * Class ColumnQueryBuilder
 *
 * Represents a query builder for generating SQL column-related statements.
 *
 * @package Effectra\SqlQuery\Build
 */
class ColumnQueryBuilder extends Attribute
{

    /**
     * ColumnQueryBuilder constructor.
     *
     * @param array $attributes An array of attributes for the column query.
     * @param Syntax $syntax The syntax handler for constructing SQL queries.
     */
    public function __construct(protected array $attributes, protected Syntax $syntax)
    {
    }

    /**
     * Get the name of the column.
     *
     * @return string The name of the column.
     */
    public function columnName(): string
    {
        return $this->getAttribute('column_name');
    }

    /**
     * Get the "SET" keyword if adding a set clause to the column.
     *
     * @return string The "SET" keyword if present, or an empty string.
     */
    public function set(): string
    {
        if ($this->hasAttribute('add_set')) {
            return $this->syntax->getCommand('set', 1);
        }
        return '';
    }

    /**
     * Get the data type of the column.
     *
     * @return string The data type of the column.
     * @throws \Exception If the specified data type is not recognized.
     */
    public function dataType(): string
    {
        $specify_data_type = $method = '';

        if ($this->hasAttribute('data_type')) {

            if ($this->hasAttribute('specify_data_type')) {
                $specify_data_type = $this->syntax->getCommand('data_type', 1);
            }

            $type = $this->getAttribute('data_type');
            $values = $this->getAttribute('datatype_values');

            if(!method_exists(DataTypes::class,$type)){
                throw new \Exception("data type not exists", 1);
            }

            $method = (new DataTypes())->$type($values);
        }

        return $specify_data_type . $method;
    }

    /**
     * Get the size (length) of the column, if specified.
     *
     * @return string The size of the column in parentheses, or an empty string if not specified.
     */
    public function size(): string
    {
        $size = $this->getAttribute('size');
        if (!$size) {
            return '';
        }
        if ($size) {
            (new DataTypeSizeValidation($size, $this->dataType()))->validate();
        }
        return "($size)";
    }

    /**
     * Get the constraints applied to the column.
     *
     * @return string The constraints applied to the column, including auto-increment, unsigned, unique, etc.
     */
    public function constraints(): string
    {
        $result = [];
        if (!$this->hasAttribute('constraints')) {
            return '';
        }

        if ($this->constraintsHas('auto_increment')) {
            $result[] = $this->autoIncrement();
        }

        if ($this->constraintsHas('unsigned')) {
            $result[] = $this->unsigned();
        }

        if ($this->constraintsHas('unique')) {
            $result[] = $this->unique();
        }

        if ($this->hasAttribute('collation_name')) {
            $result[] = $this->collationName();
        }

        if ($this->constraintsHas('default')) {
            $result[] = $this->defaultValue();
        }

        if ($this->constraintsHas('visible')) {
            $result[] = $this->visible();
        }

        if ($this->hasAttribute('check')) {
            $result[] = $this->check();
        }

        return join(' ', $result);
    }

     /**
     * Check if the column is nullable or not.
     *
     * @return string The "NOT NULL" constraint if the column is not nullable, or the "NULL" constraint if nullable.
     */
    public function nullable()
    {
        if ($this->constraintsHas('not_null')) {
            return  $this->syntax->getCommand('not') . $this->syntax->getCommand('null', 2);
        }
        if ($this->constraintsHas('null')) {
            return $this->syntax->getCommand('null', 2);
        }
        return '';
    }

    /**
     * Get the "AUTO_INCREMENT" constraint for the column.
     *
     * @return string The "AUTO_INCREMENT" constraint.
     */
    public function autoIncrement()
    {
        return $this->syntax->getKey('auto_increment', 2);
    }

     /**
     * Get the "UNSIGNED" constraint for the column.
     *
     * @return string The "UNSIGNED" constraint.
     */
    public function unsigned()
    {
        return $this->syntax->getCommand('unsigned', 2);
    }

     /**
     * Get the collation name for the column, if specified.
     *
     * @return string The collation name for the column, including character set and collate statement.
     */
    public function collationName()
    {
        $collation_name = $this->getAttribute('collation_name')['charset'] ?? null;
        if (!$collation_name) {
            return '';
        }
        if (Charset::getDriver($collation_name) === 'MySQL') {
            return $this->syntax->getCommand('character', 1) .
                $this->syntax->getCommand('set', 1) . Charset::getCharacter($collation_name) .
                $this->syntax->getCommand('collate', 1) . $collation_name;
        }
        if (Charset::getDriver($collation_name) === 'PostgreSQL') {
            return $this->syntax->getCommand('character', 1) .
                $this->syntax->getCommand('set', 1) . Charset::getCharacter($collation_name);
        }
        return '';
    }

     /**
     * Get the "UNIQUE" constraint for the column.
     *
     * @return string The "UNIQUE" constraint.
     */
    public function unique()
    {
        return $this->syntax->getKey('unique', 2);
    }

     /**
     * Get the default value constraint for the column.
     *
     * @return string The default value constraint.
     */
    public function defaultValue(): string
    {
        $dv = $this->getValueByKey($this->getAttribute('constraints'), 'default');
        $default_value = (new ValueBuilder([$dv]))->getAsOneLine();
        return $this->syntax->getCommand('default', 1) . $default_value;
    }

     /**
     * Get the visibility constraint for the column.
     *
     * @return string The visibility constraint, either "VISIBLE" or "INVISIBLE".
     */
    public function visible(): string
    {
        $value = $this->getValueByKey($this->getAttribute('constraints'), 'visible');
        return $value === false ? $this->syntax->getCommand('invisible', 1) : '';
    }

    /**
     * Get the check constraint for the column (e.g., JSON validation).
     *
     * @return string The check constraint.
     */
    public function check(): string
    {
        if($this->syntax->getDriver() === Driver::SQLite){
            return '';
        }
        $exprs = $this->getAttribute('check') ;
        if(! $exprs){
            return '';
        }

        $result = '';
        $exprs_result = [];

        if(is_array($exprs)){
            foreach ($exprs as $expr) {
                if(empty($expr)){
                    throw new \Exception("Error Processing Query, check expression is empty");
                }
                if($expr === 'json'){
                    $expr = "json_valid({$this->columnName()})";
                }
                $exprs_result[] = $expr;
            }
        }

        $check_sort =  $this->getAttribute('check_sort');
        array_shift($check_sort);
        $sortedSyntax = array_map(fn ($op) => $this->syntax->getCommand($op, 1),$check_sort);
    
        foreach ($exprs_result as $key => $condition) {
            if ($key > 0 && $condition !== null) {
                $result .=  $sortedSyntax[$key - 1] ?? $this->syntax->getCommand('and', 1);
            }
            $result .= $condition;
        }

        return $this->syntax->getCommand('check', 1) . sprintf('(%s)',
        $result
        );
    }

    /**
     * Check if the column's constraints array has a specific attribute.
     *
     * @param string $attribute The attribute to check for in the constraints array.
     * @return bool True if the attribute exists, otherwise false.
     */
    public function constraintsHas($attribute): bool
    {
        $constraints = $this->getAttribute('constraints');
        if (!is_array($constraints)) {
            return false;
        }
        foreach ($constraints as $constraint) {
            if (is_array($constraint)) {
                // Check if the attribute exists in the nested array
                if (array_key_exists($attribute, $constraint)) {
                    return true;
                }
            } elseif ($constraint === $attribute) {
                // Check if the attribute matches a non-array value in the constraints array
                return true;
            }
        }

        return false;
    }

    /**
     * Get the value associated with a key in the constraints array.
     *
     * @param array $attribute The constraints array to search in.
     * @param string $key The key to search for.
     * @return mixed|null The value associated with the key, or null if not found.
     */
    public function getValueByKey($attribute, $key): mixed
    {
        foreach ($attribute as $item) {
            if (is_array($item) && array_key_exists($key, $item)) {
                return $item[$key] ?? null;
            }
        }
        return null;
    }

    /**
     * Build the SQL column-related query.
     *
     * @return string The generated SQL query.
     */
    public function build(): string
    {
        return sprintf(
            '%s %s%s %s %s %s',
            $this->columnName(),
            $this->set(),
            $this->dataType(),
            $this->size(),
            $this->nullable(),
            $this->constraints()
        );
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