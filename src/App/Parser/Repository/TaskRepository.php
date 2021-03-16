<?php

namespace App\Parser\Repository;

use App\Parser\ReadModel\Task;
use App\Parser\ReadModel\TaskListItem;

class TaskRepository
{
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @return TaskListItem[]
     */
    public function getList(): array
    {
        $stmt = $this->pdo->query(
            'SELECT t.*, count(r.id) as num_results FROM tasks t LEFT JOIN results r ON r.task_id = t.id GROUP BY t.id ORDER BY id DESC'
        );

        return array_map([$this, 'hydrateList'], $stmt->fetchAll());
    }

    public function findById($id): ?Task
    {
        $stmt = $this->pdo->prepare('SELECT * FROM tasks WHERE id = ?');
        $stmt->execute([$id]);

        return ($row = $stmt->fetch()) ? $this->hydrate($row) : null;
    }

    public function findByUrl($url): ?Task
    {
        $stmt = $this->pdo->prepare('SELECT * FROM tasks WHERE url = ?');
        $stmt->execute([$url]);

        return ($row = $stmt->fetch()) ? $this->hydrate($row) : null;
    }

    public function createAndReturnId($url): int
    {
        $stmt = $this->pdo->prepare('INSERT INTO tasks(url) VALUES (:url)');
        $stmt->bindParam(':url', $url);
        $stmt->execute();

        return $this->pdo->lastInsertId();
    }

    private function hydrate(array $row): Task
    {
        $dto = new Task();

        $dto->id = (int)$row['id'];
        $dto->url = $row['url'];

        return $dto;
    }

    private function hydrateList(array $row): TaskListItem
    {
        $dto = new TaskListItem();

        $dto->id = (int)$row['id'];
        $dto->url = $row['url'];
        $dto->numResults = $row['num_results'];

        return $dto;
    }
}
