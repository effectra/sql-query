<?php

declare(strict_types=1);

namespace Effectra\SqlQuery\Structure;

use Effectra\SqlQuery\Attribute;
use Effectra\SqlQuery\Build\BuildAction;
use Effectra\SqlQuery\Build\RunBuilder;
use Effectra\SqlQuery\Types\DataTypesTrait;

/**
 * Class Table
 * Represents a Table in a SQL database.
 */
class Table extends Attribute
{
    use DataTypesTrait;

    /**
     * Table constructor.
     *
     * @param string $name The name of the table.
     */
    public function __construct(string $name)
    {
        $this->setAttribute('operation', 'info_table');
        $this->setAttribute('table_name', $name);
    }

    /**
     * Set the operation to get columns of the table.
     */
    public function getColumns()
    {
        $this->setAttribute('get', 'columns');
    }

    /**
     * Get the SQL query generated for this table operation.
     *
     * @return string The SQL query.
     */
    public function getQuery(): string
    {
        return (string) new RunBuilder($this->getAttributes(), BuildAction::TABLE);
    }

    /**
     * Convert this table operation to its SQL query representation.
     *
     * @return string The SQL query.
     */
    public function __toString(): string
    {
        return $this->getQuery();
    }
}
