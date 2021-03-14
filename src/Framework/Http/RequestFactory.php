<?php

namespace Framework\Http;

class RequestFactory
{
    public static function fromGlobals(array $query = null, array $body = null, string $method = null, string $uri = null): Request
    {
        return (new Request())
            ->withQueryParams($query ?: $_GET)
            ->withParsedBody($body ?: $_POST)
            ->withMethod($method ?: $_SERVER['REQUEST_METHOD'])
            ->withUri($uri ?: $_SERVER['REQUEST_URI']);
    }
}