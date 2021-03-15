<?php

use Framework\Container\Container;
use Framework\Http\Router\Route\RouteCollection;
use Framework\Http\Router\Router;
use Framework\Http\Router\UrlGenerator;
use Framework\Renderer;

/** @var Container $container */

$container->set(Router::class, function (Container $container) {
    return new Router($container->get(RouteCollection::class));
});
$container->set(UrlGenerator::class, function (Container $container) {
    return new UrlGenerator($container->get(Router::class));
});
$container->set(Renderer::class, function (Container $container) {
    return new Renderer(
        $container->get('config')['templates_path'],
        $container->get(UrlGenerator::class)
    );
});

$container->set(\App\Controllers\HomeController::class, function (Container $container) {
    return new \App\Controllers\HomeController(
        $container->get(Renderer::class)
    );
});