<?php

namespace Framework\Http;

class Response
{
    private $body;
    private $statusCode;
    private $reasonPhrase = '';
    private $headers = [];

    private static $phrases = [
        200 => 'OK',
        301 => 'Moved Permanently',
        302 => 'Found',
        400 => 'Bad Request',
        403 => 'Forbidden',
        404 => 'Not Found',
        500 => 'Internal Server Error',
    ];

    public function __construct($body, $status = 200)
    {
        $this->body = $body;
        $this->statusCode = $status;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function withBody($body): self
    {
        $new = clone $this;
        $new->body = $body;
        return $new;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getReasonPhrase()
    {
        if (!$this->reasonPhrase && isset(self::$phrases[$this->statusCode])) {
            $this->reasonPhrase = self::$phrases[$this->statusCode];
        }
        return $this->reasonPhrase;
    }

    public function withStatus($code, $reasonPhrase = ''): self
    {
        $new = clone $this;
        $new->statusCode = $code;
        $new->reasonPhrase = $reasonPhrase;
        return $new;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function hasHeader($name): bool
    {
        return isset($this->headers[$name]);
    }

    public function getHeader($name)
    {
        if (!$this->hasHeader($name)) {
            return null;
        }
        return $this->headers[$name];
    }

    public function withHeader($name, $value): self
    {
        $new = clone $this;
        if ($new->hasHeader($name)) {
            unset($new->headers[$name]);
        }
        $new->headers[$name] = (array)$value;
        return $new;
    }
}
