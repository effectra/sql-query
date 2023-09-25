<?php

declare(strict_types=1);

namespace Effectra\SqlQuery\Structure\TableTrait;

use Effectra\SqlQuery\Structure\Column;

/**
 * Trait TableStringTrait
 *
 * This trait provides methods for defining string and text columns in a database table.
 *
 */
trait TableStringTrait
{

    /**
     * Define a string column.
     *
     * This method is an alias for longText().
     *
     * @param string $column_name The name of the column.
     * @return self
     */
    public function string(string $column_name): self
    {
        return $this->longText($column_name);
    }

    /**
     * Define a VARCHAR column.
     *
     * @param string $column_name The name of the column.
     * @return self
     */
    public function varchar(string $column_name): self
    {
        $col = new Column($column_name);
        $col->varchar();
        $this->addToAttribute('cols', $col->getAttributes());
        return $this;
    }

    /**
     * Define a CHAR column.
     *
     * @param string $column_name The name of the column.
     * @return self
     */
    public function char(string $column_name): self
    {
        $col = new Column($column_name);
        $col->char();
        $this->addToAttribute('cols', $col->getAttributes());
        return $this;
    }

    /**
     * Define a TEXT column.
     *
     * @param string $column_name The name of the column.
     * @return self
     */
    public function text(string $column_name): self
    {
        $col = new Column($column_name);
        $col->text();
        $this->addToAttribute('cols', $col->getAttributes());
        return $this;
    }

    /**
     * Define a TINYTEXT column.
     *
     * @param string $column_name The name of the column.
     * @return self
     */
    public function tinyText(string $column_name): self
    {
        $col = new Column($column_name);
        $col->tinyText();
        $this->addToAttribute('cols', $col->getAttributes());
        return $this;
    }


    /**
     * Define a MEDIUMTEXT column.
     *
     * @param string $column_name The name of the column.
     * @return self
     */
    public function mediumText(string $column_name): self
    {
        $col = new Column($column_name);
        $col->mediumText();
        $this->addToAttribute('cols', $col->getAttributes());
        return $this;
    }

    /**
     * Define a LONGTEXT column.
     *
     * @param string $column_name The name of the column.
     * @return self
     */
    public function longText(string $column_name): self
    {
        $col = new Column($column_name);
        $col->longText();
        $this->addToAttribute('cols', $col->getAttributes());
        return $this;
    }

    /**
     * Define a BLOB column.
     *
     * @param string $column_name The name of the column.
     * @return self
     */
    public function blob(string $column_name): self
    {
        $col = new Column($column_name);
        $col->blob();
        $this->addToAttribute('cols', $col->getAttributes());
        return $this;
    }

    /**
     * Define a TINYBLOB column.
     *
     * @param string $column_name The name of the column.
     * @return self
     */
    public function tinyBlob(string $column_name): self
    {
        $col = new Column($column_name);
        $col->tinyBlob();
        $this->addToAttribute('cols', $col->getAttributes());
        return $this;
    }

    /**
     * Define a MEDIUMBLOB column.
     *
     * @param string $column_name The name of the column.
     * @return self
     */
    public function mediumBlob(string $column_name): self
    {
        $col = new Column($column_name);
        $col->mediumBlob();
        $this->addToAttribute('cols', $col->getAttributes());
        return $this;
    }

    /**
     * Define a LONGBLOB column.
     *
     * @param string $column_name The name of the column.
     * @return self
     */
    public function longBlob(string $column_name): self
    {
        $col = new Column($column_name);
        $col->longBlob();
        $this->addToAttribute('cols', $col->getAttributes());
        return $this;
    }

    /**
     * Define a BINARY column.
     *
     * @param string $column_name The name of the column.
     * @return self
     */
    public function binary(string $column_name): self
    {
        $col = new Column($column_name);
        $col->binary();
        $this->addToAttribute('cols', $col->getAttributes());
        return $this;
    }

    /**
     * Define a VARBINARY column.
     *
     * @param string $column_name The name of the column.
     * @return self
     */
    public function varBinary(string $column_name): self
    {
        $col = new Column($column_name);
        $col->varBinary();
        $this->addToAttribute('cols', $col->getAttributes());
        return $this;
    }

    /**
     * Define a JSON column.
     *
     * @param string $column_name The name of the column.
     * @return self
     */
    public function json(string $column_name): self
    {
        $col = new Column($column_name);
        $col->json();
        $this->addToAttribute('cols', $col->getAttributes());
        return $this;
    }

    /**
     * Define a UUID column.
     *
     * @param string $column_name The name of the column.
     * @return self
     */
    public function uuid(string $column_name): self
    {
        $col = new Column($column_name);
        $col->uuid();
        $this->addToAttribute('cols', $col->getAttributes());
        return $this;
    }

    /**
     * Define an ENUM column.
     *
     * @param string $column_name The name of the column.
     * @param array $values The allowed values for the ENUM.
     * @return self
     */
    public function enum(string $column_name, array $values): self
    {
        $col = new Column($column_name);
        $col->enum($values);
        $this->addToAttribute('cols', $col->getAttributes());
        return $this;
    }

    /**
     * Define a SET column.
     *
     * @param string $column_name The name of the column.
     * @param array $values The allowed values for the SET.
     * @return self
     */
    public function set(string $column_name, array $values): self
    {
        $col = new Column($column_name);
        $col->set($values);
        $this->addToAttribute('cols', $col->getAttributes());
        return $this;
    }

    /**
     * Define an ENUM column for status with predefined values.
     *
     * @param string $column_name The name of the column.
     */
    public function enumStatus($column_name = 'status', $default = 'pending')
    {
        $col = new Column($column_name);
        $col->enum(['pending', 'approved', 'declined', 'removed'])->default($default);
        $this->addToAttribute('cols', $col->getAttributes());
        return $this;
    }
}
