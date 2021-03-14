<?php

namespace Framework\Http;

class Request
{
    private $queryParams;
    private $parsedBody;
    private $method;
    private $uri;

    public function __construct(array $queryParams = [], $parsedBody = null, $method = '', $uri = '')
    {
        $this->queryParams = $queryParams;
        $this->parsedBody = $parsedBody;
        $this->method = $method;
        $this->uri = $uri;
    }

    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    public function withQueryParams(array $query): self
    {
        $new = clone $this;
        $new->queryParams = $query;
        return $new;
    }

    public function getParsedBody()
    {
        return $this->parsedBody;
    }

    public function withParsedBody($data): self
    {
        $new = clone $this;
        $new->parsedBody = $data;
        return $new;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function withMethod($method)
    {
        $new = clone $this;
        $new->method = $method;
        return $new;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function withUri($uri)
    {
        $new = clone $this;
        $new->uri = $uri;
        return $new;
    }
}
