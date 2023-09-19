<?php

declare(strict_types=1);

namespace Effectra\SqlQuery;

/**
 * Class Driver
 *
 * This class defines constants for various database drivers and provides a method
 * to retrieve available drivers.
 */
class Driver
{
    /**
     * MySQL driver constant.
     */
    public const MySQL = 'mysql';

    /**
     * PostgreSQL driver constant.
     */
    public const PostgreSQL = 'postgresql';

    /**
     * SQLite driver constant.
     */
    public const SQLite = 'sqlite';

    /**
     * Get the list of available database drivers.
     *
     * @return array An array of available database driver constants.
     */
    public static function getAvailableDrivers(): array
    {
        return [
            static::MySQL,
            static::PostgreSQL,
            static::SQLite,
        ];
    }
}
