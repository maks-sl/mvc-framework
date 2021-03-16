<?php

namespace App\Parser\Repository;

use App\Parser\ReadModel\Result;
use App\Parser\Result as ParserResult;

class ResultRepository
{
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @param int $id
     * @return Result[]|array
     */
    public function getAllForTask(int $id): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM results WHERE task_id = ? ORDER BY id DESC');
        $stmt->execute([$id]);

        return array_map([$this, 'hydrate'], $stmt->fetchAll());
    }

    public function findById(int $id): ?Result
    {
        $stmt = $this->pdo->prepare('SELECT * FROM results WHERE id = ?');
        $stmt->execute([$id]);

        return ($row = $stmt->fetch()) ? $this->hydrate($row) : null;
    }

    public function findForTaskByUrl(int $taskId, $url): ?Result
    {
        $stmt = $this->pdo->prepare('SELECT * FROM results WHERE task_id = ? AND url = ?');
        $stmt->execute([$taskId, $url]);

        return ($row = $stmt->fetch()) ? $this->hydrate($row) : null;
    }

    public function saveParserResult(int $taskId, ParserResult $item): bool
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO results(task_id, url, name, price, image, description) VALUES (:taskId, :url, :name, :price, :image, :description)'
        );
        $stmt->bindParam(':taskId', $taskId);
        $stmt->bindParam(':url', $item->url);
        $stmt->bindParam(':name', $item->name);
        $stmt->bindParam(':price', $item->price);
        $stmt->bindParam(':image', $item->image);
        $stmt->bindParam(':description', $item->description);

        return $stmt->execute();
    }

    private function hydrate(array $row): Result
    {
        $dto = new Result();

        $dto->id = (int)$row['id'];
        $dto->taskId = (int)$row['task_id'];
        $dto->url = $row['url'];
        $dto->name = $row['name'];
        $dto->price = $row['price'];
        $dto->image = $row['image'];
        $dto->description = $row['description'];

        return $dto;
    }
}
