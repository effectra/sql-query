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


// Select statement
$query = Query::select('users')->columns(['id','email','password'])->where(['id' => 9841]);

// Print the SQL query
echo $query;

//output
//  SELECT id, email, password FROM users WHERE id = 9841 
```

### Table Example

```php
use Effectra\SqlQuery\Table;
use Effectra\SqlQuery\Charset;
use Effectra\SqlQuery\Driver;
use Effectra\SqlQuery\Engine;

Query::driver(Driver::MySQL);

Query::createTable('users', function (Table $table) {
    $table->autoIncrement();
    $table->username()->unique();
    $table->email()->unique();
    $table->timestamps();
})->engine(Engine::MYSQL_InnoDB)->charset(Charset::MySQL_utf8mb4);


```
output: 
```sql
CREATE TABLE users ( 
    id BIGINT NOT NULL AUTO_INCREMENT , 
    username VARCHAR (50) NOT NULL UNIQUE CHECK (username REGEXP '^[a-zA-Z0-9_]+$'), 
    email VARCHAR (255) NOT NULL UNIQUE CHECK (email REGEXP '^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$'), 
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP , 
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4_0900_ai_ci
```

## License

This package is open-source and available under the [MIT License](https://opensource.org/licenses/MIT).