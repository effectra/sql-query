<?php

declare(strict_types=1);

namespace Effectra\SqlQuery\Structure\TableTrait;

use Effectra\SqlQuery\Structure\Column;

/**
 * Trait TableDateTimeTrait
 *
 * This trait provides methods to define date and time columns in a database table.
 *
 */
trait TableDateTimeTrait
{

    /**
     * Define a timestamp column.
     *
     * @param string $column_name The name of the column.
     * @return self
     */
    public function timestamp(string $column_name): self
    {
        $col = new Column($column_name);
        $col->timestamp();
        $this->addToAttribute('cols', $col->getAttributes());
        return $this;
    }

     /**
     * Define a date column.
     *
     * @param string $column_name The name of the column.
     * @return self
     */
    public function date(string $column_name): self
    {
        $col = new Column($column_name);
        $col->date();
        $this->addToAttribute('cols', $col->getAttributes());
        return $this;
    }

    /**
     * Define a year column.
     *
     * @param string $column_name The name of the column.
     * @return self
     */
    public function year(string $column_name): self
    {
        $col = new Column($column_name);
        $col->year();
        $this->addToAttribute('cols', $col->getAttributes());
        return $this;
    }

     /**
     * Define a time column.
     *
     * @param string $column_name The name of the column.
     * @return self
     */
    public function time(string $column_name): self
    {
        $col = new Column($column_name);
        $col->time();
        $this->addToAttribute('cols', $col->getAttributes());
        return $this;
    }

    /**
     * Define a datetime column.
     *
     * @param string $column_name The name of the column.
     * @return self
     */
    public function datetime(string $column_name): self
    {
        $col = new Column($column_name);
        $col->datetime();
        $this->addToAttribute('cols', $col->getAttributes());
        return $this;
    }

    /**
     * Define timestamp columns for "created_at" and "updated_at".
     *
     * @param bool $default_current_time Whether to set the default value to the current timestamp.
     */
    public function timestamps($default_current_time = true): void
    {
        $this->createdAt($default_current_time);
        $this->updatedAt($default_current_time);
    }

    /**
     * Define a "created_at" timestamp column.
     *
     * @param bool $default_current_time Whether to set the default value to the current timestamp.
     */
    public function createdAt($default_current_time = true): void
    {
        $created_at = new Column('created_at');
        $created_at->timestamp()->null();
        if ($default_current_time) {
            $created_at->default($this->syntax->dateFunctions()['current_timestamp_upper']);
        }
        $this->addToAttribute('cols', $created_at->getAttributes());
    }

     /**
     * Define an "updated_at" timestamp column.
     *
     * @param bool $default_current_time Whether to set the default value to the current timestamp.
     */
    public function updatedAt($default_current_time = true)
    {
        $updated_at = new Column('updated_at');
        $updated_at->timestamp()->null();

        if ($default_current_time) {
            $updated_at->default($this->syntax->dateFunctions()['current_timestamp_upper']);
        }

        $this->addToAttribute('cols', $updated_at->getAttributes());
    }
}
