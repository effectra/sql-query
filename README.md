# Effectra SqlQuery

Effectra/SqlQuery is a powerful database manipulation package for PHP.

## Installation

You can install this package via Composer. Run the following command:

```bash
composer require effectra/sql-query
```

## Usage

### Query Example

```php
use Effectra\SqlQuery\Query;

// Create a new query object
$query = new Query('users');

// Select statement
$query->select('name', 'email')
    ->where('age', '>', 18)
    ->orderBy('name')
    ->limit(10);

// Execute the query
$results = $query->execute();

// Process the results
foreach ($results as $result) {
    echo $result['name'] . ' - ' . $result['email'] . PHP_EOL;
}
```

### Table Example

```php
use Effectra\SqlQuery\Table;

// Create a new table object
$table = new Table('users');

// Add columns to the table
$table->integer('id')->primaryKey()->autoIncrement();
$table->string('name')->nullable();
$table->string('email')->unique();
$table->timestamp('created_at')->useCurrentTime();

// Generate the SQL query for creating the table
$query = $table->buildQuery();

// Print the SQL query
echo $query;
```

## License

This package is open-source and available under the [MIT License](https://opensource.org/licenses/MIT).