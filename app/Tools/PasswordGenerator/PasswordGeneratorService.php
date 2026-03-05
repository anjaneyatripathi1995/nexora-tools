<?php

namespace App\Tools\PasswordGenerator;

use App\Tools\BaseToolService;

class PasswordGeneratorService extends BaseToolService
{
    public static function generate(int $length = 16, bool $uppercase = true, bool $numbers = true, bool $symbols = true): string
    {
        $chars = 'abcdefghijklmnopqrstuvwxyz';
        if ($uppercase) $chars .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if ($numbers) $chars .= '0123456789';
        if ($symbols) $chars .= '!@#$%^&*';
        return substr(str_shuffle(str_repeat($chars, (int) ceil($length / strlen($chars)))), 0, $length);
    }
}
