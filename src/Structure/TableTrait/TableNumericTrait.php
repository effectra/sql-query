<?php

declare(strict_types=1);

namespace Effectra\SqlQuery\Structure\TableTrait;

use Effectra\SqlQuery\Structure\Column;

/**
 * Trait TableNumericTrait
 *
 * This trait provides methods for defining numeric columns in a database table.
 *
 */
trait TableNumericTrait {

     /**
     * Define an auto-incrementing big integer column.
     *
     * @param string $column_name The name of the column.
     * @return self
     */
    public function autoIncrement($column_name = 'id'): self
    {
        $col = new Column($column_name);
        $col->bigInt()->autoIncrement();
        $this->addToAttribute('cols', $col->getAttributes());
        return $this;
    }

     /**
     * Define a primary key big integer column with a size of 20.
     *
     * @return self
     */
    public function id(): self
    {
        $col = new Column('id');
        $col->bigInt()->size(20)->primaryKey();
        $this->addToAttribute('cols', $col->getAttributes());
        return $this;
    }

     /**
     * Define a boolean column.
     *
     * @param string $column_name The name of the column.
     * @return self
     */
    public function boolean(string $column_name): self
    {
        $col = new Column($column_name);
        $col->boolean();
        $this->addToAttribute('cols', $col->getAttributes());
        return $this;
    }

    /**
     * Define an integer column.
     *
     * @param string $column_name The name of the column.
     * @return self
     */
    public function int(string $column_name): self
    {
        $col = new Column($column_name);
        $col->int();
        $this->addToAttribute('cols', $col->getAttributes());
        return $this;
    }

    /**
     * Define a big integer column.
     *
     * @param string $column_name The name of the column.
     * @return self
     */
    public function bigInt(string $column_name): self
    {
        $col = new Column($column_name);
        $col->bigInt();
        $this->addToAttribute('cols', $col->getAttributes());
        return $this;
    }

    /**
     * Define a decimal column.
     *
     * @param string $column_name The name of the column.
     * @return self
     */
    public function decimal(string $column_name): self
    {
        $col = new Column($column_name);
        $col->decimal();
        $this->addToAttribute('cols', $col->getAttributes());
        return $this;
    }

    /**
     * Define a bit column.
     *
     * @param string $column_name The name of the column.
     * @return self
     */
    public function bit(string $column_name): self
    {
        $col = new Column($column_name);
        $col->bit();
        $this->addToAttribute('cols', $col->getAttributes());
        return $this;
    }

    /**
     * Define a tiny integer column.
     *
     * @param string $column_name The name of the column.
     * @return self
     */
    public function tinyInt(string $column_name): self
    {
        $col = new Column($column_name);
        $col->tinyInt();
        $this->addToAttribute('cols', $col->getAttributes());
        return $this;
    }

    /**
     * Define a small integer column.
     *
     * @param string $column_name The name of the column.
     * @return self
     */
    public function smallInt(string $column_name): self
    {
        $col = new Column($column_name);
        $col->smallInt();
        $this->addToAttribute('cols', $col->getAttributes());
        return $this;
    }

    /**
     * Define a boolean column (alternative method).
     *
     * @param string $column_name The name of the column.
     * @return self
     */
    public function bool(string $column_name): self
    {
        $col = new Column($column_name);
        $col->bool();
        $this->addToAttribute('cols', $col->getAttributes());
        return $this;
    }

    /**
     * Define a medium integer column.
     *
     * @param string $column_name The name of the column.
     * @return self
     */
    public function mediumInt(string $column_name): self
    {
        $col = new Column($column_name);
        $col->mediumInt();
        $this->addToAttribute('cols', $col->getAttributes());
        return $this;
    }

    /**
     * Define an integer column (alternative method).
     *
     * @param string $column_name The name of the column.
     * @return self
     */
    public function integer(string $column_name): self
    {
        $col = new Column($column_name);
        $col->integer();
        $this->addToAttribute('cols', $col->getAttributes());
        return $this;
    }

    /**
     * Define a double column.
     *
     * @param string $column_name The name of the column.
     * @return self
     */
    public function double(string $column_name): self
    {
        $col = new Column($column_name);
        $col->double();
        $this->addToAttribute('cols', $col->getAttributes());
        return $this;
    }

     /**
     * Define a double precision column.
     *
     * @param string $column_name The name of the column.
     * @return self
     */
    public function doublePrecision(string $column_name): self
    {
        $col = new Column($column_name);
        $col->doublePrecision();
        $this->addToAttribute('cols', $col->getAttributes());
        return $this;
    }

     /**
     * Define a float column.
     *
     * @param string $column_name The name of the column.
     * @return self
     */
    public function float(string $column_name): self
    {
        $col = new Column($column_name);
        $col->float();
        $this->addToAttribute('cols', $col->getAttributes());
        return $this;
    }
}