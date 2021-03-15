<?php

/** @var \Framework\Renderer $this */
/** @var string $name */

$this->params['title'] = 'Hello';
$this->extend('layout/main');

?>
<div class="jumbotron">
    <h1>Hello, <?= $name ?>!</h1>
    <p>
        Congratulations! You have successfully created your application.
    </p>
</div>