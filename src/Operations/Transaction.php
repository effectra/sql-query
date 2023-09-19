<?php

declare(strict_types=1);

namespace Effectra\SqlQuery\Operations;

use Effectra\SqlQuery\Attribute;
use Effectra\SqlQuery\Build\BuildAction;
use Effectra\SqlQuery\Build\RunBuilder;
use Effectra\SqlQuery\Query;
use Effectra\SqlQuery\Structure\Column;
use Effectra\SqlQuery\Validation\ArraysValidation;


class Transaction extends Attribute
{
    const COMMIT = 'commit';
    const ROLLBACK = 'rollback';

    public function __construct() {
        
    }

    public function __destruct()
    {
        $this->addToAttribute('transaction','end');
    }

    public function begin()
    {
        $this->addToAttribute('transaction','begin');
    }

    public function record(array $queries)
    {
        $this->addToAttribute('transaction','record');
        $this->setAttribute('records',$queries);
    }

    public function commit()
    {
        $this->addToAttribute('transaction','commit');
        
    }

    public function rollback()
    {
        $this->addToAttribute('transaction','rollback');
    }

    public function ifSuccessful($operation)
    {
        $this->setAttribute('cond_start',true);
        $this->addToAttribute('cond','if_success');
        $this->addToAttribute('operation_success',$operation);
    }

    public function ifFailed($operation)
    {
        $this->setAttribute('cond_start',false);
        $this->addToAttribute('cond','if_failed');
        $this->addToAttribute('operation_failed',$operation);
    }

    public function getQuery(): string
    {
        return (string) new RunBuilder($this->getAttributes(), BuildAction::TRANSACTION);
    }

    public function __toString(): string
    {
        return $this->getQuery();
    }
}