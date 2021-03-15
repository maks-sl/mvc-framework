<?php

namespace Framework\Http\Router;

class UrlGenerator
{
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function to($name, array $params = []): string
    {
        return $this->router->generate($name, $params);
    }
}
