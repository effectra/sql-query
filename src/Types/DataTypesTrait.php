<?php

declare(strict_types=1);

namespace Effectra\SqlQuery\Types;

trait DataTypesTrait
{
    public function timestamp(): self
    {
        $this->setAttribute('data_type', 'timestamp');
        return $this;
    }
    public function date(): self
    {
        $this->setAttribute('data_type', 'date');
        return $this;
    }
    public function year(): self
    {
        $this->setAttribute('data_type', 'year');
        return $this;
    }
    public function time(): self
    {
        $this->setAttribute('data_type', 'time');
        return $this;
    }
    public function datetime(): self
    {
        $this->setAttribute('data_type', 'datetime');
        return $this;
    }

    public function boolean(): self
    {
        $this->setAttribute('data_type', 'boolean');
        return $this;
    }
    public function int(): self
    {
        $this->setAttribute('data_type', 'int');
        return $this;
    }
    public function bigInt(): self
    {
        $this->setAttribute('data_type', 'bigInt');
        return $this;
    }
    public function decimal(): self
    {
        $this->setAttribute('data_type', 'decimal');
        return $this;
    }

    public function bit(): self
    {
        $this->setAttribute('data_type', 'bit');
        return $this;
    }
    public function tinyInt(): self
    {
        $this->setAttribute('data_type', 'tinyInt');
        return $this;
    }
    public function smallInt(): self
    {
        $this->setAttribute('data_type', 'smallInt');
        return $this;
    }
    public function bool(): self
    {
        $this->setAttribute('data_type', 'bool');
        return $this;
    }
    public function mediumInt(): self
    {
        $this->setAttribute('data_type', 'mediumInt');
        return $this;
    }
    public function integer(): self
    {
        $this->setAttribute('data_type', 'integer');
        return $this;
    }
    public function double(): self
    {
        $this->setAttribute('data_type', 'double');
        return $this;
    }
    public function doublePrecision(): self
    {
        $this->setAttribute('data_type', 'doublePrecision');
        return $this;
    }
    public function float(): self
    {
        $this->setAttribute('data_type', 'float');
        return $this;
    }
    public function varchar(): self
    {
        $this->setAttribute('data_type', 'varchar');
        return $this;
    }
    public function char(): self
    {
        $this->setAttribute('data_type', 'char');
        return $this;
    }
    public function text(): self
    {
        $this->setAttribute('data_type', 'text');
        return $this;
    }
    public function tinyText(): self
    {
        $this->setAttribute('data_type', 'tinyText');
        return $this;
    }
    public function mediumText(): self
    {
        $this->setAttribute('data_type', 'mediumText');
        return $this;
    }
    public function longText(): self
    {
        $this->setAttribute('data_type', 'longText');
        return $this;
    }
    public function blob(): self
    {
        $this->setAttribute('data_type', 'blob');
        return $this;
    }
    public function tinyBlob(): self
    {
        $this->setAttribute('data_type', 'tinyBlob');
        return $this;
    }
    public function mediumBlob(): self
    {
        $this->setAttribute('data_type', 'mediumBlob');
        return $this;
    }
    public function longBlob(): self
    {
        $this->setAttribute('data_type', 'longBlob');
        return $this;
    }
    public function binary(): self
    {
        $this->setAttribute('data_type', 'binary');
        return $this;
    }
    public function varBinary(): self
    {
        $this->setAttribute('data_type', 'varBinary');
        return $this;
    }
    public function json(): self
    {
        $this->setAttribute('data_type', 'json');
        $this->addToAttribute('check','json');
        $this->addToAttribute('check_sort','and');
        return $this;
    }
    public function uuid(): self
    {
        $this->setAttribute('data_type', 'uuid');
        return $this;
    }
    public function enum(array $values): self
    {
        $this->setAttribute('data_type', 'enum');
        $this->setAttribute('datatype_values', $values);
        return $this;
    }
    public function set(array $values): self
    {
        $this->setAttribute('data_type', 'set');
        $this->setAttribute('datatype_values', $values);
        return $this;
    }

    public function setSize(?int $size, int $min, int $max): void
    {
        if ($size === null) {
            throw new \Exception("Error Processing Size: Size cannot be null.");
        }

        if ($size < $min || $size > $max) {
            throw new \Exception("Error Processing Size: Size is not within the allowed range.");
        }

        $this->setAttribute('size', $size);
    }
}
