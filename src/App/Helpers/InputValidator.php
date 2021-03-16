<?php

namespace App\Helpers;

class InputValidator
{
    public static function assertValidUrl(string $string): bool
    {
        if (filter_var($string, FILTER_VALIDATE_URL) === FALSE) {
            return false;
        }
        if (stripos($string, 'http') !== 0) {
            return false;
        }
        return true;
    }
}