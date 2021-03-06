<?php

namespace Framework\Http;


class Responder
{
    public static function send(Response $response): void
    {
        header(sprintf(
            '%s %d %s',
            $_SERVER['SERVER_PROTOCOL'] ?? 'HTTP/1.0',
            $response->getStatusCode(),
            $response->getReasonPhrase()
        ));
        foreach ($response->getHeaders() as $name => $values) {
            header($name . ':' . implode(', ', $values));
        }
        echo $response->getBody();
    }
}