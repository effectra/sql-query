<?php

declare(strict_types=1);

namespace Effectra\SqlQuery\Operations;

use Effectra\SqlQuery\Attribute;
use Effectra\SqlQuery\Build\BuildAction;
use Effectra\SqlQuery\Build\RunBuilder;
use Effectra\SqlQuery\Charset;
use Effectra\SqlQuery\Engine;
use Effectra\SqlQuery\Table;
use Effectra\SqlQuery\Syntax;
use Effectra\SqlQuery\Validation\ArraysValidation;


class CreateTable extends Attribute
{
    use ArraysValidation, OperationsTrait;

    public function __construct(protected string $table_name, protected  $table)
    {
        $this->setAttribute('operation', 'create_table');
        $this->setAttribute('table_name', $table_name);
        $this->setAttribute('cols', $this->getTableConstructs());
    }

    public function engine(string $engine): self
    {
        $this->setAttribute('engine', $engine);
        return $this;
    }

    public function charset(string $charset): self
    {
        $this->setAttribute('charset', $charset);
        return $this;
    }

    public function exists(bool $act = false): self
    {
        $this->setAttribute('exists', $act);
        return $this;
    }

    public function getTableConstructs(): array
    {
        $table = new Table(new Syntax());
        call_user_func($this->table, $table);
        if(empty($table->getAttribute('cols'))){
            throw new \Exception("Error Processing Query, No columns defined");
        }
        return array_values($table->getAttribute('cols'));
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
