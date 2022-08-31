<?php

namespace Filimo\UrlShortener\Support\Http;


class Request
{
    protected static ?self $requestFactory = null;
    private array $query;
    private array $request;
    private array $cookies;
    private array $files;
    private array $server;

    public function __construct($query, $request, $cookies, $files, $server)
    {
        $this->query = $query;
        $this->request = $request;
        $this->cookies = $cookies;
        $this->files = $files;
        $this->server = $server;
    }

    public static function createFromGlobalRequest(): self
    {
        return self::createRequestFromFactory($_GET, $_POST, $_COOKIE, $_FILES, $_SERVER);
    }

    private static function createRequestFromFactory(
        array $query = [],
        array $request = [],
        array $cookies = [],
        array $files = [],
        array $server = [],
    ): Request|static
    {
        if (self::$requestFactory) {
            $request = (self::$requestFactory)($query, $request, $cookies, $files, $server);

            if (!$request instanceof self) {
                throw new \LogicException('The Request factory must return an instance of  Filimo\UrlShortener\Support\Http\Request');
            }

            return $request;
        }

        return new static($query, $request, $cookies, $files, $server);
    }

    public function getRequest(): array
    {
        return $this->request;
    }


    public function getQuery(): array
    {
        return $this->query;
    }


    public function getCookies(): array
    {
        return $this->cookies;
    }

    public function getFiles(): array
    {
        return $this->files;
    }

    public function getServer(): array
    {
        return $this->server;
    }

    public function all(): array
    {
        $jsonRequestBody = $this->getJsonRequestBody();
        return array_merge($this->query + $this->request, $jsonRequestBody);
    }

    private function getJsonRequestBody()
    {
        return json_decode(file_get_contents('php://input'), true);
    }

    public function get($key, $default = null)
    {
        return $this->all()[$key] ?? $default;
    }
}