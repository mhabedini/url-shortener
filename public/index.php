<?php


use Mhabedini\UrlShortener\Support\Http\HttpMethod;
use Mhabedini\UrlShortener\Support\Http\Router;

$app = require_once __DIR__ . '/../bootstrap/app.php';

$requestUri = $_SERVER['REQUEST_URI'];
$uri = trim(parse_url($requestUri, PHP_URL_PATH), '/');
$data = $_REQUEST;
$httpMethod = HttpMethod::from($_SERVER['REQUEST_METHOD']);

try {
    echo Router::respond($uri, $httpMethod);
} catch (\Mhabedini\UrlShortener\Exception\HttpException $exception) {
    if (environment('APP_DEBUG')) {
        throw $exception;
    }
    echo apiResponse(["error" => $exception->getErrorMessage()], $exception->getCode());
} catch (\Exception $exception) {
    if (environment('APP_DEBUG')) {
        throw $exception;
    }
    echo apiResponse(["error" => $exception->getMessage()], 500);
}

$app->terminate();