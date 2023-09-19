<?php

declare(strict_types=1);

namespace Effectra\SqlQuery\Build;

use Effectra\SqlQuery\Attribute;
use Effectra\SqlQuery\Syntax;

/**
 * Class TransactionQueryBuilder
 * Builds an SQL transaction query based on provided attributes and syntax.
 */
class TransactionQueryBuilder extends Attribute
{
    use QueryBuilderTrait;

    /**
     * TransactionQueryBuilder constructor.
     *
     * @param array $attributes The attributes used to build the SQL query.
     * @param Syntax $syntax The syntax object providing SQL commands and formatting.
     */
    public function __construct(protected array $attributes, protected Syntax $syntax)
    {
    }

    /**
     * Get the "BEGIN" command for starting a transaction.
     *
     * @return string The "BEGIN" command for starting a transaction.
     */
    public function start()
    {
        return $this->syntax->getCommand('begin', 2) . ';';
    }

    /**
     * Get the records to be executed as part of the transaction.
     *
     * @return string The records to be executed as part of the transaction.
     */
    public function records()
    {
        $records = [];

        foreach ($this->getAttribute('records') as $record) {
            $records[] = (string) $record;
        }

        return str_replace(';;', ';', join(';', $records));
    }

    /**
     * Get the conditions for the transaction (commit or rollback).
     *
     * @return string The conditions for the transaction.
     */
    public function conditions()
    {
        return <<<SQL
{$this->syntax->getCommand('if', 1)}
@@{$this->syntax->getCommand('row_count', 3)} = -1
{$this->syntax->getCommand('then', 1)}
{$this->syntax->getCommand('rollback', 1)};{$this->syntax->getCommand('select', 1)} 'Transaction rolled back.'
{$this->syntax->getCommand('else', 1)} {$this->syntax->getCommand('commit', 1)};{$this->syntax->getCommand('select', 1)} 'Transaction committed.';
{$this->syntax->getCommand('end_if', 1)}
SQL;
    }

    /**
     * Build the SQL transaction query.
     *
     * @return string The generated SQL transaction query.
     */
    public function build(): string
    {
        return sprintf(
            '%s %s %s',
            $this->start(),
            $this->records(),
            $this->conditions(),
        );
    }

    /**
     * Convert the TransactionQueryBuilder object to a string, representing the SQL transaction query.
     *
     * @return string The generated SQL transaction query.
     */
    public function __toString()
    {
        return $this->build();
    }
}
