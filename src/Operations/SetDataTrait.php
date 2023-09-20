<?php

declare(strict_types=1);

namespace Effectra\SqlQuery\Operations;


/**
 * Trait SetDataTrait
 *
 * This trait provides methods for managing data to be inserted or updated in SQL queries.
 *
 */
trait SetDataTrait
{

    /**
     * Get the columns being inserted.
     *
     * @return array The column names.
     */
    public function getColumns(): array
    {
        return $this->getAttribute('columns');
    }

    /**
     * Get the values being inserted.
     *
     * @return array The values.
     */
    public function getValues(): array
    {
        return $this->getAttribute('values');
    }

    /**
     * Set the columns for the insert statement.
     *
     * @param array $columns The column names.
     * @return self
     */
    public function setColumns(array $columns): self
    {
        $this->setAttribute('columns', $columns);
        return $this;
    }

    /**
     * Set the values for the insert statement.
     *
     * @param array $values The values.
     * @return self
     */
    public function setValues(array $values): self
    {
        $this->setAttribute('values', $values);
        return $this;
    }

    /**
     * Set the value for the insert statement.
     *
     * @param  $value The value.
     * @return self
     */
    public function setValue($value): self
    {
        if ($this->getAttribute('insert_type') !== Insert::INSERT_VALUES) {
            throw new \Exception("You can not use this method,when set insert_type to INSERT_DATA");
        }
        $this->addToAttribute('values', $value);
        return $this;
    }

    /**
     * Set the data to be used for generating SQL query values.
     *
     * @param array $data An array containing data to be inserted or updated.
     *                    For an associative array, keys represent column names and values represent values.
     *                    For a non-associative array, each item should be an associative array with the same keys.
     * @return self Returns a new instance with the provided data set.
     * @throws \Exception If the array items do not have the same keys (for non-associative arrays).
     */
    public function data(array $data): self
    {
        if ($this->isAssociativeData($data)) {
            $columns = array_keys($data);
            $values = array_values($data);
        } else {
            if (!$this->hasSameKeys($data)) {
                throw new \Exception("Array items do not have the same keys.");
            }
            foreach ($data as $item) {
                $columns = array_keys($item);
                $values[] = array_values($item);
            }
        }
        $this->attributes['columns'] = $columns;
        $this->attributes['values'] = $values;
        return $this;
    }

    /**
     * Set the values to default for insertion.
     *
     * @return self
     */
    public function defaultValues(): self
    {
        $this->setAttribute('values', 'default');
        return $this;
    }

    /**
     * Set the insert values mode to safe mode.
     */
    public function insertValuesModeSafe()
    {
        $this->setAttribute('insert_data_mode', Insert::INSERT_VALUES_MODE_SAFE);
    }

     /**
     * Get the parameters for the SQL query.
     *
     * @return array An associative array of parameter names and values.
     */
    public function getParams(): array
    {
        return array_combine(
            array_map(fn ($item) => ":$item", $this->getAttribute('columns')),
            $this->getAttribute('values')
        );
    }
}
