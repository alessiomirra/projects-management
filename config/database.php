<?php 

return [
    'driver' => 'mysql', 
    'host' => 'localhost:3306', 
    'user' => 'root', 
    'password' => '26623881', 
    'database' => 'project', 
    'charset' => 'utf8',
    //'dsn' => 'mysql:host=localhost:3306;dbname=freeblog;charset=utf8',
    //          mysql:host=localhost:3306;dbname=freeblog:host=localhost:3306;charset=utf8
    'pdooptions' => [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]
];