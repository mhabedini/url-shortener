<?php

namespace Filimo\UrlShortener\Database;

use PDO;

class Connection
{
    public static function make($configs)
    {
        $connection = $configs['connection'];
        $host = $configs['host'];
        $database = $configs['database'];
        $username = $configs['username'];
        $password = $configs['password'];

        return new PDO("$connection:host=$host;dbname:$database;", $username, $password, [PDO::ERRMODE_EXCEPTION]);

    }
}