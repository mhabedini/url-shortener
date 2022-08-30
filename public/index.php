<?php


use Filimo\UrlShortener\Support\Http\HttpMethod;
use Filimo\UrlShortener\Support\Http\Router;

$app = require_once __DIR__ . '/../bootstrap/app.php';

$requestUri = $_SERVER['REQUEST_URI'];
$uri = trim(parse_url($requestUri, PHP_URL_PATH), '/');
$data = $_REQUEST;
$httpMethod = HttpMethod::from($_SERVER['REQUEST_METHOD']);

echo Router::respond($uri, $httpMethod);

$app->terminate();