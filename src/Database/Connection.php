<?php

namespace Filimo\UrlShortener\Database;

use PDO;

class Connection
{
    public static function make(): PDO
    {
        $connection = config('database.connection');
        $host = config('database.host');
        $database = config('database.database');
        $username = config('database.username');
        $password = config('database.password');

        return new PDO("$connection:host=$host;dbname=$database", $username, $password, [PDO::ERRMODE_EXCEPTION]);
    }
}