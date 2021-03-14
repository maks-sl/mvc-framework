<?php

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

$name = isset($_GET['name']) ? $_GET['name'] : 'World';
echo 'Hello, ' . $name . '!';