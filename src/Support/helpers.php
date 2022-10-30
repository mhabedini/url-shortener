<?php


use Mhabedini\UrlShortener\Support\App;
use Mhabedini\UrlShortener\Support\Env;
use Mhabedini\UrlShortener\Support\Http\Request;
use JetBrains\PhpStorm\NoReturn;

if (!function_exists('environment')) {
    /**
     * Gets the value of an environment variable.
     *
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    function environment(string $key, mixed $default = null): mixed
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

if (!function_exists('preg_array_key_exists')) {
    function preg_array_key_exists($pattern, $array): bool
    {
        $keys = array_keys($array);
        foreach ($keys as $key) {
            if (preg_grep($key, $pattern)) {
                return true;
            }
        }
        return false;
    }
}

if (!function_exists('rand_str')) {
    function rand_str(int $length): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

if (!function_exists('response')) {
    function apiResponse(mixed $data, int $code = 200): string
    {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($code);
        return json_encode($data);
    }
}

if (!function_exists('dd')) {
    #[NoReturn]
    function dd(...$parameters): void
    {
        var_dump($parameters);
        die();
    }
}

if (!function_exists('request')) {
    function request(): Request
    {
        return Request::createFromGlobalRequest();
    }
}