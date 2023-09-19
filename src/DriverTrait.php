<?php

declare(strict_types=1);

namespace Effectra\SqlQuery;

/**
 * Trait DriverTrait
 *
 * This trait provides methods to set and get the database driver.
 */
trait DriverTrait
{
    /**
     * @var string The default database driver.
     */
    protected static string $driver = Driver::MySQL;

    /**
     * Set the database driver.
     *
     * @param string $driver The database driver to set.
     */
    public static function setDriver(string $driver): void
    {
        static::$driver = $driver;
    }

    /**
     * Get the current database driver.
     *
     * @return string The current database driver.
     */
    public static function getDriver(): string
    {
        return static::$driver;
    }
}
