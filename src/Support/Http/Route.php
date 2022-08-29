<?php

namespace Filimo\UrlShortener\Support\Http;

class Route
{
    public static function get(string $url, array $controller): void
    {
        Router::getInstance()->define($url, $controller, HttpMethod::GET);
    }

    public static function post(string $url, array $controller): void
    {
        Router::getInstance()->define($url, $controller, HttpMethod::POST);
    }

    public static function patch(string $url, array $controller): void
    {
        Router::getInstance()->define($url, $controller, HttpMethod::PATCH);
    }

    public static function delete(string $url, array $controller): void
    {
        Router::getInstance()->define($url, $controller, HttpMethod::DELETE);
    }
}