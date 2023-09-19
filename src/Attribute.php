<?php

declare(strict_types=1);

namespace Effectra\SqlQuery;

/**
 * Class Attribute
 *
 * A class for managing attributes.
 */
class Attribute
{
    /**
     * @var array An array to store attributes.
     */
    protected array $attributes = [];

    /**
     * Set a specific attribute to a given value.
     *
     * @param string $attribute The name of the attribute.
     * @param mixed $value The value to set for the attribute.
     */
    public function setAttribute(string $attribute, $value): void
    {
        $this->attributes[$attribute] = $value;
    }

    /**
     * Set multiple attributes using an associative array.
     *
     * @param array $attributes An associative array of attributes and their values.
     */
    public function setAttributes(array $attributes): void
    {
        $this->attributes = $attributes;
    }

    /**
     * Merge the current attributes with an array of attributes.
     *
     * @param array $attributes An associative array of attributes to merge.
     */
    public function mergeAttribute(array $attributes): void
    {
        $this->attributes = $this->attributes + $attributes;
    }

    /**
     * Add a value to an attribute that is an array.
     *
     * @param string $attribute The name of the attribute.
     * @param mixed $value The value to add to the attribute (should be an array).
     */
    public function addToAttribute(string $attribute, $value): void
    {
        $this->attributes[$attribute][] = $value;
    }

    /**
     * Get all attributes as an associative array.
     *
     * @return array An associative array of attributes and their values.
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * Get the value of a specific attribute.
     *
     * @param string $attribute The name of the attribute.
     * @return mixed|null The value of the attribute or null if it doesn't exist.
     */
    public function getAttribute(string $attribute)
    {
        return $this->attributes[$attribute] ?? null;
    }

    /**
     * Check if a specific attribute exists.
     *
     * @param string $attribute The name of the attribute to check.
     * @return bool True if the attribute exists, false otherwise.
     */
    public function hasAttribute(string $attribute): bool
    {
        return isset($this->attributes[$attribute]);
    }

    /**
     * Remove a specific item from an attribute array.
     *
     * @param string $attribute The attribute name.
     * @param mixed $itemCleared The item to be removed.
     * @return void
     */
    public function clearFromAttribute($attribute, $itemCleared): void
    {
        $new_attribute = array_values(array_filter($this->getAttribute($attribute), fn ($item) => $item !== $itemCleared));
        $this->setAttribute($attribute, $new_attribute);
    }
}
