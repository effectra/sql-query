<?php

declare(strict_types=1);

namespace Effectra\SqlQuery\Destruct;

use Effectra\SqlQuery\Structure\Column;

/**
 * Class ColumnDestruct
 *
 * Represents a destructed version of a database column.
 */
class ColumnDestruct extends Column
{
    /**
     * ColumnDestruct constructor.
     *
     * @param array $structure The structure of the column.
     */
    public function __construct(array $structure)
    {
        $this->attributes = $structure;
    }
}
