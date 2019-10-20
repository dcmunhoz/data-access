<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

define("DATA_ACCESS", [
    "driver"   => "mysql",
    "host"     => "localhost",
    "port"     => "3306",
    "dbname"   => "USERS_EXAMPLE",
    "user"     => "root",
    "password" => "root",
    "options"  => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        
    ]

]);