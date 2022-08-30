<?php

namespace Filimo\UrlShortener\Database\Query;

use PDO;

class Builder
{
    protected PDO $pdo;
    protected string $table;
    protected string $database;

    public function __construct(PDO $pdo, string $table)
    {
        $this->pdo = $pdo;
        $this->table = $table;
        $this->database = config('database.database');
    }

    public function all(): bool|array
    {
        $statement = $this->pdo->prepare("select * from $this->database.$this->table");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS);
    }
}