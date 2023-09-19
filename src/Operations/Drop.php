<?php

declare(strict_types=1);

namespace Effectra\SqlQuery\Operations;

use Effectra\SqlQuery\Attribute;
use Effectra\SqlQuery\Build\BuildAction;
use Effectra\SqlQuery\Build\RunBuilder;
use Effectra\SqlQuery\Validation\ArraysValidation;


class Drop extends Attribute
{
    use ArraysValidation, OperationsTrait;

    public function __construct()
    {
        $this->setAttribute('operation', 'drop');
    }

    public function database($name): self
    {
        $this->setAttribute('database', $name);
        return $this;
    }

    public function table($tableName): self
    {
        $this->setAttribute('table', $tableName);
        return $this;
    }

    public function column($name): self
    {
        $this->setAttribute('column', $name);
        return $this;
    }

    public function key($name): self
    {
        $this->setAttribute('key', $name);
        return $this;
    }
    

    public function index($name): self
    {
        $this->setAttribute('index', $name);
        return $this;
    }

    public function dropDatabase(): void
    {
        $this->setAttribute('target', 'database');
    }

    public function dropTable(): void
    {
        $this->setAttribute('target', 'table');
    }

    public function dropColumn(): void
    {
        $this->setAttribute('target', 'column');
    }

    public function dropKey(): void
    {
        $this->setAttribute('target', 'key');
    }

    public function dropPrimaryKey(): void
    {
        $this->dropKey();
        $this->setAttribute('type', 'primary_key');
    }

    public function dropForeignKey(): void
    {
        $this->dropKey();
        $this->setAttribute('type', 'foreign_key');
    }

    public function dropUniqueKey(): void
    {
        $this->dropIndex();
        $this->setAttribute('type', 'unique_key');
    }
    
    public function dropIndex(): void
    {
        $this->setAttribute('target', 'index');
    }


    public function getQuery(): string
    {
        return (string) new RunBuilder($this->getAttributes(), BuildAction::DROP);
    }

    public function __toString(): string
    {
        return $this->getQuery();
    }
}
