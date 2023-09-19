<?php

declare(strict_types=1);

namespace Effectra\SqlQuery\Validation;

use Effectra\SqlQuery\Query;

/**
 * Class DataTypeSizeValidation
 *
 * This class is used for validating the size of data types in a database column.
 * It checks whether the provided size is within the allowed range for a specific
 * data type and database driver.
 */
class DataTypeSizeValidation
{

    
    /**
     * DataTypeSizeValidation constructor.
     *
     * @param int    $size     The size to be validated.
     * @param string $dataType The data type for which the size is validated.
     */
    public function __construct(protected int $size, protected string $dataType)
    {
    }

    /**
     * Validate the size against the allowed range for the data type and database driver.
     *
     * @throws \Exception If the size is not within the allowed range.
     */
    public function validate(): void
    {
        if (!$this->check()) {
            throw new \Exception("Error Processing Size: Size is not within the allowed range.");
        }
    }

    /**
     * Check whether the size is within the allowed range for the data type and database driver.
     *
     * @return bool True if the size is within the allowed range, false otherwise.
     */
    public function check(): bool
    {
        if (in_array($this->dataType, array_keys($this->sizes()))) {
            $driver = Query::getDriver();
            $sizes = $this->sizes()[$this->dataType][$driver];
            $min = $sizes['min'];
            $max = $sizes['max'];
            if ($this->size < $min || $this->size > $max) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get the allowed size ranges for various data types and database drivers.
     *
     * @return array An array mapping data types to their allowed size ranges.
     */
    public function sizes(): array
    {
        return [
            'VARCHAR' => [
                'mysql' => ['min' => 0, 'max' => 65535],
                'sqlite' => ['min' => 0, 'max' => 255],
                'postgresql' => ['min' => 0, 'max' => 10485760],
                'default' => ['min' => 0, 'max' => 65535],
            ],
            'CHAR' => [
                'mysql' => ['min' => 1, 'max' => 255],
                'sqlite' => ['min' => 1, 'max' => 255],
                'postgresql' => ['min' => 1, 'max' => 10485760],
                'default' => ['min' => 1, 'max' => 255],
            ],
            'TEXT' => [
                'mysql' => ['min' => 1, 'max' => 65535],
                'sqlite' => ['min' => 1, 'max' => 2147483646],
                'postgresql' => ['min' => 1, 'max' => 1073741824],
                'default' => ['min' => 1, 'max' => 65535],
            ],
            'INTEGER' => [
                'mysql' => ['min' => -2147483648, 'max' => 2147483647],
                'sqlite' => ['min' => -2147483648, 'max' => 2147483647],
                'postgresql' => ['min' => -2147483648, 'max' => 2147483647],
                'default' => ['min' => -2147483648, 'max' => 2147483647],
            ],
            'DATE' => [
                'mysql' => ['min' => '1000-01-01', 'max' => '9999-12-31'],
                'sqlite' => ['min' => '1000-01-01', 'max' => '9999-12-31'],
                'postgresql' => ['min' => '1000-01-01', 'max' => '9999-12-31'],
                'default' => ['min' => '1000-01-01', 'max' => '9999-12-31'],
            ],
            'BINARY' => [
                'mysql' => ['min' => 1, 'max' => 255],
                'sqlite' => ['min' => 1, 'max' => 255],
                'postgresql' => ['min' => 1, 'max' => 10485760],
                'default' => ['min' => 1, 'max' => 255],
            ],
            'VARBINARY' => [
                'mysql' => ['min' => 0, 'max' => 65535],
                'sqlite' => ['min' => 0, 'max' => 255],
                'postgresql' => ['min' => 0, 'max' => 10485760],
                'default' => ['min' => 0, 'max' => 65535],
            ],
            'TINYBLOB' => [
                'mysql' => ['min' => 1, 'max' => 255],
                'sqlite' => ['min' => 1, 'max' => 255],
                'postgresql' => ['min' => 1, 'max' => 10485760],
                'default' => ['min' => 1, 'max' => 255],
            ],
            'TINYTEXT' => [
                'mysql' => ['min' => 1, 'max' => 255],
                'sqlite' => ['min' => 1, 'max' => 255],
                'postgresql' => ['min' => 1, 'max' => 10485760],
                'default' => ['min' => 1, 'max' => 255],
            ],
            'BLOB' => [
                'mysql' => ['min' => 0, 'max' => 65535],
                'sqlite' => ['min' => 0, 'max' => 255],
                'postgresql' => ['min' => 0, 'max' => 10485760],
                'default' => ['min' => 0, 'max' => 65535],
            ],
            'MEDIUMTEXT' => [
                'mysql' => ['min' => 0, 'max' => 16777215],
                'sqlite' => ['min' => 0, 'max' => 16777215],
                'postgresql' => ['min' => 0, 'max' => 16777215],
                'default' => ['min' => 0, 'max' => 16777215],
            ],
            'MEDIUMBLOB' => [
                'mysql' => ['min' => 0, 'max' => 16777215],
                'sqlite' => ['min' => 0, 'max' => 16777215],
                'postgresql' => ['min' => 0, 'max' => 16777215],
                'default' => ['min' => 0, 'max' => 16777215],
            ],
            'LONGTEXT' => [
                'mysql' => ['min' => 0, 'max' => 4294967295],
                'sqlite' => ['min' => 0, 'max' => 4294967295],
                'postgresql' => ['min' => 0, 'max' => 4294967295],
                'default' => ['min' => 0, 'max' => 4294967295],
            ],
            'LONGBLOB' => [
                'mysql' => ['min' => 0, 'max' => 4294967295],
                'sqlite' => ['min' => 0, 'max' => 4294967295],
                'postgresql' => ['min' => 0, 'max' => 4294967295],
                'default' => ['min' => 0, 'max' => 4294967295],
            ],
            
        ];
    }
}
