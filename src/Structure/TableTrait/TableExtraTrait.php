<?php

declare(strict_types=1);

namespace Effectra\SqlQuery\Structure\TableTrait;

use Effectra\SqlQuery\Structure\Column;

trait TableExtraTrait
{

    /**
     * Define an IP address column with custom CHECK constraint.
     *
     * @param string $column_name The name of the column.
     * @return self
     */
    public function ip(string $column_name = 'id'): self
    {
        $col = new Column($column_name);
        $col->varchar()->size(25)->check("
            $column_name REGEXP '^(?:[0-9]{1,3}\.){3}[0-9]{1,3}$' OR
            $column_name REGEXP '^([0-9a-fA-F]{1,4}:){7}[0-9a-fA-F]{1,4}$'
        ");
        $this->addToAttribute('cols', $col->getAttributes());
        return $this;
    }

    /**
     * Define an email column with custom CHECK constraint.
     *
     * @param string $column_name The name of the column.
     * @return self
     */
    public function email(string $column_name = 'email'): self
    {
        $col = new Column($column_name);
        $col->varchar()->size(255)->check("$column_name REGEXP '^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,}$'");
        $this->addToAttribute('cols', $col->getAttributes());
        return $this;
    }

    /**
     * Define a phone number column with custom CHECK constraint.
     *
     * @param string $column_name The name of the column.
     * @return self
     */
    public function phone(string $column_name = 'phone'): self
    {
        $col = new Column($column_name);
        $col->varchar()->size(20)->check("$column_name REGEXP '^[0-9]{10}$'");
        $this->addToAttribute('cols', $col->getAttributes());
        return $this;
    }

    /**
     * Define a URL column with custom CHECK constraint.
     *
     * @param string $column_name The name of the column.
     * @return self
     */
    public function url(string $column_name = 'url'): self
    {
        $col = new Column($column_name);
        $col->varchar()->size(255)->check("$column_name REGEXP '^(http|https)://[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,}(/\\S*)?$'");
        $this->addToAttribute('cols', $col->getAttributes());
        return $this;
    }


    /**
     * Define a username column with custom CHECK constraint.
     *
     * @param string $column_name The name of the column.
     * @return self
     */
    public function username(string $column_name = 'username'): self
    {
        $col = new Column($column_name);
        $col->varchar()->size(50)->check("$column_name REGEXP '^[a-zA-Z0-9_]+$'");
        $this->addToAttribute('cols', $col->getAttributes());
        return $this;
    }

    /**
     * Define a password column.
     *
     * @param string $column_name The name of the column.
     * @return self
     */
    public function password(string $column_name = 'password'): self
    {
        $col = new Column($column_name);
        $col->varchar()->size(255); // You can add additional password constraints here
        $this->addToAttribute('cols', $col->getAttributes());
        return $this;
    }

    /**
     * Define a credit card column with custom CHECK constraint.
     *
     * @param string $column_name The name of the column.
     * @return self
     */
    public function creditCard(string $column_name = 'credit_card'): self
    {
        $col = new Column($column_name);
        $col->varchar()->size(20)->check("$column_name REGEXP '^[0-9]{13,19}$'");
        $this->addToAttribute('cols', $col->getAttributes());
        return $this;
    }

    /**
     * Define a slug column with custom CHECK constraint.
     *
     * @param string $column_name The name of the column.
     * @return self
     */
    public function slug(string $column_name = 'slug'): self
    {
        $col = new Column($column_name);
        $col->varchar()->size(100)->check("$column_name REGEXP '^[a-z0-9-]+$'");
        $this->addToAttribute('cols', $col->getAttributes());
        return $this;
    }
}
