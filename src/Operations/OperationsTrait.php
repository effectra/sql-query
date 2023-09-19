<?php

declare(strict_types=1);

namespace Effectra\SqlQuery\Operations;

trait OperationsTrait
{

    public function addQuery(string $query)
    {
        $this->setAttribute('query',$query);
    }

    public function where($columns = null, $flags = null, string $operator = 'equal'): self
    {

        if (!$columns) {
            $this->setAttribute('where', []);
        }

        if(is_object($columns)){
            $columns = (array) $columns;
        }

        if (is_array($columns)) {

            $firstItem = reset($columns);

            if (!$firstItem) {
                $this->addToAttribute('where', [
                    'col' => array_keys($columns)[0],
                    $operator => $firstItem
                ]);
            } else {

                if (is_string(key($columns)) && is_scalar($firstItem)) {
                    foreach ($columns as $key => $value) {
                        $this->addToAttribute('where', [
                            'col' => $key,
                            $operator => $value
                        ]);
                    }
                }

                if (is_array($firstItem) && count($firstItem) > 0) {
                    foreach ($columns as $column) {
                        foreach ($column as $key => $value) {
                            $this->addToAttribute('where', [
                                'col' => $key,
                                $operator => $value
                            ]);
                        }
                        if ($flags && in_array($flags, ['and', 'or'])) {
                            $this->sort($flags);
                        }
                    }
                }
            }
        }

        if(is_string($columns)){
            $this->setAttribute('where', $columns);
        }

        return $this;
    }

    public function whereEqual($columns, $flags = null): self
    {
        return $this->where($columns, $flags);
    }

    public function whereNotEqual($columns, $flags = null): self
    {
        return $this->where($columns, $flags, 'not_equal');
    }

    public function whereGreaterThan($columns, $flags = null): self
    {
        return $this->where($columns, $flags, 'greater_than');
    }

    public function whereLessThan($columns, $flags = null): self
    {
        return $this->where($columns, $flags, 'less_than');
    }

    public function whereGreaterThanOrEqual($columns, $flags = null): self
    {
        return $this->where($columns, $flags, 'greater_than_or_equal');
    }

    public function whereLessThanOrEqual($columns, $flags = null): self
    {
        return $this->where($columns, $flags, 'less_than_or_equal');
    }

    public function whereNot($columns, $flags = null): self
    {

        return $this->where($columns, $flags, 'not');
    }

    public function whereIsNotNull($columns, $flags = null): self
    {
        foreach ($columns as $key => $column) {
            $columns[] = [$column => ''];
            unset($columns[$key]);
        }
        return $this->where($columns, $flags, 'not_null');
    }

    public function whereIn($columns, $flags = null): self
    {
        return $this->where($columns, $flags, 'in');
    }

    public function whereLike($columns, $flags = null): self
    {
        return $this->where($columns, $flags, 'like');
    }

    public function whereFromColumnTable(string $column, string $table_joined, string $column_joined)
    {
        $this->setAttribute(
            'where',
            [
                'col' => $column,
                'from' =>  ['table' => $table_joined, 'column_joined' => $column_joined]
            ]
        );
        return $this;
    }

    public function inBetween(string $column, int|float $from, int|float $to): self
    {
        if ($to < $from) {
            throw new \Exception('The $to value must be greater than the $from value.');
        }

        $this->addToAttribute('where', [
            'col' => $column,
            'in_between' => ['from' => $from, 'to' => $to]
        ]);
        return $this;
    }

    public function whereColumn(string $column) 
    {
        $this->setAttribute('where_column',$column);
        return $this;
    }

    public function whereTable(string $table) 
    {
        $this->setAttribute('where_table',$table);
        return $this;
    }
}
