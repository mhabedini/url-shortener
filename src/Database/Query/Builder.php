<?php

namespace Filimo\UrlShortener\Database\Query;

use Illuminate\Support\Collection;
use PDO;

class Builder
{
    protected PDO $pdo;
    protected string $table;
    protected string $database;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->database = config('database.database');
    }

    public function table(string $table): static
    {
        $this->table = $table;
        return $this;
    }

    public function all(): Collection
    {
        $statement = $this->pdo->prepare("select * from $this->database.$this->table");
        $statement->execute();
        return collect($statement->fetchAll(PDO::FETCH_ASSOC));
    }
}