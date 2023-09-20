<?php

declare(strict_types=1);

namespace Effectra\SqlQuery\Operations;

use Effectra\SqlQuery\Attribute;
use Effectra\SqlQuery\Build\BuildAction;
use Effectra\SqlQuery\Build\RunBuilder;
use Effectra\SqlQuery\Validation\ArraysValidation;

/**
 * Class Update
 *
 * This class represents an SQL UPDATE operation for modifying existing records in a table.
 *
 */
class Update extends Attribute
{
    /**
     * Use traits for arrays validation, operations, and data setting.
     */
    use ArraysValidation, OperationsTrait, SetDataTrait;

    /**
     * Constructor for the Update class.
     *
     * @param string $table The name of the table to update records in.
     */
    public function __construct(string $table)
    {
        $this->setAttribute('table_name', $table);
        $this->setAttribute('operation', 'update');
        $this->setAttribute('insert_data_mode', Insert::INSERT_VALUES_MODE_NORMAL);
    }

    /**
     * Get the SQL query generated by the Update operation.
     *
     * @return string The SQL query.
     */

    public function getQuery(): string
    {
        return (string) new RunBuilder($this->getAttributes(), BuildAction::UPDATE);
    }

    /**
     * Convert the Update operation to a string, returning the generated SQL query.
     *
     * @return string The generated SQL query.
     */
    public function __toString(): string
    {
        return $this->getQuery();
    }
}
