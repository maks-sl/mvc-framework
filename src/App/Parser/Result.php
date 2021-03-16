<?php

namespace App\Parser;

class Result
{
    public $url;
    public $name;
    public $price;
    public $image;
    public $description;

    public function __construct($url, $name, $price, $image, $description)
    {
        $this->url = $url;
        $this->name = $name;
        $this->price = $price;
        $this->image = $image;
        $this->description = $description;
    }

    public function isFilledFully(): bool
    {
        foreach (get_object_vars($this) as $property => $default) {
            if (empty($this->{$property})) {
                return false;
            };
        }
        return true;
    }
}