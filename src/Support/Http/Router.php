<?php

namespace Filimo\UrlShortener\Support\Http;

use Exception;
use ReflectionMethod;

class Router
{

    protected static ?Router $instance = null;
    protected array $routes = [];
    protected string $prefix = '';

    private function __construct()
    {
    }

    public static function getInstance(): static
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    public static function load(string $file, string $basePath, $prefix = ''): static
    {
        $router = self::getInstance();
        $router->setPrefix($prefix);
        require_once $basePath . "/routes/$file";
        return $router;
    }

    public function setPrefix(string $prefix): void
    {
        $prefix = trim($prefix, '/');
        $this->prefix = $prefix;
    }

    public function define(string $address, array $controller, HttpMethod $method): void
    {
        $address = $this->prefix . '/' . trim($address, '/');
        $this->routes[$method->value][$address] = $controller;
        $this->routes[$method->value][$address]['url_parts'] = explode('/', $address);
    }

    /**
     * @throws Exception
     */
    public static function respond(string $uri, HttpMethod $method)
    {
        $uri = trim($uri, '/');
        $uriParts = explode('/', $uri);
        $router = self::getInstance();
        if (array_key_exists($method->value, $router->routes)) {
            $routes = array_filter($router->routes[$method->value], function ($value) use ($uriParts) {
                return count($value['url_parts']) === count($uriParts);
            });

            $parameters = [];
            foreach ($routes as $route) {
                $routeParts = $route['url_parts'];
                for ($i = 0; $i < count($routeParts); $i++) {
                    if (str_starts_with($routeParts[$i], '{') && str_ends_with($routeParts[$i], '}')) {
                        $parameters = array_merge($parameters, [
                            ltrim(rtrim($routeParts[$i], '}'), '{') => $uriParts[$i]
                        ]);
                    } elseif ($routeParts[$i] != $uriParts[$i]) {
                        continue 2;
                    }
                }
                return self::call($route[0], $route[1], $parameters);
            }
        }
        throw new Exception('Not route defined for this URI');
    }

    public static function call($controller, $action, $parameters)
    {
        if (!method_exists($controller, $action)) {
            throw new Exception("$controller does not support $action() action");
        }
        $method = new ReflectionMethod($controller, $action);

        foreach ($method->getParameters() as $parameter) {
            if ($parameter?->getType()?->getName() === Request::class) {
                $parameters = array_merge($parameters, [
                    $parameter->getName() => request(),
                ]);
            }
        }

        return (new $controller)->$action(...$parameters);
    }
}