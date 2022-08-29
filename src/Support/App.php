<?php

namespace Filimo\UrlShortener\Support;

use Exception;
use Filimo\UrlShortener\Database\Connection;
use Filimo\UrlShortener\Support\Http\Router;
use PDO;

class App
{
    protected string $basePath;
    protected array $configs = [];
    protected static ?App $instance = null;
    protected PDO|null $pdo = null;

    private function __construct(string $basePath)
    {
        $this->setBasePath($basePath);
    }

    public static function getInstance(): ?App
    {
        return self::$instance;
    }

    public static function create(string $basePath): ?App
    {
        if (is_null(self::$instance)) {
            self::$instance = new self($basePath);
            self::$instance->registerBaseBindings();
        }
        return self::$instance;
    }

    private function registerBaseBindings(): void
    {
        $this->registerRoutes();
        $this->registerConfigs();
        $this->registerDatabase();
    }

    private function registerRoutes(): void
    {
        Router::load('api.php', 'api');
    }

    private function registerConfigs(): void
    {
        $configPath = $this->basePath . '/config/';
        $configs = array_diff(scandir($configPath), array('.', '..'));
        foreach ($configs as $config) {
            if (str_ends_with($config, '.php')) {
                $this->configs[explode('.php', $config)[0]] = require $configPath . $config;
            }
        }
    }

    public function getBasePath(): string
    {
        return $this->basePath;
    }

    public function setBasePath(string $basePath): void
    {
        $this->basePath = $basePath;
    }

    /**
     * @return array
     */
    public function getConfigs(): array
    {
        return $this->configs;
    }

    public function getConfig($key, $default)
    {
        $paths = explode('.', $key);
        $config = $this->getConfigs();
        try {
            foreach ($paths as $path) {
                $config = $config[$path];
            }
            return $config;
        } catch (Exception $exception) {
            return $default;
        }
    }

    private function registerDatabase(): void
    {
        $this->pdo = Connection::make();
    }
}