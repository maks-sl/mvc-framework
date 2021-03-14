<?php

namespace App\Controllers;

use Framework\Http\Request;
use Framework\Http\Response;
use App\Helpers\InputHelper;

class HomeController
{
    public function index(Request $request, array $args = []): Response
    {
        $name = $request->getQueryParams()['name'] ?? 'World';
        return new Response('Hello, '. InputHelper::cleanParam($name) . '!');
    }
}