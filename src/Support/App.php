<?php

namespace Filimo\UrlShortener\Support;

use Dotenv\Dotenv;
use Dotenv\Repository\Adapter\EnvConstAdapter;
use Dotenv\Repository\Adapter\PutenvAdapter;
use Dotenv\Repository\RepositoryBuilder;
use Exception;
use Filimo\UrlShortener\Database\Connection;
use Filimo\UrlShortener\Database\Query\Builder;
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
        $this->registerEnv();
        $this->registerRoutes();
        $this->registerConfigs();
        $this->registerDatabase();
    }

    private function registerRoutes(): void
    {
        Router::load('api.php', $this->getBasePath(), 'api');
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

    public function queryBuilder(string $table): Builder
    {
        return (new Builder($this->pdo))->table($table);
    }

    private function registerEnv(): void
    {
        $repository = RepositoryBuilder::createWithNoAdapters()
            ->addAdapter(EnvConstAdapter::class)
            ->addWriter(PutenvAdapter::class)
            ->immutable()
            ->make();

        $dotenv = Dotenv::create($repository, $this->basePath);
        $dotenv->load();
    }

    public function terminate(): void
    {
        $this->pdo = null;
    }

    /**
     * @return PDO|null
     */
    public function getPdo(): ?PDO
    {
        return $this->pdo;
    }
}