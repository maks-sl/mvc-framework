<?php

namespace App\Services;

use App\Parser\Parser;
use App\Parser\Repository\ResultRepository;
use App\Parser\Repository\TaskRepository;
use App\Parser\Result;

class ParserService
{
    private $results;
    private $tasks;
    private $parser;

    public function __construct(ResultRepository $results, TaskRepository $tasks, Parser $parser)
    {
        $this->results = $results;
        $this->tasks = $tasks;
        $this->parser = $parser;
    }

    public function handleUrl(string $url): int
    {
        if (!$task = $this->tasks->findByUrl($url)) {
            $taskId = $this->tasks->createAndReturnId($url);
            if (!$task = $this->tasks->findById($taskId)) {
                throw new \RuntimeException('Error when task creating');
            }
        }

        $found = $this->parser->run($task);
        $filtered = array_filter($found, function (Result $item) use ($task) {
            return ! (bool) $this->results->findForTaskByUrl($task->id, $item->url);
        });

        foreach ($filtered as $item) {
            $this->results->saveParserResult($task->id, $item);
        }

        return count($filtered);
    }

}