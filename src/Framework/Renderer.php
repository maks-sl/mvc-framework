<?php

namespace Framework;

use Framework\Http\Router\UrlGenerator;

class Renderer
{
    private $path;
    private $urlGenerator;
    private $extend;
    private $params = [];

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
        $this->extend = null;
        require $templateFile;
        $content = ob_get_clean();

        if (!$this->extend) {
            return $content;
        }

        return $this->render($this->extend, [
            'content' => $content,
        ]);
    }

    public function url($name, array $params = []): string
    {
        return $this->urlGenerator->to($name, $params);
    }

    public function extend($view): void
    {
        $this->extend = $view;
    }
}