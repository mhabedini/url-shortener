<?php

return [
    'connection' => environment('DB_CONNECTION', 'mysql'),
    'host' => environment('DB_HOST', '127.0.0.1'),
    'port' => environment('DB_PORT', '3306'),
    'database' => environment('DB_DATABASE', 'database'),
    'username' => environment('DB_USERNAME', 'root'),
    'password' => environment('DB_PASSWORD', ''),
];