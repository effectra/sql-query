<?php

declare(strict_types=1);

namespace Effectra\SqlQuery;

class Column
{
    private string $name;
    private string $type;
    private array $attributes;

    public function __construct(array $column)
    {
        $this->name = $column['name'];
        $this->type = $column['type'] ?? '';
        unset($column['name']);
        unset($column['type']);
        $this->attributes = $column;
    }

    public function withName($name)
    {
        $this->name = $name;
    }
    public function withType($type)
    {
        $this->type = $type;
    }

    public function __toString(): string
    {
        $columnStatement = "{$this->name} {$this->type}";

        if (isset($this->attributes['enum_values'])) {
            $enums = array_map(fn ($item) => "'" . $item . "'", $this->attributes['enum_values']);
            $columnStatement .= ' enum(' . join(',', $enums) . ')';
        }

        if (isset($this->attributes['size'])) {
            $columnStatement .= '(' . $this->attributes['size'] . ')';
        }

        if (isset($this->attributes['unsigned'])) {
            $columnStatement .= ' UNSIGNED ';
        }

        if (isset($this->attributes['charset'])) {
            $columnStatement .= ' CHARACTER SET ' . $this->attributes['charset'];
        }

        if (isset($this->attributes['collate'])) {
            $columnStatement .= ' COLLATE ' . $this->attributes['collate'];
        }

        if (isset($this->attributes['nullable']) && $this->attributes['nullable'] === true) {
            $columnStatement .= ' NULL';
        } else {
            $columnStatement .= ' NOT NULL';
        }

        if (isset($this->attributes['auto_increment'])) {
            $columnStatement .= ' AUTO_INCREMENT ';
        }

        if (isset($this->attributes['default'])) {
            $columnStatement .= ' DEFAULT ' . $this->attributes['default'];
        }

        if (isset($this->attributes['current_time'])) {
            $columnStatement .= ' DEFAULT CURRENT_TIMESTAMP ';
        }

        if (isset($this->attributes['check'])) {
            $columnStatement .= ' CHECK (' . $this->attributes['check'] . ')';
        }

        if (isset($this->attributes['after'])) {
            $columnStatement .= ' AFTER ' . $this->attributes['after'];
        }

        return $columnStatement;
    }
}
