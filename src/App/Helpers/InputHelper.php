<?php

namespace App\Helpers;

class InputHelper
{
    public static function cleanParam(string $string): string
    {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Remove not allowed symbols.
    }

    public static function toInt(string $string): int
    {
        return (int) $string;
    }
}