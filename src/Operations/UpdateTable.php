<?php

declare(strict_types=1);

namespace Effectra\SqlQuery\Operations;

use Effectra\SqlQuery\Attribute;
use Effectra\SqlQuery\Build\BuildAction;
use Effectra\SqlQuery\Build\RunBuilder;
use Effectra\SqlQuery\Table;
use Effectra\SqlQuery\Syntax;
use Effectra\SqlQuery\Validation\ArraysValidation;


class UpdateTable extends Attribute
{
    use ArraysValidation, OperationsTrait;

    public function __construct(protected string $table_name, protected  $table)
    {
        $this->setAttribute('operation','update_table');
        $this->setAttribute('table_name',$table_name);
        $this->mergeAttribute($this->getTableConstructs());
    }

    public function getTableConstructs(): array
    {
        $table = new Table(new Syntax());
        $table->setTableName($this->getAttribute('table_name'));
        
        call_user_func($this->table, $table);
        return $table->getAttributes();
    }

    public function getQuery(): string
    {
        return (string) new RunBuilder($this->getAttributes(), BuildAction::TABLE);
    }

    public function __toString(): string
    {
        return $this->getQuery();
    }
}
