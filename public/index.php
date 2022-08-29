<?php


use Filimo\UrlShortener\Support\Http\HttpMethod;
use Filimo\UrlShortener\Support\Http\Router;

require_once __DIR__ . '/../bootstrap/app.php';

$requestUri = $_SERVER['REQUEST_URI'];
$uri = trim(parse_url($requestUri, PHP_URL_PATH), '/');
$data = $_REQUEST;
$httpMethod = HttpMethod::from($_SERVER['REQUEST_METHOD']);
$directController = Router::direct($uri, $httpMethod);
$class = new $directController[0];
$method = $directController[1];
echo $class->$method();