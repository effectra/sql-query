<?php

declare(strict_types=1);

namespace Effectra\SqlQuery;

/**
 * Class Transaction
 *
 * Helps in building a transaction SQL query.
 *
 * @package Effectra\SqlQuery
 */
class Transaction
{
    /**
     * Builds a transaction SQL query.
     *
     * @param array $queries An array of SQL queries to be executed within the transaction.
     * @return string The generated transaction SQL query.
     * @throws \InvalidArgumentException If the array of queries is empty.
     */
    public function buildQuery(array $queries): string
    {
        if (empty($queries)) {
            throw new \InvalidArgumentException("Array of queries cannot be empty.");
        }

        $transactionQuery = "BEGIN;\n";
        
        foreach ($queries as $query) {
            $transactionQuery .= $query . ";\n";
        }

        $transactionQuery .= "COMMIT;";

        return $transactionQuery;
    }
}
