<?php

use Framework\Http\RequestFactory;
use Framework\Http\Responder;
use Framework\Http\Response;
use Framework\Http\Router\Exception\RequestNotMatchedException;
use Framework\Http\Router\Route\RouteCollection;
use Framework\Http\Router\Router;
use Framework\Renderer;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

### Config router

$routes = new RouteCollection();
$routes->get('home', '/', App\Controllers\HomeController::class, 'index');

$router = new Router($routes);

### Make request

$request = RequestFactory::fromGlobals();

try {

    ### Resolve handler
    $result = $router->match($request);
    $controller = $result->getController();
    $action = $result->getAction();

    ### Make response
    $renderer = new Renderer('views');
    $response = (new $controller($renderer))->$action($request, $result->getAttributes());

} catch (RequestNotMatchedException $e){
    $response = new Response('Undefined page', 404);
}

### Send

Responder::send($response);