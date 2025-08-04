<?php 

return [
    'host' => 'localhost',
    'database' => 'blog',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8mb4',
    'options' => [
        3 => 2, // PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        19 => 2, // PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        20 => false, // PDO::ATTR_EMULATE_PREPARES => false
        1002 => "SET NAMES utf8mb4" // PDO::MYSQL_ATTR_INIT_COMMAND
    ]
];