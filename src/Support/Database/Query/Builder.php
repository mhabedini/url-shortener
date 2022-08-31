<?php

namespace Filimo\UrlShortener\Support\Database\Query;

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

    private function execute(string $query, bool $fetch = true): bool|array
    {
        $statement = $this->pdo->prepare($query);
        $isSuccessful = $statement->execute();
        if (!$fetch) {
            return $isSuccessful;
        }
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function limit(int $limit): static
    {
        $this->limit = $limit;
        return $this;
    }

    public function get(): array
    {
        $columns = implode(', ', $this->columns);
        $query = "SELECT $columns FROM $this->table";
        $query .= $this->buildQuery();
        $result = $this->execute($query);
        if (empty($result)) {
            return [];
        }
        return $result;
    }

    public function exists()
    {
        $query = "SELECT EXISTS(SELECT * FROM $this->table";
        $query .= $this->buildQuery();
        $query .= ');';
        $result = $this->execute($query)[0];
        return array_values($result)[0];
    }

    public function count()
    {
        $query = "SELECT count(*) as `count` FROM $this->table";
        $query .= $this->buildQuery();

        $result = $this->execute($query);
        return $result[0]['count'];
    }

    public function first()
    {
        $this->limit = 1;
        return $this->get()[0] ?? null;
    }

    private function buildQuery(): string
    {
        $query = $this->buildConditions();
        if (!is_null($this->limit)) {
            $query .= " limit $this->limit";
        }
        return $query;
    }

    private function buildConditions(): string
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
        return $query;
    }

    public function find(int $id): array
    {
        return $this->where('id', '=', $id)->first();
    }

    public function all(): array
    {
        return $this->execute("select * from $this->table");
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

    public function update(array $data)
    {
        $keys = preg_filter('/^/', "`$this->table`" . '.`', array_keys($data));
        $keys = preg_filter('/$/', '`', $keys);
        $values = array_values($data);
        $valuesName = preg_filter('/^/', ':', array_keys($data));

        $query = "UPDATE $this->table SET";
        for ($i = 0; $i < count($values); $i++) {
            $query .= " $keys[$i] = $valuesName[$i]";
            if ($i !== count($values) - 1) {
                $query .= ', ';
            } else {
                $query .= ' ';
            }
        }
        $query .= $this->buildConditions();

        $statement = $this->pdo->prepare($query);
        for ($i = 0; $i < count($values); $i++) {
            $type = PDO::PARAM_STR;
            if ($values[$i] == null) {
                $type = PDO::PARAM_NULL;
            }
            $statement->bindValue($valuesName[$i], $values[$i], $type);
        }

        return $statement->execute();
    }

    public function insert(array $data): bool
    {
        $keys = preg_filter('/^/', "`$this->table`" . '.`', array_keys($data));
        $keys = preg_filter('/$/', '`', $keys);
        $keys = implode(', ', $keys);
        $values = array_values($data);
        $valuesName = preg_filter('/^/', ':', array_keys($data));
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


    public function delete(int $id = null): bool
    {
        if (!is_null($id)) {
            $this->where('id', '=', $id);
        }

        $query = "DELETE FROM $this->table";
        $query .= $this->buildQuery();
        return $this->execute($query, false);
    }
}