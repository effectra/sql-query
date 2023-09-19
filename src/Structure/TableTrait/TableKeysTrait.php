<?php

declare(strict_types=1);

namespace Effectra\SqlQuery\Structure\TableTrait;

use Effectra\SqlQuery\Destruct\ColumnDestruct;

/**
 * Trait TableKeysTrait
 *
 * This trait provides methods for defining keys and constraints on database table columns.
 *
 */
trait TableKeysTrait
{

    /**
     * Set the column as the primary key.
     *
     * @return self
     */
    public function primaryKey(): self
    {
        $col = new ColumnDestruct($this->getLastColumn());
        $col->primaryKey();
        $this->modifyColumn($col);
        return $this;
    }

    /**
     * Set the column as the primary key.
     *
     * @return self
     */
    public function primary(): self
    {
        return $this->primaryKey();
    }

    /**
     * Create a foreign key constraint on the column.
     *
     * @param string $column The name of the column.
     * @param string $table_references The name of the referenced table.
     * @param string $col_references The name of the referenced column.
     * @return self
     */
    public function foreignKey(string $column, string $table_references, string $col_references): self
    {
        $col = new ColumnDestruct($this->getLastColumn());
        $col->foreignKey($column, $table_references, $col_references);
        $this->modifyColumn($col);
        return $this;
    }

    /**
     * Create a foreign key constraint on the column.
     *
     * @param string $column The name of the column.
     * @param string $table_references The name of the referenced table.
     * @param string $col_references The name of the referenced column.
     * @return self
     */
    public function foreign(string $column, string $table_references, string $col_references): self
    {
        return $this->foreignKey($column, $table_references, $col_references);
    }

    /**
     * Create a unique constraint on the column.
     *
     * @return self
     */
    public function unique(): self
    {
        $col = new ColumnDestruct($this->getLastColumn());
        $col->unique();
        $this->modifyColumn($col);
        return $this;
    }

    /**
     * Specify that the column is unsigned.
     *
     * @return self
     */
    public function unsigned(): self
    {
        $col = new ColumnDestruct($this->getLastColumn());
        $col->unsigned();
        $this->modifyColumn($col);
        return $this;
    }

    
}
