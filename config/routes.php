<?php

use Framework\Container\Container;
use Framework\Http\Router\Route\RouteCollection;

/** @var Container $container */

$container->set(RouteCollection::class, function () {
    $routes = new RouteCollection();
    $routes->get('home', '/', App\Controllers\HomeController::class, 'index');
    $routes->get('parser_list', '/list', App\Controllers\ParserController::class, 'list');
    $routes->post('parser_parse', '/list', App\Controllers\ParserController::class, 'parse');
    $routes->get('parser_view', '/view/{id}', App\Controllers\ParserController::class, 'view', ['id' => '\d+']);
    $routes->get('parser_view_page', '/view/{id}/{page}', App\Controllers\ParserController::class, 'view', ['id' => '\d+', 'page' => '\d+']);
    return $routes;
});