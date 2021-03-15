<?php

namespace Framework;

use Framework\Http\Router\UrlGenerator;

class Renderer
{
    private $path;
    private $urlGenerator;

    public function __construct(string $path, UrlGenerator $urlGenerator)
    {
        $this->path = $path;
        $this->urlGenerator = $urlGenerator;
    }

    public function render($view, array $params = []): string
    {
        $templateFile = $this->path . '/' . $view . '.php';

        ob_start();
        extract($params, EXTR_OVERWRITE);
        require $templateFile;
        return ob_get_clean();
    }

    public function url($name, array $params = []): string
    {
        return $this->urlGenerator->to($name, $params);
    }
}