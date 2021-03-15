<?php

namespace Framework;

use Framework\Container\Container;
use Framework\Http\Request;
use Framework\Http\Response;
use Framework\Http\Router\Exception\RequestNotMatchedException;
use Framework\Http\Router\Router;

class Application
{
    private $container;
    private $router;

    public function __construct(Container $container, Router $router)
    {
        $this->container = $container;
        $this->router = $router;
    }

    public function run(Request $request): Response
    {
        try {

            ### Resolve handler
            $result = $this->router->match($request);
            $controller = $this->container->get($result->getController());
            $action = $result->getAction();

            ### Make response
            $response = $controller->$action($request, $result->getAttributes());

        } catch (RequestNotMatchedException $e){
            $response = new Response('Undefined page', 404);
        }

        return $response;
    }
}
