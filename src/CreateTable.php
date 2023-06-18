<?php

declare(strict_types=1);

namespace Effectra\SqlQuery;

use PDO;

class CreateTable
{

    private const CREATE_TABLE = "CREATE TABLE ";
    private const IF_NOT_EXISTS = " IF NOT EXISTS ";
    private const OPENING_BRACKET = " (";
    private const CLOSING_BRACKET = ")";
    private const ENGINE = " ENGINE=";
    private const CHARSET = " DEFAULT CHARSET=";

    private string $query = '';
    private string $table = '';
    private string $engine = 'InnoDB';
    private string $charset = 'utf8mb4';

    private bool $ifNotExists = true;

    private array $columns = [];
    private array $keys = [];

    public function __construct(string $table, array $columns, array $keys = [])
    {
        $this->table = $table;
        $this->columns = $columns;
        $this->keys = $this->filter($keys);
    }

    public function filter($keys)
    {
       return array_filter($keys,function ($key) {
            if (is_string($key) && !empty($key)) {
                return $key;
            }
        });
    }

    public function getQuery(): string
    {
        return $this->query;
    }

    public function getTable(): string
    {
        return $this->table;
    }

    public function engine(string $engine): self
    {
        $this->engine = $engine;
        return $this;
    }

    public function charset(string $charset): self
    {
        $this->charset = $charset;
        return $this;
    }

    public function exists(bool $act = false): self
    {
        $this->ifNotExists = !$act;
        return $this;
    }

    public function __toString(): string
    {
        $this->buildQuery();
        return $this->query;
    }


    private function buildQuery(): void
    {
        $this->query = self::CREATE_TABLE;

        if ($this->ifNotExists) {
            $this->query .= self::IF_NOT_EXISTS;
        }

        $this->query .= $this->table  . self::OPENING_BRACKET;

        $this->query .= join(', ', $this->columns);

        if (!empty($this->keys)) {
            $this->query .= ',' . join(',', $this->keys);
        }

        $this->query .= self::CLOSING_BRACKET;

        if (!empty($this->engine)) {
            $this->query .= self::ENGINE . $this->engine;
        }

        if (!empty($this->charset)) {
            $this->query .= self::CHARSET . $this->charset;
        }
    }
}
