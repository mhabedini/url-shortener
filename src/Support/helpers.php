<?php


use Filimo\UrlShortener\Support\App;
use Filimo\UrlShortener\Support\Env;

if (!function_exists('env')) {
    /**
     * Gets the value of an environment variable.
     *
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    function env(string $key, mixed $default = null): mixed
    {
        return Env::get($key, $default);
    }
}

if (!function_exists('app')) {
    /**
     * @return App|null
     */
    function app(): ?App
    {
        return App::getInstance();
    }
}

if (!function_exists('config')) {
    /**
     * @param string $key
     * @param string|null $default
     * @return array|mixed
     */
    function config(string $key, ?string $default = null): mixed
    {
        return App::getInstance()->getConfig($key, $default);
    }
}
