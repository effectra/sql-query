<?php

declare(strict_types=1);

namespace Effectra\SqlQuery;

class Extractor
{
    protected $query;

    /**
     * Extractor constructor.
     *
     * @param string $query The SQL query.
     */
    public function __construct(string $query)
    {
        $this->query = $query;
    }

    /**
     * Get the tables mentioned in the query.
     *
     * @return string|null The table name.
     */
    public function getTables(): ?string
    {
        $pattern = '/\bFROM\s+(\w+)/i';
        preg_match($pattern, $this->query, $matches);

        return isset($matches[1]) ? $matches[1] : null;
    }

    /**
     * Get the columns mentioned in the SELECT clause of the query.
     *
     * @return array The column names.
     */
    public function getColumns(): array
    {
        $pattern = '/\bSELECT\s+(.*?)\s+FROM/i';
        preg_match($pattern, $this->query, $matches);

        return isset($matches[1]) ? explode(',', $matches[1]) : [];
    }

    /**
     * Get the LIMIT value from the query.
     *
     * @return int|null The LIMIT value.
     */
    public function getLimit(): ?int
    {
        $pattern = '/\bLIMIT\s+(\d+)/i';
        preg_match($pattern, $this->query, $matches);

        return isset($matches[1]) ? intval($matches[1]) : null;
    }

    /**
     * Get the JOIN clauses from the query.
     *
     * @return array The JOIN clauses.
     */
    public function getJoins(): array
    {
        $pattern = '/\bJOIN\s+(.*?)\s+ON/i';
        preg_match_all($pattern, $this->query, $matches);

        return isset($matches[1]) ? $matches[1] : [];
    }

    /**
     * Get the WHERE condition from the query.
     *
     * @return string|null The WHERE condition.
     */
    public function getConditions(): ?string
    {
        $pattern = '/\bWHERE\s+(.*)/i';
        preg_match($pattern, $this->query, $matches);

        return isset($matches[1]) ? $matches[1] : null;
    }

    /**
     * Get the ORDER BY clause from the query.
     *
     * @return string|null The ORDER BY clause.
     */
    public function getOrder(): ?string
    {
        $pattern = '/\bORDER\s+BY\s+(.*)/i';
        preg_match($pattern, $this->query, $matches);

        return isset($matches[1]) ? $matches[1] : null;
    }
}
