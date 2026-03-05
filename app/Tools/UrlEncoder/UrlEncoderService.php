<?php

namespace App\Tools\UrlEncoder;

use App\Tools\BaseToolService;

class UrlEncoderService extends BaseToolService
{
    public static function encode(string $input): string { return rawurlencode($input); }
    public static function decode(string $input): string { return rawurldecode($input); }
}
