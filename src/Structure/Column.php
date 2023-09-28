<?php

declare(strict_types=1);

namespace Effectra\SqlQuery\Structure;

use Effectra\SqlQuery\Attribute;
use Effectra\SqlQuery\Build\BuildAction;
use Effectra\SqlQuery\Build\RunBuilder;
use Effectra\SqlQuery\Types\DataTypesTrait;

/**
 * Class Column
 * Represents a column in a SQL table.
 */
class Column extends Attribute
{
    use DataTypesTrait;

    /**
     * Column constructor.
     *
     * @param string $column_name The name of the column.
     * @param bool $init_attributes Whether to initialize column attributes.
     */
    public function __construct(string $column_name, bool $init_attributes = true)
    {
        $this->setAttribute('column_name', $column_name);
        if ($init_attributes) {
            $this->initAttributes();
        }
    }

    /**
     * Initialize column attributes with default values.
     */
    public function initAttributes()
    {
        $this->constraints(['visible' => true]);
        $this->constraints('not_null');
        $this->setAttribute('data_type', 'varchar');
    }

    /**
     * Mark the column for an "ADD SET" operation.
     *
     * @return $this
     */
    public function addSet()
    {
        $this->setAttribute('add_set', true);
        return $this;
    }

    /**
     * Mark the column for specifying a data type.
     *
     * @return $this
     */
    public function specifyDataType()
    {
        $this->setAttribute('specify_data_type', true);
        return $this;
    }

    /**
     * Set the data type for the column.
     *
     * @param string $type The data type.
     * @return self
     */
    public function dataType(string $type): self
    {
        $this->setAttribute('data_type', $type);
        return $this;
    }

    /**
     * Set the size for the column.
     *
     * @param int $value The size value.
     * @return self
     */
    public function size(int $value): self
    {
        $this->setAttribute('size', $value);
        return $this;
    }

    /**
     * Set a comment for the column.
     *
     * @param string $value The comment.
     * @return self
     */
    public function comment(string $value): self
    {
        $this->setAttribute('comment', $value);
        return $this;
    }

    /**
     * Add constraints to the column.
     *
     * @param mixed $constraints The constraints to add.
     * @return self
     */
    public function constraints($constraints): self
    {
        $this->addToAttribute('constraints', $constraints);
        return $this;
    }

    /**
     * Mark the column as unique.
     *
     * @return self
     */
    public function unique(): self
    {
        return $this->constraints('unique_key');
    }

    /**
     * Mark the column as unsigned.
     *
     * @return self
     */
    public function unsigned(): self
    {
        return $this->constraints('unsigned');
    }

    /**
     * Mark the column as a primary key.
     *
     * @return self
     */
    public function primaryKey(): self
    {
        return $this->constraints('primary_key');
    }

    /**
     * Mark the column as auto-increment.
     *
     * @return self
     */
    public function autoIncrement(): self
    {
        return $this->constraints('auto_increment');
    }

    /**
     * Mark the column as not nullable.
     *
     * @return self
     */
    public function notNull(): self
    {
        $this->clearFromAttribute('constraints', 'null');
        return $this->constraints('not_null');
    }

    /**
     * Mark the column as nullable.
     *
     * @return self
     */
    public function null(): self
    {
        $this->clearFromAttribute('constraints', 'not_null');
        return $this->constraints('null');
    }

    /**
     * Set a default value for the column.
     *
     * @param mixed $value The default value.
     * @return self
     */
    public function default($value): self
    {
        return $this->constraints(['default' => $value]);
    }

    /**
     * Mark the column as invisible.
     *
     * @return self
     */
    public function invisible(): self
    {
        return $this->constraints(['visible' => false]);
    }

    /**
     * Set the default value for the column to the current time.
     *
     * @return self
     */
    public function defaultCurrentTime(): self
    {
        return $this->constraints(['default' => 'current_time']);
    }

    /**
     * Add a CHECK constraint to the column.
     *
     * @param mixed $expr The expression for the CHECK constraint.
     * @return self
     */
    public function check($expr, string $sort = 'and'): self
    {
        $this->addToAttribute('check', $expr);
        $this->addToAttribute('check_sort', $sort);
        return $this;
    }

    /**
     * Add a CHECK constraint with next CHECK constraint 'OR' to the column.
     *
     * @param mixed $expr The expression for the CHECK constraint.
     * @return self
     */
    public function checkOr($expr): self
    {
        return $this->check($expr, 'or');
    }

    /**
     * Add a CHECK LIKE constraint to the column.
     *
     * @param mixed $expr The expression for the CHECK constraint.
     * @return self
     */
    public function checkLike(string $format): self
    {
        return $this->check("{$this->getAttribute('column_name')} LIKE $format");
    }

    /**
     * Add a CHECK REGEXP constraint to the column.
     *
     * @param mixed $reg_ex The expression for the CHECK constraint.
     * @return self
     */
    public function checkRegEx(string $reg_ex): self
    {
        return $this->check("{$this->getAttribute('column_name')} REGEXP $reg_ex");
    }

    /**
     * Add a CHECK LENGTH constraint to the column.
     *
     * @param mixed $length The length for the CHECK constraint.
     * @return self
     */
    public function checkLength(int $length): self
    {
        return $this->check("{$this->getAttribute('column_name')} LENGTH $length");
    }

    /**
     * Add a CHECK BETWEEN two integer values constraint to the column.
     *
     * @param int $from
     * @param int $to
     * @return self
     */
    public function checkBetween(int $from, int $to): self
    {
        return $this->check("{$this->getAttribute('column_name')} BETWEEN '$from' AND '$to'");
    }

    /**
     * Set the character set for the column.
     *
     * @param mixed $charset The character set.
     * @return self
     */
    public function charset($charset): self
    {
        $this->setAttribute('collation_name', ['charset' => $charset]);
        return $this;
    }

    /**
     * Set the column format.
     *
     * @param mixed $format The column format.
     * @return self
     */
    public function columnFormat($format): self
    {
        $this->setAttribute('column_format', $format);
        return $this;
    }

    /**
     * Set the column format to "fixed".
     *
     * @return self
     */
    public function columnFormatFixed(): self
    {
        return $this->columnFormat('fixed');
    }

    /**
     * Set the column format to "dynamic".
     *
     * @return self
     */
    public function columnFormatDynamic(): self
    {
        return $this->columnFormat('dynamic');
    }

    /**
     * Set the column format to "default".
     *
     * @return self
     */
    public function columnFormatDefault(): self
    {
        return $this->columnFormat('default');
    }

    /**
     * Add a foreign key constraint to the column.
     *
     * @param string $column The column name for the foreign key.
     * @param string $table_references The referenced table name.
     * @param string $col_references The referenced column name.
     * @return self
     */
    public function foreignKey(string $column, string $table_references, string $col_references): self
    {
        return $this->constraints([
            'foreign_key' => [
                'col' => $column,
                'references' => [
                    'table' => $table_references,
                    'col' => $col_references
                ]
            ]
        ]);
    }

    /**
     * Set the storage type for the column.
     *
     * @param string $type The storage type.
     * @return self
     */
    public function storage(string $type): self
    {
        $this->setAttribute('storage', $type);
        return $this;
    }

    /**
     * Set the storage type to "disk".
     *
     * @return self
     */
    public function storageDisk(): self
    {
        return $this->storage('disk');
    }

    /**
     * Set the storage type to "memory".
     *
     * @return self
     */
    public function storageMemory(): self
    {
        return $this->storage('memory');
    }

    public function afterColumn(string $column): self
    {
        $this->setAttribute('after_column', $column);
        return $this;
    }

    /**
     * Get the SQL query for the column modification.
     *
     * @return string The SQL query.
     */
    public function getQuery(): string
    {
        return (string) new RunBuilder($this->getAttributes(), BuildAction::COLUMN);
    }

    /**
     * Convert the column modification to a string (returns the SQL query).
     *
     * @return string The SQL query.
     */
    public function __toString(): string
    {
        return $this->getQuery();
    }
}
