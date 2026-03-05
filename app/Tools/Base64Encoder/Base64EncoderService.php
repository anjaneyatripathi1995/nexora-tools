<?php

namespace App\Tools\Base64Encoder;

use App\Tools\BaseToolService;

class Base64EncoderService extends BaseToolService
{
    public static function encode(string $input): string { return base64_encode($input); }
    public static function decode(string $input): string { return base64_decode($input, true) ?: ''; }
}
