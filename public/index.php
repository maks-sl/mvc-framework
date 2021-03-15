<?php

use Framework\Http\RequestFactory;
use Framework\Http\Responder;

/**
 * @var \Framework\Container\Container $container
 * @var \Framework\Application $app
 */

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

$container = require 'config/container.php';
$app = $container->get(\Framework\Application::class);

### Make request
$request = RequestFactory::fromGlobals();

### Handle
$response = $app->run($request);

### Send
Responder::send($response);