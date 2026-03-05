<?php

namespace App\Tools\UuidGenerator;

use App\Tools\BaseToolService;
use Illuminate\Support\Str;

class UuidGeneratorService extends BaseToolService
{
    public static function generate(): string { return (string) Str::uuid(); }
}
