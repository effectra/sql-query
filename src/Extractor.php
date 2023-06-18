<?php

declare(strict_types=1);

namespace Effectra\SqlQuery;

class Extractor
{
    protected $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function getTables()
    {
        $pattern = '/\bFROM\s+(\w+)/i';
        preg_match($pattern, $this->query, $matches);

        return isset($matches[1]) ? $matches[1] : null;
    }

    public function getColumns()
    {
        $pattern = '/\bSELECT\s+(.*?)\s+FROM/i';
        preg_match($pattern, $this->query, $matches);

        return isset($matches[1]) ? explode(',', $matches[1]) : [];
    }

    public function getLimit()
    {
        $pattern = '/\bLIMIT\s+(\d+)/i';
        preg_match($pattern, $this->query, $matches);

        return isset($matches[1]) ? intval($matches[1]) : null;
    }

    public function getJoins()
    {
        $pattern = '/\bJOIN\s+(.*?)\s+ON/i';
        preg_match_all($pattern, $this->query, $matches);

        return isset($matches[1]) ? $matches[1] : [];
    }

    public function getConditions()
    {
        $pattern = '/\bWHERE\s+(.*)/i';
        preg_match($pattern, $this->query, $matches);

        return isset($matches[1]) ? $matches[1] : null;
    }

    public function getOrder()
    {
        $pattern = '/\bORDER\s+BY\s+(.*)/i';
        preg_match($pattern, $this->query, $matches);

        return isset($matches[1]) ? $matches[1] : null;
    }
}
