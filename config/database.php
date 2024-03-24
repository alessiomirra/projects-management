<?php 

return [
    'driver' => 'mysql', 
    'host' => 'localhost:3306', 
    'user' => 'root', 
    'password' => 'Password', 
    'database' => 'project', 
    'charset' => 'utf8',
    'pdooptions' => [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]
];
