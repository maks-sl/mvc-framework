<?php

namespace Framework\Http\Router;

class Result
{
    private $name;
    private $controller;
    private $action;
    private $attributes;

    public function __construct($name, $controller, $action, array $attributes)
    {
        $this->name = $name;
        $this->controller = $controller;
        $this->action = $action;
        $this->attributes = $attributes;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getController(): string
    {
        return $this->controller;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
