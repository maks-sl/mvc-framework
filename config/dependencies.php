<?php

use Framework\Container\Container;
use Framework\Http\Router\UrlGenerator;
use Framework\Renderer;

/** @var Container $container */

$container->set(Renderer::class, function (Container $container) {
    return new Renderer(
        $container->get('config')['templates_path'],
        $container->get(UrlGenerator::class)
    );
});