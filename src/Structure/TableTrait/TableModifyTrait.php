<?php

declare(strict_types=1);

namespace Effectra\SqlQuery\Structure\TableTrait;

use Effectra\SqlQuery\Structure\Column;

/**
 * Trait TableModifyTrait
 *
 * This trait provides methods for modifying database table structure, such as renaming tables, renaming columns,
 * and adding columns.
 *
 */
trait TableModifyTrait
{

     /**
     * Rename the table.
     *
     * @param string $new_name The new name for the table.
     * @return self
     */
    public function renameTable(string $new_name): self
    {
        $this->setAttribute('rename_table', $new_name);
        $this->setAttribute('table_name',$new_name);
        return $this;
    }
    
    /**
     * Rename a column in the table.
     *
     * @param string $column_name The current name of the column to be renamed.
     * @param string $new_name The new name for the column.
     * @return self
     */
    public function renameColumn(string $column_name, string $new_name): self
    {
        $this->setAttribute('rename_column', ['old' => $column_name, 'new' => $new_name]);
        return $this;
    }

    /**
     * Add a new column to the table.
     *
     * @param string $column_name The name of the new column.
     * @param callable $definition A callback function to define the properties of the new column.
     * @return self
     */
    public function addColumn(string $column_name,callable $definition)
    {
        $col = new Column($column_name);
        call_user_func($definition,$col);
        $this->setAttribute('add_column',$col->getAttributes());
        return $this;
    }
}
