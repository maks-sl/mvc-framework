<?php

namespace Framework;

class Renderer
{
    private $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function render($view, array $params = []): string
    {
        $templateFile = $this->path . '/' . $view . '.php';

        ob_start();
        extract($params, EXTR_OVERWRITE);
        require $templateFile;
        return ob_get_clean();
    }
}