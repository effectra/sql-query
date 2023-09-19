<?php

declare(strict_types=1);

namespace Effectra\SqlQuery\Destruct;

use Effectra\SqlQuery\Operations\Alter;

/**
 * Class AlterDestruct
 *
 * Represents an alteration operation for a database table.
 */
class AlterDestruct extends Alter
{
    /**
     * AlterDestruct constructor.
     *
     * @param array $structure The structure of the alteration operation.
     */
    public function __construct(array $structure)
    {
        $this->attributes = $structure;
    }
}
