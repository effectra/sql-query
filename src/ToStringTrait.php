<?php

declare(strict_types=1);

namespace Effectra\SqlQuery;

trait ToStringTrait
{

    protected $sql_syntax = [
        'NULL', 'current_timestamp()'
    ];

    public function columnsList(array $columns, string $preLetter = null): string
    {
        if ($preLetter) {
            for ($i = 0; $i < count($columns); $i++) {
                $columns[$i] = $preLetter . '.' . $columns[$i];
            }
        }
        return join(',', $columns);
    }

    public function valuesList(array $values)
    {
        for ($i = 0; $i < count($values); $i++) {
            if (!in_array($values[$i], $this->sql_syntax)) {
                if (is_array($values[$i]) || is_object($values[$i])) {
                    $values[$i] =  "'" . json_encode($values[$i]) . "'";
                } else if (is_int($values)) {
                    $values[$i] = $values[$i];
                } else {
                    $values[$i] = "'" . $values[$i] . "'";
                }
            }
        }
        return join(',', $values);
    }
}
