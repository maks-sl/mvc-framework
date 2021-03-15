<?php

use Framework\Application;
use Framework\Container\Container;
use Framework\Http\Router\Router;
use Framework\Http\Router\UrlGenerator;
use Framework\Renderer;

/** @var Container $container */

$container->set(Renderer::class, function (Container $container) {
    return new Renderer(
        $container->get('config')['templates_path'],
        $container->get(UrlGenerator::class)
    );
});

$container->set(Application::class, function (Container $container) {
    return new Application(
        $container,
        $container->get(Router::class)
    );
});

$container->set(\PDO::class, function (Container $container) {
    $config = $container->get('config')['pdo'];
    return new \PDO(
        $config['dsn'],
        $config['username'],
        $config['password'],
        $config['options']
    );
});