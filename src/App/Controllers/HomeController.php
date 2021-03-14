<?php

namespace App\Controllers;

use Framework\Http\Request;
use Framework\Http\Response;
use App\Helpers\InputHelper;
use Framework\Renderer;

class HomeController
{
    private $renderer;

    public function __construct(Renderer $renderer)
    {
        $this->renderer = $renderer;
    }

    public function index(Request $request, array $args = []): Response
    {
        $name = $request->getQueryParams()['name'] ?? 'World';
        return new Response($this->renderer->render('hello', [
            'name' => InputHelper::cleanParam($name),
        ]));
    }
}