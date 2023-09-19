<?php

declare(strict_types=1);

namespace Effectra\SqlQuery\Operations;

use Effectra\SqlQuery\Attribute;
use Effectra\SqlQuery\Build\BuildAction;
use Effectra\SqlQuery\Build\RunBuilder;
use Effectra\SqlQuery\Validation\ArraysValidation;


class Update extends Attribute
{
    use ArraysValidation, OperationsTrait, SetDataTrait;

    public function __construct(string $table)
    {
        $this->setAttribute('table_name', $table);
        $this->setAttribute('operation', 'update');
        $this->setAttribute('insert_data_mode', Insert::INSERT_VALUES_MODE_NORMAL);
    }

    public function getQuery(): string
    {
        return (string) new RunBuilder($this->getAttributes(), BuildAction::UPDATE);
    }

    public function __toString(): string
    {
        return $this->getQuery();
    }
}
