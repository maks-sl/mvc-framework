<?php

namespace Framework\Http\Router\Route;

class RouteCollection
{
    private $routes = [];

    public function addRoute(Route $route): void
    {
        $this->routes[] = $route;
    }

    public function add($name, $pattern, $controller, $action, array $methods, array $tokens = []): void
    {
        $this->addRoute(new Route($name, $pattern, $controller, $action, $methods, $tokens));
    }

    public function any($name, $pattern, $controller, $action, array $tokens = []): void
    {
        $this->addRoute(new Route($name, $pattern, $controller, $action, [], $tokens));
    }

    public function get($name, $pattern, $controller, $action, array $tokens = []): void
    {
        $this->addRoute(new Route($name, $pattern, $controller, $action, ['GET'], $tokens));
    }

    public function post($name, $pattern, $controller, $action, array $tokens = []): void
    {
        $this->addRoute(new Route($name, $pattern, $controller, $action, ['POST'], $tokens));
    }

    /**
     * @return Route[]
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }
}
