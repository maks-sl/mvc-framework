<?php

use Framework\Container\Container;
use Framework\Http\Router\Route\RouteCollection;

/** @var Container $container */

$container->set(RouteCollection::class, function () {
    $routes = new RouteCollection();
    $routes->get('home', '/', App\Controllers\HomeController::class, 'index');
    return $routes;
});