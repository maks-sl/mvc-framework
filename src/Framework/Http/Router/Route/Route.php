<?php

namespace Framework\Http\Router\Route;

use Framework\Http\Request;
use Framework\Http\Router\Result;

class Route
{
    private $name;
    private $pattern;
    private $controller;
    private $action;
    private $methods;
    private $tokens;

    public function __construct($name, $pattern, $controller, $action, array $methods, array $tokens = [])
    {
        $this->name = $name;
        $this->pattern = $pattern;
        $this->controller = $controller;
        $this->action = $action;
        $this->methods = $methods;
        $this->tokens = $tokens;
    }

    public function match(Request $request): ?Result
    {
        if ($this->methods && !\in_array($request->getMethod(), $this->methods, true)) {
            return null;
        }

        $pattern = preg_replace_callback('~\{([^\}]+)\}~', function ($matches) {
            $argument = $matches[1];
            $replace = $this->tokens[$argument] ?? '[^}]+';
            return '(?P<' . $argument . '>' . $replace . ')';
        }, $this->pattern);

        $path =  parse_url($request->getUri(), PHP_URL_PATH);
        if (!preg_match('~^' . $pattern . '$~i', $path, $matches)) {
            return null;
        }

        return new Result(
            $this->name,
            $this->controller,
            $this->action,
            array_filter($matches, '\is_string', ARRAY_FILTER_USE_KEY)
        );
    }

    public function generate($name, array $params = []): ?string
    {
        $arguments = array_filter($params);

        if ($name !== $this->name) {
            return null;
        }

        $url = preg_replace_callback('~\{([^\}]+)\}~', function ($matches) use (&$arguments) {
            $argument = $matches[1];
            if (!array_key_exists($argument, $arguments)) {
                throw new \InvalidArgumentException('Missing parameter "' . $argument . '"');
            }
            return $arguments[$argument];
        }, $this->pattern);

        return $url;
    }
}
