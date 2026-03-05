<?php

namespace App\Tools\JsonFormatter;

use App\Tools\BaseToolService;

class JsonFormatterService extends BaseToolService
{
    public static function format(string $json, int $flags = JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES): string
    {
        $decoded = json_decode($json);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \InvalidArgumentException(json_last_error_msg());
        }
        return json_encode($decoded, $flags);
    }
}
