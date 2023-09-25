<?php

declare(strict_types=1);

namespace Effectra\SqlQuery\Structure;

use Effectra\SqlQuery\Attribute;
use Effectra\SqlQuery\Build\BuildAction;
use Effectra\SqlQuery\Build\RunBuilder;
use Effectra\SqlQuery\Types\DataTypesTrait;

/**
 * Class Database
 * Represents a Database in a SQL table.
 */
class Database extends Attribute
{
    use DataTypesTrait;

    /**
     * Database constructor.
     *
     * @param string $name The name of the database.
     */
    public function __construct(string $name)
    {
        $this->setAttribute('db_name', $name);
    }

    /**
     * Set the operation to create the database.
     */
    public function create($options = [])
    {
        $this->setAttribute('operation', 'create');
        $this->setAttribute('options',$options);
        return $this;
    }

    /**
     * Set the operation to drop the database.
     */
    public function drop()
    {
        $this->setAttribute('operation', 'drop');
        return $this;
    }

    /**
     * Set the operation to rename the database.
     *
     * @param string $new_name The new name for the database.
     */
    public function rename(string $new_name)
    {
        $this->setAttribute('operation', 'rename');
        $this->setAttribute('rename', $new_name);
        return $this;
    }

    /**
     * Set the operation to get tables in the database.
     */
    public function getTables()
    {
        $this->setAttribute('operation', 'get_tables');
        return $this;
    }

    /**
     * Get the SQL query generated for this database operation.
     *
     * @return string The SQL query.
     */
    public function getQuery(): string
    {
        return (string) new RunBuilder($this->getAttributes(), BuildAction::DATABASE);
    }

    /**
     * Convert this database operation to its SQL query representation.
     *
     * @return string The SQL query.
     */
    public function __toString(): string
    {
        return $this->getQuery();
    }
}
