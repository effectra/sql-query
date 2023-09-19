<?php

declare(strict_types=1);

namespace Effectra\SqlQuery\Structure\TableTrait;

/**
 * Trait TableDropTrait
 *
 * This trait provides methods for generating SQL queries to drop tables and columns.
 *
 */
trait TableDropTrait
{

    /**
     * Set the table to be dropped.
     *
     * @return self
     */
    public function dropTable(): self
    {
        $this->setAttribute('drop_table', $this->getAttribute('table_name'));
        return $this;
    }

    /**
     * Set the column to be dropped.
     *
     * @param string $column_name The name of the column to drop.
     * @return self
     */
    public function dropColumn(string $column_name): self
    {
        $this->setAttribute('drop_column', $column_name);
        return $this;
    }
/**
     * Set the key to be dropped.
     *
     * @param string $column_name The name of the column related to the key.
     * @return self
     */
    public function dropKey(string $column_name): self
    {
        $this->setAttribute('drop_key', 'key');
        $this->setAttribute('column_key', $column_name);
        return $this;
    }

    /**
     * Set the primary key to be dropped.
     *
     * @param string $column_name The name of the column related to the primary key.
     * @return self
     */
    public function dropPrimaryKey(string $column_name): self
    {
        $this->setAttribute('drop_key', 'primary');
        $this->setAttribute('column_key', $column_name);
        return $this;
    }

    /**
     * Set the foreign key to be dropped.
     *
     * @param string $column_name The name of the column related to the foreign key.
     * @return self
     */
    public function dropForeignKey(string $column_name): self
    {
        $this->setAttribute('drop_key', 'foreign');
        $this->setAttribute('column_key', $column_name);
        return $this;
    }

    /**
     * Set the unique key to be dropped.
     *
     * @param string $column_name The name of the column related to the unique key.
     * @return self
     */
    public function dropUniqueKey(string $column_name): self
    {
        $this->setAttribute('drop_key', 'unique');
        $this->setAttribute('column_key', $column_name);
        return $this;
    }

    /**
     * Set the index to be dropped.
     *
     * @param string $column_name The name of the column related to the index.
     * @return self
     */
    public function dropIndex(string $column_name): self
    {
        $this->setAttribute('drop_key', 'index');
        $this->setAttribute('column_key', $column_name);
        return $this;
    }

}
