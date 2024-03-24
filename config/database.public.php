<?php 

/**
* This is a sample file to show how to config database connection
* Link this file in public/index.php   
*/

return [
    'driver' => 'mysql', 
    'host' => 'localhost:3306', 
    'user' => 'databaseUser', 
    'password' => 'password', 
    'database' => 'databaseName', 
    'charset' => 'utf8',
    'pdooptions' => [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]
];