<?php

declare(strict_types=1);

namespace Effectra\SqlQuery;

use Effectra\SqlQuery\Attribute;
use Effectra\SqlQuery\Build\BuildAction;
use Effectra\SqlQuery\Build\RunBuilder;
use Effectra\SqlQuery\Destruct\ColumnDestruct;
use Effectra\SqlQuery\Structure\Column;
use Effectra\SqlQuery\Structure\TableTrait\TableCheckTrait;
use Effectra\SqlQuery\Structure\TableTrait\TableDateTimeTrait;
use Effectra\SqlQuery\Structure\TableTrait\TableDropTrait;
use Effectra\SqlQuery\Structure\TableTrait\TableExtraTrait;
use Effectra\SqlQuery\Structure\TableTrait\TableKeysTrait;
use Effectra\SqlQuery\Structure\TableTrait\TableModifyTrait;
use Effectra\SqlQuery\Structure\TableTrait\TableNumericTrait;
use Effectra\SqlQuery\Structure\TableTrait\TableStringTrait;
use Effectra\SqlQuery\Syntax;

/**
 * Class Table
 *
 * Represents a database table and provides methods to modify its structure.
 */
class Table extends Attribute
{
    use TableDropTrait, TableModifyTrait, TableStringTrait, TableNumericTrait, TableKeysTrait,TableDateTimeTrait,TableCheckTrait, TableExtraTrait;

     /**
     * Table constructor.
     *
     * @param Syntax $syntax The SQL syntax manager.
     */
    public function __construct(protected Syntax $syntax)
    {
    }

    /**
     * Set the table name.
     *
     * @param string $name The name of the table.
     */
    public function setTableName(string $name): void
    {
        $this->setAttribute('table_name', $name);
    }

    /**
     * Get the table name.
     *
     * @return string The name of the table.
     */
    public function getTableName(): string
    {
        return $this->getAttribute('table_name');
    }

     /**
     * Get the last column in the table.
     *
     * @return array The attributes of the last column.
     */
    public function getLastColumn(): array
    {
        $cols = $this->getAttribute('cols');
        return end($cols);
    }

    /**
     * Modify the last column
     * @param  $col
     * @return void
     */
    public function modifyColumn(Column $col): void
    {
        $this->addToAttribute('cols', $col->getAttributes());
    }

    /**
     * Modify the last column's size.
     *
     * @param int $value The new size for the column.
     * @return self
     */
    public function size(int $value): self
    {
        $col = new ColumnDestruct($this->getLastColumn());
        $col->size($value);
        $this->modifyColumn($col);
        return $this;
    }

    /**
     * Set a default value for the last column.
     *
     * @param mixed $value The default value.
     * @return self
     */
    public function default($value): self
    {
        $col = new ColumnDestruct($this->getLastColumn());
        $col->default($value);
        $this->modifyColumn($col);
        return $this;
    }

     /**
     * Make the last column nullable.
     *
     * @return self
     */
    public function nullable(): self
    {
        $col = new ColumnDestruct($this->getLastColumn());
        $col->null();
        $this->modifyColumn($col);
        return $this;
    }

    /**
     * Make the last column not nullable.
     *
     * @return self
     */
    public function notNullable(): self
    {
        $col = new ColumnDestruct($this->getLastColumn());
        $col->notNull();
        $this->modifyColumn($col);
        return $this;
    }

    /**
     * Make the last column invisible.
     *
     * @return self
     */
    public function invisible(): self
    {
        $col = new ColumnDestruct($this->getLastColumn());
        $col->invisible();
        $this->modifyColumn($col);
        return $this;
    }

     /**
     * Set the default value for the last column to the current time.
     *
     * @return self
     */
    public function defaultCurrentTime(): self
    {
        $col = new ColumnDestruct($this->getLastColumn());
        $col->defaultCurrentTime();
        $this->modifyColumn($col);
        return $this;
    }

     /**
     * Add a CHECK constraint to the last column.
     *
     * @param mixed $expr The expression for the CHECK constraint.
     * @return self
     */
    public function check($expr): self
    {
        $col = new ColumnDestruct($this->getLastColumn());
        $col->check($expr);
        $this->modifyColumn($col);
        return $this;
    }

    /**
     * Set the character set for the last column.
     *
     * @param mixed $charset The character set.
     * @return self
     */
    public function charset($charset): self
    {
        $col = new ColumnDestruct($this->getLastColumn());
        $col->charset($charset);
        $this->modifyColumn($col);
        return $this;
    }

    /**
     * Set the column after this column.
     *
     * @param mixed $column_name you want your column be after.
     * @return self
     */
    public function after(string $column_name): self
    {
        $col = new ColumnDestruct($this->getLastColumn());
        $col->afterColumn($column_name);
        $this->modifyColumn($col);
        return $this;
    }

    /**
     * Get the SQL query for the table modification.
     *
     * @return string The SQL query.
     */
    public function getQuery(): string
    {
        return (string) new RunBuilder($this->getAttributes(), BuildAction::TABLE);
    }

    /**
     * Convert the table modification to a string (returns the SQL query).
     *
     * @return string The SQL query.
     */
    public function __toString(): string
    {
        return $this->getQuery();
    }
}
