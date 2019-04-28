<?php
/*
return [
    'DB_HOST' => getenv('DB_HOST', '127.0.0.1'),
    "DB_NAME" => getenv('DB_NAME', ''),

];

*/
return [
    'type' => 'mysql',
    'host' => getenv('DB_HOST', '127.0.0.1'),
    'dbname' => getenv('DB_NAME', 'social'),
    'charset' => 'utf8',
    'user' => getenv('DB_USER', 'root'),
    'pass' => getenv('DB_PASS', 'root')
];
