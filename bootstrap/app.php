<?php

use Filimo\UrlShortener\Database\Connection;
use Filimo\UrlShortener\Database\Query\Builder;
use Filimo\UrlShortener\Support\Http\Router;


require_once dirname(__FILE__) . '/../vendor/autoload.php';
require dirname(__FILE__) . '/../config/database.php';
Router::load('api.php', 'api');

// $pdo = Connection::make($database);
// $query = new Builder($pdo);

return null;