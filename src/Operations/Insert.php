<?php

declare(strict_types=1);

namespace Effectra\SqlQuery\Operations;

use Effectra\SqlQuery\Attribute;
use Effectra\SqlQuery\Build\BuildAction;
use Effectra\SqlQuery\Build\RunBuilder;
use Effectra\SqlQuery\Validation\ArraysValidation;

class Insert extends Attribute
{

    public const INSERT_VALUES = 1;
    public const INSERT_DATA = 2;

    public const INSERT_VALUES_MODE_NORMAL = 3;
    public const INSERT_VALUES_MODE_SAFE = 4;

    use ArraysValidation, SetDataTrait;

    public function __construct(string $table, int $insert_type = self::INSERT_VALUES)
    {
        $this->setAttribute('operation', 'insert');
        $this->setAttribute('table_name', $table);
        $this->setAttribute('insert_type', $insert_type);
        $this->setAttribute('insert_data_mode', self::INSERT_VALUES_MODE_NORMAL);
    }

    public function getQuery(): string
    {
        return (string) new RunBuilder($this->getAttributes(), BuildAction::INSERT);
    }

    public function __toString(): string
    {
        return $this->getQuery();
    }
}
