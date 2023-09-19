<?php

declare(strict_types=1);

namespace Effectra\SqlQuery\Operations;

use Effectra\SqlQuery\Attribute;
use Effectra\SqlQuery\Build\BuildAction;
use Effectra\SqlQuery\Build\RunBuilder;
use Effectra\SqlQuery\Structure\Column;
use Effectra\SqlQuery\Validation\ArraysValidation;


class Alter extends Attribute
{
    use ArraysValidation, OperationsTrait;

    public function __construct()
    {
        $this->setAttribute('target', 'table');
    }

    public function callColumnClass(string $column,callable|array $definitions):Column
    {
        $col = new Column($column,false);
        if(is_callable($definitions)){
            call_user_func($definitions,$col);
        }
        if(is_array($definitions)){
            $col->setAttributes($definitions);
        }
        return $col;
    }

    public function database( $name): self
    {
        $this->setAttribute('target', 'database');
        $this->setAttribute('database', $name);
        return $this;
    }

    public function table( $name): self
    {
        $this->setAttribute('target', 'table');
        $this->setAttribute('table_name', $name);
        return $this;
    }

    public function column( $name): self
    {
        $this->setAttribute('column', $name);
        return $this;
    }

    public function renameDB($new_name)
    {
        $this->setAttribute('rename', [
            'db_name' => $new_name
        ]);
        return $this;
    }

    public function renameTable($new_name)
    {
        $this->setAttribute('rename', [
            'table_name' => $new_name
        ]);
        return $this;
    }
    
    public function renameColumn($new_name)
    {
        $this->setAttribute('rename', [
            'column_name' => $new_name
        ]);
        return $this;
    }
    
    public function modifyColumn(string $column,callable|array $changes)
    {
        $changesColumn = $this->callColumnClass($column,$changes);
        $this->setAttribute('modify', [
            'column' => $changesColumn->getAttributes()
        ]);
        return $this;
    }

    public function addColumn(string $column,callable|array $changes)
    {
        $changesColumn = $this->callColumnClass($column,$changes);
        $this->setAttribute('add', [
            'column' => $changesColumn->getAttributes()
        ]);
        return $this;
    }

    public function getQuery(): string
    {
        return (string) new RunBuilder($this->getAttributes(), BuildAction::ALTER);
    }

    public function __toString(): string
    {
        return $this->getQuery();
    }

}