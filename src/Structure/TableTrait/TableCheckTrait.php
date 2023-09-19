<?php

declare(strict_types=1);

namespace Effectra\SqlQuery\Structure\TableTrait;

use Effectra\SqlQuery\Destruct\ColumnDestruct;

trait TableCheckTrait
{
    /**
     * Add a CHECK constraint to the last column.
     *
     * @param mixed $expr The expression for the CHECK constraint.
     * @return self
     */
    public function checkOr(string $format): self
    {
        $col = new ColumnDestruct($this->getLastColumn());
        $col->checkOr($format);
        $this->addToAttribute('cols', $col->getAttributes());
        return $this;
    }

    /**
     * Add a CHECK LIKE constraint to the column.
     *
     * @param mixed $expr The expression for the CHECK constraint.
     * @return self
     */
    public function checkLike(string $format): self
    {
        $col = new ColumnDestruct($this->getLastColumn());
        $col->checkLike($format);
        $this->addToAttribute('cols', $col->getAttributes());
        return $this;
    }

    /**
     * Add a CHECK REGEXP constraint to the column.
     *
     * @param mixed $reg_ex The expression for the CHECK constraint.
     * @return self
     */
    public function checkRegEx(string $reg_ex): self
    {
        $col = new ColumnDestruct($this->getLastColumn());
        $col->checkRegEx($reg_ex);
        $this->addToAttribute('cols', $col->getAttributes());
        return $this;
    }

    /**
     * Add a CHECK LENGTH constraint to the column.
     *
     * @param mixed $length The length for the CHECK constraint.
     * @return self
     */
    public function checkLength($length): self
    {
        $col = new ColumnDestruct($this->getLastColumn());
        $col->checkLength($length);
        $this->addToAttribute('cols', $col->getAttributes());
        return $this;
    }

    /**
     * Add a CHECK BETWEEN two integer values constraint to the column.
     *
     * @param int $from
     * @param int $to
     * @return self
     */
    public function checkBetween(int $from, int $to): self
    {
        $col = new ColumnDestruct($this->getLastColumn());
        $col->checkBetween($from, $to);
        $this->addToAttribute('cols', $col->getAttributes());
        return $this;
    }
}
