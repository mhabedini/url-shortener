<?php


use Filimo\UrlShortener\Support\Http\HttpMethod;
use Filimo\UrlShortener\Support\Http\Router;

require_once __DIR__ . '/../bootstrap/app.php';

$uri = trim($_SERVER['REQUEST_URI'], '/');
$httpMethod = HttpMethod::from($_SERVER['REQUEST_METHOD']);
$directController = Router::direct($uri, $httpMethod);
$class = new $directController[0];
$method = $directController[1];
echo $class->$method();