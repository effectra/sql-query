<?php

declare(strict_types=1);

namespace Effectra\SqlQuery\Types;

use Effectra\SqlQuery\DriverTrait;
use Effectra\SqlQuery\Syntax;

class DataTypes
{
    use DriverTrait;

    public function __construct()
    {
        $this->setDriver(Syntax::getDriver());
    }

    /**
     * Equal to BOOL
     */
    public function boolean(): string
    {
        return match ($this->getDriver()) {
            'mysql' => 'BOOLEAN',
            'sqlite' => 'BOOLEAN',
            'postgresql' => 'BOOLEAN',
            default => 'BOOLEAN',
        };
    }

    /**
     * A medium integer. Signed range is from -2147483648 to 2147483647. Unsigned range is from 0 to 4294967295. The size parameter specifies the maximum display width (which is 255)
     */
    public function int(): string
    {
        return match ($this->getDriver()) {
            'mysql' => 'INT',
            'sqlite' => 'INTEGER',
            'postgresql' => 'INTEGER',
            default => 'INT',
        };
    }

    /**
     * A large integer. Signed range is from -9223372036854775808 to 9223372036854775807. Unsigned range is from 0 to 18446744073709551615. The size parameter specifies the maximum display width (which is 255)
     */
    public function bigInt(): string
    {
        return match ($this->getDriver()) {
            'mysql' => 'BIGINT',
            'sqlite' => 'INTEGER', // SQLite does not have a native BIGINT type
            'postgresql' => 'BIGINT',
            default => 'BIGINT',
        };
    }

    /**
     * An exact fixed-point number. The total number of digits is specified in size. The number of digits after the decimal point is specified in the d parameter. The maximum number for size is 65. The maximum number for d is 30. The default value for size is 10. The default value for d is 0.
     */
    public function decimal(): string
    {
        return match ($this->getDriver()) {
            'mysql' => 'DECIMAL',
            'sqlite' => 'NUMERIC',
            'postgresql' => 'NUMERIC',
            default => 'NUMERIC',
        };
    }
    /**
     * A bit-value type. The number of bits per value is specified in size. The size parameter can hold a value from 1 to 64. The default value for size is 1
     */
    public function bit(): string
    {
        return match ($this->getDriver()) {
            'mysql' => 'BIT',
            'sqlite' => 'INTEGER', // SQLite does not have a native BIT type
            'postgresql' => 'BIT', // PostgreSQL equivalent to BIT
            default => 'INTEGER', // Default to INTEGER for unknown drivers
        };
    }

    /**
     * A very small integer. Signed range is from -128 to 127. Unsigned range is from 0 to 255. The size parameter specifies the maximum display width (which is 255)
     */
    public function tinyInt(): string
    {
        return match ($this->getDriver()) {
            'mysql' => 'TINYINT',
            'sqlite' => 'INTEGER',
            'postgresql' => 'SMALLINT',
            default => 'INTEGER',
        };
    }

    /**
     * A small integer. Signed range is from -32768 to 32767. Unsigned range is from 0 to 65535. The size parameter specifies the maximum display width (which is 255)
     */
    public function smallInt(): string
    {
        return match ($this->getDriver()) {
            'mysql' => 'SMALLINT',
            'sqlite' => 'INTEGER',
            'postgresql' => 'SMALLINT',
            default => 'INTEGER',
        };
    }

    /**
     * Zero is considered as false, nonzero values are considered as true.
     */
    public function bool(): string
    {
        return match ($this->getDriver()) {
            'mysql' => 'BOOL',
            'sqlite' => 'INTEGER', // SQLite does not have a native BOOL type
            'postgresql' => 'BOOLEAN',
            default => 'BOOLEAN', // Default to BOOLEAN for unknown drivers
        };
    }

    /**
     * A medium integer. Signed range is from -8388608 to 8388607. Unsigned range is from 0 to 16777215. The size parameter specifies the maximum display width (which is 255)
     */
    public function mediumInt(): string
    {
        return match ($this->getDriver()) {
            'mysql' => 'MEDIUMINT',
            'sqlite' => 'INTEGER',
            'postgresql' => 'INTEGER',
            default => 'INTEGER',
        };
    }

    /**
     * Equal to INT(size)
     */
    public function integer(): string
    {
        return match ($this->getDriver()) {
            'mysql' => 'INTEGER',
            'sqlite' => 'INTEGER',
            'postgresql' => 'INTEGER',
            default => 'INTEGER',
        };
    }

    /**
     * A normal-size floating point number. The total number of digits is specified in size. The number of digits after the decimal point is specified in the d parameter
     */
    public function double(): string
    {
        return match ($this->getDriver()) {
            'mysql' => 'DOUBLE',
            'sqlite' => 'REAL', // SQLite uses REAL for floating-point types
            'postgresql' => 'DOUBLE PRECISION', // PostgreSQL equivalent to DOUBLE
            default => 'DOUBLE',
        };
    }

    public function doublePrecision(): string
    {
        return match ($this->getDriver()) {
            'mysql' => 'DOUBLE PRECISION',
            'sqlite' => 'REAL',
            'postgresql' => 'DOUBLE PRECISION',
            default => 'DOUBLE PRECISION',
        };
    }

    /**
     * A floating point number. MySQL uses the p value to determine whether to use FLOAT or DOUBLE for the resulting data type. If p is from 0 to 24, the data type becomes FLOAT(). If p is from 25 to 53, the data type becomes DOUBLE()
     */
    public function float(): string
    {
        return match ($this->getDriver()) {
            'mysql' => 'FLOAT',
            'sqlite' => 'REAL',
            'postgresql' => 'REAL',
            default => 'REAL',
        };
    }

    /**
     * A date and time combination. Format: YYYY-MM-DD hh:mm:ss. The supported range is from '1000-01-01 00:00:00' to '9999-12-31 23:59:59'. Adding DEFAULT and ON UPDATE in the column definition to get automatic initialization and updating to the current date and time
     */
    public function timestamp(): string
    {
        return match ($this->getDriver()) {
            'mysql' => 'TIMESTAMP',
            'sqlite' => 'DATETIME',
            'postgresql' => 'TIMESTAMP',
            default => 'TIMESTAMP',
        };
    }

    /**
     * A date. Format: YYYY-MM-DD. The supported range is from '1000-01-01' to '9999-12-31'
     */
    public function date(): string
    {
        return match ($this->getDriver()) {
            'mysql' => 'DATE',
            'sqlite' => 'DATE',
            'postgresql' => 'DATE',
            default => 'DATE',
        };
    }

    /**
     * A year in four-digit format. Values allowed in four-digit format: 1901 to 2155, and 0000.
     */
    public function year(): string
    {
        return match ($this->getDriver()) {
            'mysql' => 'YEAR',
            'sqlite' => 'INTEGER', // SQLite does not have a native YEAR type
            'postgresql' => 'INTEGER', // PostgreSQL does not have a native YEAR type
            default => 'INTEGER', // Default to INTEGER for unknown drivers
        };
    }

    /**
     * A time. Format: hh:mm:ss. The supported range is from '-838:59:59' to '838:59:59'
     */
    public function time(): string
    {
        return match ($this->getDriver()) {
            'mysql' => 'TIME',
            'sqlite' => 'TEXT', // SQLite uses TEXT for time types
            'postgresql' => 'TIME',
            default => 'TIME',
        };
    }

    /**
     * A date and time combination. Format: YYYY-MM-DD hh:mm:ss. The supported range is from '1000-01-01 00:00:00' to '9999-12-31 23:59:59'. Adding DEFAULT and ON UPDATE in the column definition to get automatic initialization and updating to the current date and time
     */
    public function datetime(): string
    {
        return match ($this->getDriver()) {
            'mysql' => 'DATETIME',
            'sqlite' => 'TEXT', // SQLite uses TEXT for date-time types
            'postgresql' => 'TIMESTAMP', // PostgreSQL uses TIMESTAMP for date-time types
            default => 'TIMESTAMP', // Default to TIMESTAMP for unknown drivers
        };
    }


    /**
     * 	A FIXED length string (can contain letters, numbers, and special characters). The size parameter specifies the column length in characters - can be from 0 to 255. Default is 1
     */
    public function varchar(): string
    {
        return match ($this->getDriver()) {
            'mysql' => 'VARCHAR',
            'sqlite' => 'TEXT',
            'postgresql' => 'TEXT',
            default => 'VARCHAR',
        };
    }

    /**
     * A VARIABLE length string (can contain letters, numbers, and special characters). The size parameter specifies the maximum column length in characters - can be from 0 to 65535
     */
    public function char(): string
    {
        return match ($this->getDriver()) {
            'mysql' => 'CHAR',
            'sqlite' => 'TEXT', // SQLite does not have a native CHAR type
            'postgresql' => 'CHAR',
            default => 'CHAR',
        };
    }

    /**
     * Holds a string with a maximum length of 65,535 bytes
     */
    public function text(): string
    {
        return match ($this->getDriver()) {
            'mysql' => 'TEXT',
            'sqlite' => 'TEXT',
            'postgresql' => 'TEXT',
            default => 'TEXT',
        };
    }

    /**
     * Holds a string with a maximum length of 255 characters
     */
    public function tinyText(): string
    {
        return match ($this->getDriver()) {
            'mysql' => 'TINYTEXT',
            'sqlite' => 'TEXT',
            'postgresql' => 'TEXT',
            default => 'TEXT',
        };
    }

    /**
     * Holds a string with a maximum length of 16,777,215 characters
     */
    public function mediumText(): string
    {
        return match ($this->getDriver()) {
            'mysql' => 'MEDIUMTEXT',
            'sqlite' => 'TEXT',
            'postgresql' => 'TEXT',
            default => 'TEXT',
        };
    }

    /**
     * 	Holds a string with a maximum length of 4,294,967,295 characters
     */
    public function longText(): string
    {
        return match ($this->getDriver()) {
            'mysql' => 'LONGTEXT',
            'sqlite' => 'TEXT', // SQLite uses TEXT for large texts
            'postgresql' => 'TEXT',
            default => 'TEXT',
        };
    }

    /**
     * 	For BLOBs (Binary Large OBjects). Holds up to 65,535 bytes of data
     */
    public function blob(): string
    {
        return match ($this->getDriver()) {
            'mysql' => 'BLOB',
            'sqlite' => 'BLOB',
            'postgresql' => 'BYTEA',
            default => 'BLOB',
        };
    }

    /**
     * For BLOBs (Binary Large OBjects). Max length: 255 bytes
     */
    public function tinyBlob(): string
    {
        return match ($this->getDriver()) {
            'mysql' => 'TINYBLOB',
            'sqlite' => 'BLOB',
            'postgresql' => 'BYTEA',
            default => 'BLOB',
        };
    }

    /**
     * For BLOBs (Binary Large OBjects). Holds up to 16,777,215 bytes of data
     */
    public function mediumBlob(): string
    {
        return match ($this->getDriver()) {
            'mysql' => 'MEDIUMBLOB',
            'sqlite' => 'BLOB',
            'postgresql' => 'BYTEA',
            default => 'BLOB',
        };
    }

    /**
     * For BLOBs (Binary Large OBjects). Holds up to 4,294,967,295 bytes of data
     */
    public function longBlob(): string
    {
        return match ($this->getDriver()) {
            'mysql' => 'LONGBLOB',
            'sqlite' => 'BLOB',
            'postgresql' => 'BYTEA',
            default => 'BLOB',
        };
    }

    /**
     * Equal to CHAR(), but stores binary byte strings. The size parameter specifies the column length in bytes. Default is 1
     */
    public function binary(): string
    {
        return match ($this->getDriver()) {
            'mysql' => 'BINARY',
            'sqlite' => 'BLOB', // SQLite does not have a native BINARY type
            'postgresql' => 'BYTEA', // PostgreSQL equivalent to BINARY
            default => 'BLOB', // Default to BLOB for unknown drivers
        };
    }

    /**
     * Equal to VARCHAR(), but stores binary byte strings. The size parameter specifies the maximum column length in bytes.
     */
    public function varBinary(): string
    {
        return match ($this->getDriver()) {
            'mysql' => 'VARBINARY',
            'sqlite' => 'BLOB', // SQLite does not have a native VARBINARY type
            'postgresql' => 'BYTEA', // PostgreSQL equivalent to VARBINARY
            default => 'BLOB', // Default to BLOB for unknown drivers
        };
    }

    /**
     * stores json data
     */
    public function json(): string
    {
        return match ($this->getDriver()) {
            'mysql' => 'JSON',
            'sqlite' => 'JSON',
            'postgresql' => 'JSON',
            default => 'JSON',
        };
    }

    /**
     * MySQL/SQLite does not have a native UUID type
     */
    public function uuid(): string
    {
        return match ($this->getDriver()) {
            'mysql' => 'CHAR(36)', // MySQL does not have a native UUID type
            'sqlite' => 'TEXT', // SQLite can store UUIDs as text
            'postgresql' => 'UUID',
            default => 'TEXT', // Default to TEXT for unknown drivers
        };
    }

    /**
     * A string object that can have only one value, chosen from a list of possible values. You can list up to 65535 values in an ENUM list. If a value is inserted that is not in the list, a blank value will be inserted. The values are sorted in the order you enter them
     */
    public function enum(array $values): string
    {
        if (empty($values)) {
            throw new \InvalidArgumentException('Enum values must not be empty.');
        }

        $enumValues = implode(', ', array_map(fn ($value) => "'$value'", $values));

        return match ($this->getDriver()) {
            'mysql' => "ENUM($enumValues)",
            'sqlite' => 'TEXT', // SQLite does not have a native ENUM type
            'postgresql' => "VARCHAR($enumValues)",
            default => 'TEXT',
        };
    }

    /**
     * A string object that can have 0 or more values, chosen from a list of possible values. You can list up to 64 values in a SET list
     */
    public function set(array $values): string
    {
        if (empty($values)) {
            throw new \InvalidArgumentException('Enum values must not be empty.');
        }

        $enumValues = implode(', ', array_map(fn ($value) => "'$value'", $values));

        return match ($this->getDriver()) {
            'mysql' => "SET($enumValues)",
            'sqlite' => 'TEXT', // SQLite does not have a native SET type
            'postgresql' => "VARCHAR($enumValues)",
            default => 'TEXT',
        };
    }

    /**
     * Call a method by name and return its result.
     *
     * @param string $methodName The name of the method to call.
     * @return mixed The result of the method call.
     */
    public function callMethod(string $methodName)
    {
        if (method_exists($this, $methodName)) {
            // Call the specified method and return its result
            return call_user_func([$this, $methodName]);
        } else {
            // Handle the case where the method does not exist
            throw new \InvalidArgumentException("Method '$methodName' does not exist in " . get_class($this));
        }
    }
}
