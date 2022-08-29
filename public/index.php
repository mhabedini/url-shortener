<?php


use Filimo\UrlShortener\Support\Http\HttpMethod;
use Filimo\UrlShortener\Support\Http\Router;

require_once dirname(__FILE__) . '/../bootstrap/app.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

require dirname(__FILE__) . '/../routes/api.php';

$uri = trim($_SERVER['REQUEST_URI'], '/');
$httpMethod = HttpMethod::from($_SERVER['REQUEST_METHOD']);
$directController = Router::getInstance()->direct($uri, $httpMethod);
$class = new $directController[0];
$method = $directController[1];
echo $class->$method();