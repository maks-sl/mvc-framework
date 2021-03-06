<?php

namespace App\Controllers;

use App\Helpers\InputHelper;
use App\Helpers\InputValidator;
use App\Widgets\Pagination;
use App\Parser\Repository\ResultRepository;
use App\Parser\Repository\TaskRepository;
use App\Services\ParserService;
use Framework\Http\Request;
use Framework\Http\Response;
use Framework\Renderer;

class ParserController
{
    private $renderer;
    private $tasks;
    private $results;
    private $parser;

    private const PER_PAGE = 10;

    public function __construct(Renderer $renderer, TaskRepository $tasks, ResultRepository $results, ParserService $parser)
    {
        $this->renderer = $renderer;
        $this->tasks = $tasks;
        $this->results = $results;
        $this->parser = $parser;
    }

    public function list(Request $request, array $args = []): Response
    {
        $listItems = $this->tasks->getList();
        return new Response($this->renderer->render('parser/list', [
            'listItems' => $listItems,
        ]));
    }

    public function parse(Request $request, array $args = []): Response
    {
        if (!$url = $request->getParsedBody()['url'] ?? false) {
            throw new \LogicException('Empty url');
        }
        if (!InputValidator::assertValidUrl($url)) {
            throw new \LogicException('Url not valid');
        }

        $numResults = $this->parser->handleUrl($url);

        $response = new Response('', 302);
        return $response->withHeader(
            'Location', $this->renderer->url('parser_list')
        );
    }

    public function view(Request $request, array $args = []): Response
    {
        $id = InputHelper::toInt($args['id']);
        if (!$task = $this->tasks->findById($id)) {
            throw new \DomainException('Task not found');
        }

        $pagination = new Pagination(
            $this->results->countAllForTask($task->id),
            InputHelper::toInt($args['page'] ?? 1),
            self::PER_PAGE
        );

        $results = $this->results->getAllForTask(
            $task->id,
            $pagination->getLimit(),
            $pagination->getOffset()
        );
        return new Response($this->renderer->render('parser/view', [
            'task' => $task,
            'results' => $results,
            'pagination' => $pagination,
        ]));
    }
}