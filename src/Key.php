<?php

declare(strict_types=1);

namespace Effectra\SqlQuery;

class Key
{
    private string $query = '';
    private string $column = '';
    private string $type = '';
    private bool $withColumnName = true;

    /**
     * Key constructor.
     *
     * @param string $column The column name.
     * @param string $type The type of key (primary or unique).
     */
    public function __construct(string $column, string $type)
    {
        $this->column = $column;
        $this->type = $type;
    }

    /**
     * Set the key query.
     *
     * @return self
     */
    public function set(): self
    {
        $this->query = " KEY ";
        return $this;
    }

    /**
     * Set the key as primary.
     *
     * @return self
     */
    public function primary(): self
    {
        $this->query = " PRIMARY KEY ";
        return $this;
    }

    /**
     * Set the key as unique.
     *
     * @return self
     */
    public function unique(): self
    {
        $this->query = " UNIQUE KEY ";
        return $this;
    }

    /**
     * Build the key query based on the type.
     *
     * @return self
     */
    public function build(): self
    {
        if ($this->type === 'primary') {
            return $this->primary();
        }
        if ($this->type === 'unique') {
            return $this->unique();
        }
        return $this->set();
    }

    /**
     * Set whether to include the column name in the key query.
     *
     * @param bool $set Whether to include the column name.
     * @return self
     */
    public function withColumnName(bool $set = true): self
    {
        $this->withColumnName = $set;
        return $this;
    }

    /**
     * Get the string representation of the key query.
     *
     * @return string The key query.
     */
    public function __toString(): string
    {
        $last = $this->withColumnName ? "($this->column)" : '';
        return $this->query . $last;
    }
}
