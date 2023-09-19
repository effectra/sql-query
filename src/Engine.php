<?php

declare(strict_types=1);

namespace Effectra\SqlQuery;

/**
 * Class Engine
 *
 * This class defines constants for various database storage engines.
 */
class Engine
{
    const MYSQL_InnoDB = 'InnoDB';
    const MYSQL_MyISAM = 'MyISAM';
    const MYSQL_Memory = 'Memory';
    const MYSQL_NDB = 'NDB';
    const MYSQL_Archive = 'Archive';
    const MYSQL_Merge = 'Merge';
    const MYSQL_TokuDB = 'TokuDB';
    const MYSQL_Aria = 'Aria';
    const MYSQL_RocksDB = 'RocksDB';
    const PostgreSQL_TimescaleDB = 'TimescaleDB';
    const PostgreSQL_Citus = 'Citus';
    const PostgreSQL_Hypertable = 'Hypertable';
    const PostgreSQL_Cstore = 'Cstore';
    const PostgreSQL_ZomboDB = 'ZomboDB';

    /**
     * Get an array of available MySQL storage engines.
     *
     * @return array An array of available MySQL storage engine constants.
     */
    public static function getAvailableMySQLEngines(): array
    {
        return [
            self::MYSQL_InnoDB,
            self::MYSQL_MyISAM,
            self::MYSQL_Memory,
            self::MYSQL_NDB,
            self::MYSQL_Archive,
            self::MYSQL_Merge,
            self::MYSQL_TokuDB,
            self::MYSQL_Aria,
            self::MYSQL_RocksDB,
        ];
    }

    /**
     * Get an array of available PostgreSQL storage engines.
     *
     * @return array An array of available PostgreSQL storage engine constants.
     */
    public static function getAvailablePostgreSQLEngines(): array
    {
        return [
            self::PostgreSQL_TimescaleDB,
            self::PostgreSQL_Citus,
            self::PostgreSQL_Hypertable,
            self::PostgreSQL_Cstore,
            self::PostgreSQL_ZomboDB,
        ];
    }
}
