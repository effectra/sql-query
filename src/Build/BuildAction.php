<?php

declare(strict_types=1);

namespace Effectra\SqlQuery\Build;

/**
 * Class BuildAction
 * Represents the types of SQL query build actions.
 */
class BuildAction
{
    public const DATABASE = 'db';
    public const SELECT = 'select';
    public const DELETE = 'delete';
    public const TRUNCATE = 'truncate';
    public const INSERT = 'insert';
    public const UPDATE = 'update';
    public const ALTER = 'alter';
    public const DROP = 'drop';
    public const COLUMN = 'column';
    public const TABLE = 'table';
    public const TRANSACTION = 'transaction';
    public const TABLE_UPDATE = 'update_table';
}
