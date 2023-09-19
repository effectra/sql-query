<?php

declare(strict_types=1);

namespace Effectra\SqlQuery\Validation;

/**
 * Trait ArraysValidation
 *
 * A trait providing array validation methods for checking the structure of arrays.
 *
 * @package Effectra\SqlQuery\Validation
 */
trait ArraysValidation
{

    /**
     * Check if an array is an associative array.
     *
     * @param mixed $data The array to check.
     *
     * @return bool True if the array is associative, false otherwise.
     * @throws \Exception If the provided data does not match the expected structure.
     */
    private function isAssociativeData($data)
    {
        if (!is_array($data)) {
            throw new \Exception("data is not an array.");
        }

        if (count($data) === 0) {
            throw new \Exception("data is empty.");
        }

        $firstItem = reset($data);

        if (is_array($firstItem) && count($firstItem) > 0) {
            return false; // Array of items
        } elseif (is_string(key($data)) && is_scalar($firstItem)) {
            return true; // Associative array
        }

        throw new \Exception("data does not match the expected structure.");
    }

    /**
     * Check if an array is an associative array.
     *
     * @param mixed $data The array to check.
     *
     * @return bool True if the array is associative, false otherwise.
     * @throws \Exception If the provided data does not match the expected structure.
     */
    private function isAssociative($data)
    {
        if (!is_array($data)) {
            throw new \Exception("data is not an array.");
        }

        if (count($data) === 0) {
            throw new \Exception("data is empty.");
        }

        $firstItem = reset($data);

        if (is_array($firstItem) && count($firstItem) > 0) {
            return false; // Array of items
        } elseif (is_string(key($data)) && is_scalar($firstItem)) {
            return true; // Associative array
        }

        throw new \Exception("data does not match the expected structure.");
    }

    /**
     * Check if an array of arrays has the same keys in all sub-arrays.
     *
     * @param array $arrayOfArrays The array of arrays to check.
     *
     * @return bool True if all sub-arrays have the same keys, false otherwise.
     */
    public function hasSameKeys(array $arrayOfArrays): bool
    {
        if (count($arrayOfArrays) === 0) {
            return true;
        }

        $keys = array_keys(reset($arrayOfArrays));

        foreach ($arrayOfArrays as $item) {
            if (array_keys($item) !== $keys) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check if an array is an array of arrays.
     *
     * @param array $array The array to check.
     *
     * @return bool True if the array is an array of arrays, false otherwise.
     */
    public function isArrayOfArrays(array $array): bool
    {
        if (empty($array)) {
            return false; // If the array is empty, it's not an array of arrays.
        }

        foreach ($array as $element) {
            if (!is_array($element)) {
                return false; // If any element is not an array, it's not an array of arrays.
            }
        }

        return true; // If all elements are arrays, it's an array of arrays.
    }
}
