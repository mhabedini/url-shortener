<?php

namespace Filimo\UrlShortener\Database\Query;

use PDO;

class Builder
{
    protected PDO $pdo;
    protected string $table;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function all(): bool|array
    {
        $statement = $this->pdo->prepare("select * from $this->table");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS);
    }
}