<?php

return [
    'templates_path' => 'views',
    'pdo' => [
        'dsn' => 'mysql:host=localhost;port=3306;dbname=db-name;charset=utf8mb4',
        'username' => '',
        'password' => '',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ],
    ]
];