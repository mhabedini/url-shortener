<?php

use Filimo\UrlShortener\Support\Http\Router;


require_once dirname(__FILE__) . '/../vendor/autoload.php';
require_once dirname(__FILE__) . '/../config/database.php';
Router::load('api.php', 'api');

// $pdo = Connection::make($database);
// $query = new Builder($pdo);