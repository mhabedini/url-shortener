<?php

use Filimo\UrlShortener\Support\App;


require_once dirname(__FILE__) . '/../vendor/autoload.php';
require_once dirname(__FILE__) . '/../config/database.php';

$app = App::create(dirname(__DIR__));