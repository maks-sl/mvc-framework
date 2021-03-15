<?php

use Framework\Http\RequestFactory;
use Framework\Http\Responder;
use Framework\Http\Response;
use Framework\Http\Router\Exception\RequestNotMatchedException;
use Framework\Http\Router\Router;

/**
 * @var \Framework\Container\Container $container
 * @var \Framework\Http\Router\Router $router
 */

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

$container = require 'config/container.php';

$router = $container->get(Router::class);

### Make request

$request = RequestFactory::fromGlobals();

try {

    ### Resolve handler
    $result = $router->match($request);
    $controller = $container->get($result->getController());
    $action = $result->getAction();

    ### Make response
    $response = $controller->$action($request, $result->getAttributes());

} catch (RequestNotMatchedException $e){
    $response = new Response('Undefined page', 404);
}

### Send

Responder::send($response);