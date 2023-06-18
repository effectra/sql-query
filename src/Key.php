<?php

declare(strict_types=1);

namespace Effectra\SqlQuery;

class Key
{
    private string $query = '';
    private string $column = '';
    private string $type = '';
    private bool $withColumnName = true;

    public function __construct($column, $type)
    {
        $this->column = $column;
        $this->type = $type;
    }

    public function set(): self
    {
        $this->query = " KEY  ";
        return $this;
    }

    public function primary(): self
    {
        $this->query = " PRIMARY KEY ";
        return $this;
    }

    public function unique(): self
    {
        $this->query = " KEY UNIQUE ";
        return $this;
    }

    public function build()
    {
        if ($this->type === 'primary') {
            return $this->primary();
        }
        if ($this->type === 'unique') {
            return $this->unique();
        }
        return $this->query;
    }

    public function withColumnName($set = true)
    {
        $this->withColumnName = $set;
        return $this;
    }

    public function __toString(): string
    {
        $last = $this->withColumnName ? "($this->column)" : '';
        return $this->query . $last;
    }
}
