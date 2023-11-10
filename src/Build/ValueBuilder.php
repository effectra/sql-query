<?php

declare(strict_types=1);

namespace Effectra\SqlQuery\Build;

use Effectra\SqlQuery\Syntax;

/**
 *
 * Provides methods to handle and convert different types of values for SQL queries.
 */
class ValueBuilder
{
    /**
     * Constructor.
     *
     * @param array $values Array of values to be processed.
     */
    public function __construct(
        protected array $values
    ) {
    }

    /**
     * Define types and convert values for SQL usage.
     *
     * @return array Array containing values and their converted types.
     */
    public function defineType(): array
    {
        $result = [];

        foreach ($this->values as $value) {

            if ($this->hasTypeAsString($value)) {
                $value = $this->convertStringType($value);
            } elseif ($this->isDate($value)) {
                $value = $this->convertDateFormat($value);
            } elseif ($this->isTime($value)) {
                $value = $this->convertTimeFormat($value);
            } elseif ($this->isDateTime($value)) {
                $value = $this->convertDateTimeFormat($value);
            } elseif ($this->isNumericString($value)) {
                $value = $this->convertToNumeric($value);
            } elseif ($this->isFile($value)) {
                $value = $this->convertFileToBlob($value);
            } elseif ($this->isHexString($value)) {
                $value = $this->convertHexToBinary($value);
            }

            $result[] = [
                'value' => $value,
                'type' => strtolower(gettype($value))
            ];
        }

        return $result;
    }

    /**
     * Convert string representations of boolean, null, or true/false to their respective types.
     *
     * @param string $value String value to convert.
     * @return mixed Converted value.
     */
    public function convertStringType(string $value): mixed
    {
        return match (strtolower($value)) {
            'true' => true,
            'false' => false,
            'null' => null,
        };
    }

    /**
     * Check if a value is a string representation of boolean, null, or true/false.
     *
     * @param mixed $value Value to check.
     * @return bool Whether the value is a string representation of boolean, null, or true/false.
     */
    public function hasTypeAsString($value): bool
    {
        return is_string($value) && in_array(strtolower($value), ['null', 'true', 'false']);
    }

    /**
     * Check if a value is a valid date representation.
     *
     * @param mixed $value Value to check.
     * @return bool Whether the value is a valid date representation.
     */
    public function isDate($value): bool
    {
        if (!is_string($value)) {
            return false;
        }
        $dateFormatsToCheck = [
            'Y/m/d', 'm/d/Y', 'Y/d/m',
            'Y-m-d', 'm-d-Y', 'Y-d-m',
        ]; // Add more formats as needed
        foreach ($dateFormatsToCheck as $format) {
            $dateTime = \DateTime::createFromFormat($format, $value);
            if ($dateTime instanceof \DateTime && $dateTime->format($format) === $value) {
                return true;
            }
        }
        return false;
    }

    /**
     * Convert a date representation to SQL date format.
     *
     * @param mixed $value Date representation.
     * @return string SQL-formatted date.
     */
    public function convertDateFormat($value): string
    {
        $dateTime = new \DateTime($value);
        return $dateTime->format('Y-m-d');
    }

    /**
     * Check if a value is a valid time representation.
     *
     * @param mixed $value Value to check.
     * @return bool Whether the value is a valid time representation.
     */
    public function isTime($value): bool
    {
        if (!is_string($value)) {
            return false;
        }
        $timeFormatsToCheck = ['H:i:s', 'g:i A', 'H.i.s']; // Add more formats as needed
        foreach ($timeFormatsToCheck as $format) {
            $dateTime = \DateTime::createFromFormat($format, $value);
            if ($dateTime instanceof \DateTime && $dateTime->format($format) === $value) {
                return true;
            }
        }
        return false;
    }

    /**
     * Convert a time representation to SQL time format.
     *
     * @param mixed $value Time representation.
     * @return string SQL-formatted time.
     */
    public function convertTimeFormat($value): string
    {
        $dateTime = new \DateTime($value);
        return $dateTime->format('H:i:s');
    }

    /**
     * Check if a value is a valid date and time representation.
     *
     * @param mixed $value Value to check.
     * @return bool Whether the value is a valid date and time representation.
     */
    public function isDateTime($value): bool
    {
        if (!is_string($value)) {
            return false;
        }
        $timeFormatsToCheck = [
            'Y-m-d H:i:s', 'Y-d-m H:i:s', 'd-m-Y H:i:s', 'Y-m-d g:i A',
            'Y/m/d H:i:s', 'Y/d/m H:i:s', 'd/m/Y H:i:s', 'Y/m/d g:i A',
        ]; // Add more formats as needed
        foreach ($timeFormatsToCheck as $format) {
            $dateTime = \DateTime::createFromFormat($format, $value);
            if ($dateTime instanceof \DateTime && $dateTime->format($format) === $value) {
                return true;
            }
        }
        return false;
    }

    /**
     * Convert a date and time representation to SQL date and time format.
     *
     * @param mixed $value Date and time representation.
     * @return string SQL-formatted date and time.
     */
    public function convertDateTimeFormat($value): string
    {
        $dateTime = new \DateTime($value);
        return $dateTime->format('Y-m-d H:i:s');
    }

    /**
     * Check if a value is a numeric string.
     *
     * @param mixed $value Value to check.
     * @return bool Whether the value is a numeric string.
     */
    public function isNumericString($value): bool
    {
        if (!is_string($value)) {
            return false;
        }
        return preg_match('/^-?\d+(\.\d+)?$/', $value) === 1;
    }

    /**
     * Convert a numeric string to numeric (int or float) type.
     *
     * @param mixed $value Numeric string.
     * @return float|int Converted numeric value.
     */
    public function convertToNumeric($value): float|int
    {
        return strpos($value, '.') !== false ? (float) $value : (int) $value;
    }

    /**
     * Check if a value is a valid file path.
     *
     * @param mixed $value Value to check.
     * @return bool Whether the value is a valid file path.
     */
    public function isFile($value): bool
    {
        if (!is_string($value)) {
            return false;
        }
        return file_exists($value);
    }

    /**
     * Convert a file to a BLOB representation.
     *
     * @param mixed $value File path.
     * @return string BLOB representation of the file contents.
     */
    public function convertFileToBlob($value): string
    {
        if ($this->isFile($value)) {
            return file_get_contents($value);
        }
        return '';
    }

    /**
     * Check if a value is a valid hexadecimal string.
     *
     * @param mixed $value Value to check.
     * @return bool Whether the value is a valid hexadecimal string.
     */
    public function isHexString($value): bool
    {
        if (!is_string($value)) {
            return false;
        }
        return preg_match('/^0x[0-9a-fA-F]+$/', $value) === 1;
    }

    /**
     * Convert a hexadecimal string to binary.
     *
     * @param string $hexValue Hexadecimal value.
     * @return string Binary representation of the hexadecimal value.
     */
    public function convertHexToBinary($hexValue): string
    {
        return base_convert($hexValue, 16, 2);
    }

    /**
     * Convert a binary value to hexadecimal.
     *
     * @param string $binaryValue Binary value.
     * @return string Hexadecimal representation of the binary value.
     */
    public function convertBinaryToHex($binaryValue): string
    {
        return '0x' . base_convert($binaryValue, 2, 16);
    }

    public function buildString($value)
    {
        if (strpos($value, ':')) {
            return $value;
        }
        if ($value === '?') {
            return $value;
        }
        if (in_array($value,  array_values((new Syntax())->dateFunctions()))) {
            return $value;
        }

        $value = trim($value, "'");
        return sprintf("'%s'", $value);
    }

    /**
     * Build an array of formatted values for SQL usage.
     *
     * @return array Array of formatted values.
     */
    public function build(): array
    {
        $formattedValues = [];
        foreach ($this->defineType() as $value) {
            $formattedValues[] = match ($value['type']) {
                //handle string or SQL Date Functions
                'string' => $this->buildString($value['value']),
                //handle array as json
                'array' => "'" . json_encode($value['value']) . "'",
                //handle object as json
                'object' => "'" .  json_encode($value['value']) . "'",
                //handle int 
                'integer' => "{$value['value']}",
                //handle float 
                'float' => "{$value['value']}",
                //handle null 
                'null' => 'NULL',
                //handle boolean 
                'boolean' => $value['value'] === true ? 'TRUE' : 'FALSE',
            };
        }

        return $formattedValues;
    }

    /**
     * Get formatted values as a single-line string.
     *
     * @return string Formatted values as a single-line string.
     */
    public function getAsOneLine()
    {
        return implode(', ', $this->build());
    }

    /**
     * Get values as parameter assignments for SQL usage.
     *
     * @param array $cols Array of column names.
     * @return string Formatted parameter assignments.
     * @throws \Exception If the number of columns doesn't match the number of values.
     */
    public function getAsParams(array $cols)
    {
        $syntax = [];

        // Check if the number of columns matches the number of values
        if (count($cols) !== count($this->build())) {
            throw new \Exception("Number of columns doesn't match number of values.");
        }

        // Combine columns and values into an associative array
        $data = array_combine($cols, $this->build());

        // Iterate through the combined data
        foreach ($data as $key => $value) {
            // Create a string in the format 'column = value'
            $syntax[] = "$key = $value";
        }

        // Combine the generated syntax strings using commas
        return implode(', ', $syntax);
    }
}
