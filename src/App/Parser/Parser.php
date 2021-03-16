<?php

namespace App\Parser;

use App\Parser\ReadModel\Task;

class Parser
{
    private $loader;
    private $resolver;

    public function __construct(Loader $loader, Resolver $resolver)
    {
        $this->loader = $loader;
        $this->resolver = $resolver;
    }

    /**
     * @param Task $task
     * @return Result[]
     */
    public function run(Task $task): array
    {
        $content = $this->loader->load($task->url);
        return $this->resolver->findItems($content);
    }

}