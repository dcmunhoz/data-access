# Data Access
_Data Access is a library designed to manipulate databases_

---
## Highlights
* Easy installation;
* RAW queries execution;

## Installation
On your prompt use the following command:
```bash
composer require dcmunhoz/data-access
```

## Connection
To beegin, you need to connect to the database (MySQL / Postgress), check for more databases connections [Here](https://www.php.net/manual/pt_BR/pdo.drivers.php).

Define the following configuration constant:
```php
define("DATA_ACCESS", [
  "driver"   => "mysql",
  "host"     => "localhost",
  "port"     => "3306",
  "dbname"   => "DATA_ACCESS_EXAMPLE",
  "user"     => "root",
  "password" => "",
  "options"  => [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
  ]
]);
```

#### Your model
In your controller you can extends data-access or create an object.
```php
/**
 * User controller example
 */
class UserController extends DataAccess{
  
    /**
     * User Constructor
     */
    function __construct(){
        parent::__construct("TB_USERS", "ID_USER");
    }
}
```

#### RAW execution
RAW executions allows you to execute whatever query you want.

```php
$user = new UserController();

$result = $user->raw("INSERT INTO TB_USERS(USER_NAME, PASSW, ID_PROFILE) VALUES(:uname, :upass, :pid)", [
    ":uname" => "user25",
    ":upass" => "mysupersecretpassword",
    ":pid" => '1'
]);
```
On INSERT, UPDATE or DELETE statement, RAW execution will return true in case of success or false if query fails.

On SELECT statement it will return an array with all found records.

