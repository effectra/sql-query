<?php

declare(strict_types=1);

namespace Effectra\SqlQuery\Build;

use Effectra\SqlQuery\Attribute;
use Effectra\SqlQuery\Syntax;

/**
 * Class RunBuilder
 * Builds and executes SQL queries based on the provided attributes and action.
 */
class RunBuilder extends Attribute
{
    /**
     * RunBuilder constructor.
     *
     * @param array $attributes The attributes used to build the SQL query.
     * @param string $action The action to perform (e.g., select, insert, update).
     */
    public function __construct(
        protected array $attributes,
        protected string $action,
    ) {
        if (empty($this->attributes)) {
            throw new \Exception("Error Processing Query Builder attributes");
        }
    }

    /**
     * Build and execute the SQL query.
     *
     * @return string The generated SQL query.
     */
    public function run(): string
    {
        $syntax = new Syntax();

        $query = (string) match ($this->action) {
            //Structures
            'db' => new DatabaseQueryBuilder($this->attributes, $syntax),
            'table' => new TableQueryBuilder($this->attributes, $syntax),
            'column' => new ColumnQueryBuilder($this->attributes, $syntax),
            //Operations
            'select' => new SelectQueryBuilder($this->attributes, $syntax),
            'insert' => new InsertQueryBuilder($this->attributes, $syntax),
            'delete' => new DeleteQueryBuilder($this->attributes, $syntax),
            'truncate' => new TruncateQueryBuilder($this->attributes, $syntax),
            'update' => new UpdateQueryBuilder($this->attributes, $syntax),
            'drop' => new DropQueryBuilder($this->attributes, $syntax),
            'alter' => new AlterQueryBuilder($this->attributes, $syntax),
            'transaction' => new TransactionQueryBuilder($this->attributes, $syntax),
        };

        return $this->clean($query) . $this->queryAdded();
    }

    /**
     * Get the additional query added to the result.
     *
     * @return string The additional query.
     */
    public function queryAdded()
    {
        if ($this->hasAttribute('query')) {
            return $this->getAttribute('query');
        }
        return '';
    }

    /**
     * Clean the query by removing unnecessary whitespace.
     *
     * @param string $query The SQL query to clean.
     *
     * @return string The cleaned SQL query.
     */
    public function clean($query): string
    {
        return preg_replace_callback(
            "/'[^']*'(*SKIP)(*F)|\s+/",
            function ($matches) {
                return ' ';
            },
            $query
        );
    }

    /**
     * Convert the RunBuilder object to a string, executing the SQL query.
     *
     * @return string The generated SQL query.
     */
    public function __toString()
    {
        return $this->run();
    }
}
