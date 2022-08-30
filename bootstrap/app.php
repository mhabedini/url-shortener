<?php

use Filimo\UrlShortener\Support\App;


require_once dirname(__DIR__) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '/config/database.php';

$repository = Dotenv\Repository\RepositoryBuilder::createWithNoAdapters()
    ->addAdapter(Dotenv\Repository\Adapter\EnvConstAdapter::class)
    ->addWriter(Dotenv\Repository\Adapter\PutenvAdapter::class)
    ->immutable()
    ->make();

$dotenv = Dotenv\Dotenv::create($repository, __DIR__ . '/../');
$dotenv->load();

$app = App::create(dirname(__DIR__));