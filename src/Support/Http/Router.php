<?php

namespace Filimo\UrlShortener\Support\Http;

use Exception;

class Router
{

    protected static ?Router $instance = null;
    protected array $routes = [];

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

    public function define(string $address, array $controller, HttpMethod $method): void
    {
        $this->routes[$method->value][trim($address, '/')] = $controller;
    }

    /**
     * @throws Exception
     */
    public function direct(string $uri, HttpMethod $method)
    {
        if (array_key_exists($method->value, $this->routes)) {
            if (array_key_exists($uri, $this->routes[$method->value])) {
                return $this->routes[$method->value][$uri];
            }
        }
        throw new Exception('Not route defined for this URI');
    }
}