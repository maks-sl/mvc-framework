<?php

namespace App\Parser;

class Loader
{
    public function load(string $url): string
    {
        if (!$content = file_get_contents($url)){
            throw new \RuntimeException('Unable to load url');
        };
        return $content;
    }
}