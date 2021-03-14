<?php

use Framework\Http\RequestFactory;
use Framework\Http\Response;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

### Make request

$request = RequestFactory::fromGlobals();

### Make response

$name = $request->getQueryParams()['name'] ?? 'World';
$response = (new Response('Hello, ' . $name . '!'));

### Send

$protocol = $_SERVER['SERVER_PROTOCOL'] ?? 'HTTP/1.0';
header($protocol.' ' . $response->getStatusCode() . ' ' . $response->getReasonPhrase());
echo $response->getBody();