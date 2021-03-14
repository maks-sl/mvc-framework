<?php

namespace Framework\Http\Router\Exception;

use Framework\Http\Request;

class RequestNotMatchedException extends \LogicException
{
    private $request;

    public function __construct(Request $request)
    {
        parent::__construct('Matches not found.');
        $this->request = $request;
    }

    public function getRequest(): Request
    {
        return $this->request;
    }
}
