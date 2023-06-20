<?php

declare(strict_types=1);

namespace Effectra\SqlQuery;

trait ToStringTrait
{
    protected $sql_syntax = [
        'NULL', 'current_timestamp()'
    ];
    /**
     * Convert an array of columns to a string representation.
     *
     * @param array       $columns    The array of columns.
     * @param string|null $preLetter  The prefix letter to prepend to each column.
     * @return string                 The string representation of columns.
     */
    public function columnsList(array $columns, ?string $preLetter = null): string
    {
        if ($preLetter) {
            $count = count($columns);
            for ($index = 0; $index < $count; $index++) {
                $columns[$index] = $preLetter . '.' . $columns[$index];
            }
        }
        return implode(',', $columns);
    }

    /**
     * Convert an array of values to a string representation.
     *
     * @param array $values  The array of values.
     * @return string        The string representation of values.
     */
    public function valuesList(array $values): string
    {
        $count = count($values);
        for ($index = 0; $index < $count; $index++) {
            if (!in_array($values[$index], $this->sql_syntax)) {
                if (is_array($values[$index])) {
                    $values[$index] =  "'" . json_encode($values[$index]) . "'";
                } else if (is_int($values[$index])) {
                    $values[$index] = $values[$index];
                } else {
                    $values[$index] = "'" . $values[$index] . "'";
                }
            }
        }
        return implode(',', $values);
    }
}
