<?php

namespace Filimo\UrlShortener\Support\Http;

use Exception;

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

    public static function load(string $file, $prefix = ''): static
    {
        $router = self::getInstance();
        $router->prefix = $prefix;
        require_once dirname(__FILE__) . "/../../../routes/$file";
        return $router;
    }

    public function define(string $address, array $controller, HttpMethod $method): void
    {
        $this->routes[$method->value][$this->prefix . '/' . trim($address, '/')] = $controller;
    }

    /**
     * @throws Exception
     */
    public static function respond(string $uri, HttpMethod $method)
    {
        $router = self::getInstance();
        if (array_key_exists($method->value, $router->routes)) {
            if (array_key_exists($uri, $router->routes[$method->value])) {
                $data = $router->routes[$method->value][$uri];
                return self::call($data[0], $data[1]);
            }
        }
        throw new Exception('Not route defined for this URI');
    }

    public static function call($controller, $action)
    {

        if (!method_exists($controller, $action)) {
            throw new Exception("$controller does not support $action() action");
        }
        return (new $controller)->$action();
    }
}