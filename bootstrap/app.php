<?php

use Mhabedini\UrlShortener\Support\App;


require_once dirname(__DIR__) . '/vendor/autoload.php';

$app = App::create(dirname(__DIR__));
return $app;