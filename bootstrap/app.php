<?php

require_once dirname(__FILE__) . '/../vendor/autoload.php';

$config = require  dirname(__FILE__) .'/../config/app.php';
$database = require dirname(__FILE__) . '/../config/database.php';

use Filimo\UrlShortener\Database\Connection;
use Filimo\UrlShortener\Database\Query\Builder;

$pdo = Connection::make($database);
$query = new Builder($pdo);

return null;