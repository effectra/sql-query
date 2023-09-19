<?php

declare(strict_types=1);

namespace Effectra\SqlQuery\Operations;

use Effectra\SqlQuery\Attribute;
use Effectra\SqlQuery\Build\BuildAction;
use Effectra\SqlQuery\Build\RunBuilder;
use Effectra\SqlQuery\Validation\ArraysValidation;


class Select extends Attribute
{
    use ArraysValidation,OperationsTrait;

    public function __construct(string $table)
    {
        $this->setAttribute('table_name', $table);
        $this->setAttribute('operation', 'select');
    }

    public function all(): self
    {
        $this->setAttribute('column_selected', '*');
        return $this;
    }

    public function columns(array $columns): self
    {
        foreach ($columns as $key => $value) {
            if (is_int($key)) {
                unset($columns[$key]);
                $columns[$value] =  $value;
            }
        }
        $this->setAttribute('column_selected', $columns);
        return $this;
    }

    public function limit(int $start_from, ?int $count_until = null): self
    {
        $this->setAttribute('limit', [
            'start_from' => $start_from,
            'count_until' => $count_until,
        ]);
        return $this;
    }

    public function groupBy(string $column, ...$columns): self
    {
        $this->setAttribute('group_by', [$column, ...$columns]);
        return $this;
    }

    public function orderBy(array|string $column, $direction): self
    {
        $this->setAttribute('order_by', [
            'cols' => is_string($column) ? [$column] : $column,
            'direction' => $direction
        ]);
        return $this;
    }

    public function or(): self
    {
        $this->sort('or');
        return $this;
    }

    public function and(): self
    {
        $this->sort('and');
        return $this;
    }

    public function sort(string $type): void
    {
        $col_selected = $this->getAttribute('where');
        if ($col_selected == null) {
            throw new \Exception("You cannot sign a conditions without select statement");
        }
        $this->addToAttribute('where_sort', [
            'operator' => $type,
            'after_conditions' => end($col_selected)['col']
        ]);
    }

    public function from($value)
    {
        $this->setAttribute('table_name', $value);
        return $this;
    }

    public function getQuery(): string
    {
        return (string) new RunBuilder($this->getAttributes(), BuildAction::SELECT);
    }

    public function __toString(): string
    {
        return $this->getQuery();
    }
}
