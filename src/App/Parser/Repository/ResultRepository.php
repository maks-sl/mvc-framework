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

    public function countAllForTask(int $id): int
    {
        $stmt = $this->pdo->prepare('SELECT count(id) FROM results WHERE task_id = ?');
        $stmt->execute([$id]);
        return $stmt->fetchColumn();
    }

    /**
     * @param int $id
     * @param int $limit
     * @param int $offset
     * @return Result[]|array
     */
    public function getAllForTask(int $id, int $limit, int $offset): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM results WHERE task_id = :id ORDER BY id DESC LIMIT :limit OFFSET :offset');
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();

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

    /**
     * @param int $taskId
     * @param ParserResult[] $items
     * @throws \Exception
     */
    public function saveParserResults(int $taskId, array $items): void
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO results(task_id, url, name, price, image, description) VALUES (?, ?, ?, ?, ?, ?)'
        );
        try {
            $this->pdo->beginTransaction();
            foreach ($items as $item) {
                $stmt->execute([$taskId, $item->url, $item->name, $item->price, $item->image, $item->description]);
            }
            $this->pdo->commit();
        }catch (\Exception $e){
            $this->pdo->rollback();
            throw $e;
        }
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
