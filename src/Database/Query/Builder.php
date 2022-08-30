<?php

namespace Filimo\UrlShortener\Database\Query;

use PDO;

class Builder
{
    protected PDO $pdo;
    protected string $table;
    protected string $database;
    protected array $conditions = [];
    protected array $columns = ['*'];
    protected ?int $limit = null;

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

    public function where(string $column, string $operation, mixed $value, $type = 'and'): static
    {
        $this->conditions[] = [
            'column' => $column,
            'operation' => $operation,
            'value' => $value,
            'type' => $type,
        ];
        return $this;
    }

    public function select($columns): static
    {
        $this->columns = $columns;
        return $this;
    }

    public function limit(int $limit): static
    {
        $this->limit = $limit;
        return $this;
    }

    public function get()
    {
        $columns = implode(', ', $this->columns);
        $query = "SELECT $columns FROM $this->table";
        $query .= $this->buildQuery();
        $statement = $this->pdo->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (empty($result)) {
            return null;
        }
        return $result[0];
    }

    public function exists()
    {
        $query = "SELECT EXISTS(SELECT * FROM $this->table";
        $query .= $this->buildQuery();
        $query .= ');';
        $statement = $this->pdo->prepare($query);
        $statement->execute();
        return array_values($statement->fetchAll(PDO::FETCH_ASSOC)[0])[0];
    }

    public function count()
    {
        $query = "SELECT count(*) as `count` FROM $this->table";
        $query .= $this->buildQuery();

        $statement = $this->pdo->prepare($query);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC)[0]['count'];
    }

    public function first()
    {
        $this->limit = 1;
        return $this->get();
    }

    private function buildQuery(): string
    {
        $query = '';
        if (!empty($this->conditions)) {
            $condition = $this->conditions[0];
            $query .= " WHERE {$condition['column']} {$condition['operation']} '{$condition['value']}'";
            for ($i = 1; $i < count($this->conditions); $i++) {
                $condition = $this->conditions[$i];
                $query .= " {$condition['type']} {$condition['column']} {$condition['operation']} '{$condition['value']}'";
            }
        }

        if (!is_null($this->limit)) {
            $query .= " limit $this->limit";
        }
        return $query;
    }

    public function find(mixed $primaryValue): array
    {
        $statement = $this->pdo->prepare("SHOW KEYS FROM $this->table WHERE Key_name = 'PRIMARY'");
        $statement->execute();
        $primaryKey = $statement->fetch(PDO::FETCH_ASSOC)['Column_name'];
        $statement = $this->pdo->prepare("select * from $this->table where $primaryKey = $primaryValue LIMIT 1;");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC)[0];
    }

    public function all(): array
    {
        $statement = $this->pdo->prepare("select * from $this->table");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(array $data): array
    {
        $isSuccessful = $this->insert($data);
        if (!$isSuccessful) {
            throw new \Exception('An error occurred');
        }

        $statement = $this->pdo->prepare('SELECT LAST_INSERT_ID();');
        $statement->execute();
        $id = $statement->fetch()[0];
        return $this->find($id);
    }

    public function insert(array $data): bool
    {
        $keys = preg_filter('/^/', "`$this->table`" . '.`', array_keys($data));
        $keys = preg_filter('/$/', '`', $keys);
        $values = array_values($data);
        $valuesName = preg_filter('/^/', ':', array_keys($data));

        $keys = implode(', ', $keys);
        $valuesNameFlatten = implode(', ', $valuesName);

        $statement = $this->pdo->prepare("INSERT INTO $this->table ($keys) VALUES ($valuesNameFlatten);");
        for ($i = 0; $i < count($values); $i++) {
            $type = PDO::PARAM_STR;
            if ($values[$i] == null) {
                $type = PDO::PARAM_NULL;
            }
            $statement->bindValue($valuesName[$i], $values[$i], $type);
        }

        return $statement->execute();
    }
}