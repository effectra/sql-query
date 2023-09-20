<?php

declare(strict_types=1);

namespace Effectra\SqlQuery\Build;

use Effectra\SqlQuery\Attribute;
use Effectra\SqlQuery\Destruct\ColumnDestruct;
use Effectra\SqlQuery\Syntax;

/**
 * Class AlterQueryBuilder
 *
 * Represents a query builder for generating SQL ALTER statements.
 *
 */
class AlterQueryBuilder extends Attribute
{

    use QueryBuilderTrait;

    /**
     * AlterQueryBuilder constructor.
     *
     * @param array $attributes An array of attributes for the ALTER query.
     * @param Syntax $syntax The syntax handler for constructing SQL queries.
     */
    public function __construct(protected array $attributes, protected Syntax $syntax)
    {
    }

     /**
     * Get the "ALTER" keyword to start the ALTER query.
     *
     * @return string The "ALTER" keyword.
     */
    public function start(): string
    {
        return $this->syntax->getCommand('alter', 1);
    }

    /**
     * Get the target structure (e.g., database or table) for the ALTER query.
     *
     * @return string The target structure and its name.
     */
    public function target()
    {
        $structure = "";
        $target = $this->getTarget();
        if ($target === 'database') {
            $structure = $this->getAttribute('database');
        }
        if ($target === 'table') {
            $structure = $this->getAttribute('table_name');
        }
        return $this->syntax->getCommand($target, 1) . $structure;
    }

    /**
     * Get the target structure type (e.g., "database" or "table").
     *
     * @return mixed The target structure type.
     */
    public function getTarget()
    {
        return $this->getAttribute('target');
    }

     /**
     * Get the constraints applied to the ALTER query.
     *
     * @return mixed The constraints added to the ALTER query.
     */
    public function constraints()
    {
        if ($this->hasAttribute('modify')) {
            return $this->constraintsModify();
        }
        if ($this->hasAttribute('rename')) {
            return $this->constraintsRename();
        }
        if ($this->hasAttribute('add')) {
            return $this->constraintsAdd();
        }
    }

      /**
     * Get the constraints for modifying a structure (e.g., column).
     *
     * @return string The constraints for modifying a structure.
     */
    public function constraintsModify(): string
    {
        if (isset($this->getAttribute('modify')['column'])) {

            $col = $this->getAttribute('modify')['column'];
            return $this->syntax->getCommand('alter', 1) .
                $this->syntax->getCommand('column', 1) .
                (string) (new ColumnDestruct($col))->addSet()->specifyDataType();
        }

        return '';
    }

    public function constraintsRename(): string
    {
        if (isset($this->getAttribute('rename')['db_name'])) {

            $db_name = $this->getAttribute('rename')['db_name'];

            return $this->syntax->getCommand('rename', 1) . $this->syntax->getCommand('to', 1) . $db_name;
        }


        if (isset($this->getAttribute('rename')['table_name'])) {

            $table_name = $this->getAttribute('rename')['table_name'];

            return $this->syntax->getCommand('rename', 1) . $this->syntax->getCommand('to', 1) . $table_name;
        }

        if (isset($this->getAttribute('rename')['column_name'])) {

            $col = $this->getAttribute('rename')['column_name'];
            return $this->syntax->getCommand('rename', 1) .
                $this->syntax->getCommand('column', 1) . $this->getAttribute('column') .
                $this->syntax->getCommand('to', 1) . $col;
        }

        return '';
    }

     /**
     * Get the constraints for adding a structure (e.g., column).
     *
     * @return string The constraints for adding a structure.
     */
    public function constraintsAdd(): string
    {
        if (isset($this->getAttribute('add')['column'])) {

            $col = $this->getAttribute('add')['column'];
            return $this->syntax->getCommand('add', 1) .
                $this->syntax->getCommand('column', 1) .
                (string) (new ColumnDestruct($col));
        }

        return '';
    }

      /**
     * Build the SQL ALTER query.
     *
     * @return string The generated SQL query.
     */
    public function build(): string
    {
        return sprintf(
            '%s %s %s',
            $this->start(),
            $this->target(),
            $this->constraints(),

        );
    }

    /**
     * Convert the query builder to its string representation.
     *
     * @return string The string representation of the query builder.
     */
    public function __toString()
    {
        return $this->build();
    }
}
