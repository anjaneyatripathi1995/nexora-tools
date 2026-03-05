<?php

namespace App\Tools;

use Illuminate\Support\Facades\Route;

/**
 * Central registry for all SaaS tools. Maps slug -> controller for /tools/{slug}.
 */
final class ToolRegistry
{
    /** @var array<string, class-string<BaseToolController>> */
    protected static array $tools = [];

    public static function register(string $slug, string $controllerClass): void
    {
        self::$tools[$slug] = $controllerClass;
    }

    public static function getController(string $slug): ?BaseToolController
    {
        $class = self::$tools[$slug] ?? null;
        return $class ? app($class) : null;
    }

    public static function getSlugs(): array
    {
        return array_keys(self::$tools);
    }

    public static function getAll(): array
    {
        $out = [];
        foreach (self::$tools as $slug => $class) {
            $ctrl = app($class);
            $out[] = [
                'slug' => $slug,
                'name' => $ctrl->getName(),
                'description' => $ctrl->getDescription(),
            ];
        }
        return $out;
    }

    public static function registerDefaultTools(): void
    {
        // Only register tools that do NOT have a working partial in tools/partials/*.
        // Tools with existing working partials (word-counter, pdf-merger, image-compressor,
        // json-formatter, base64-encoder, url-encoder) are handled by ToolController::show()
        // via tools/show.blade.php + tools/partials/{slug}.blade.php — do NOT intercept them here.
        $map = [
            'temp-mail'          => \App\Tools\TempMail\TempMailController::class,
            'password-generator' => \App\Tools\PasswordGenerator\PasswordGeneratorController::class,
            'uuid-generator'     => \App\Tools\UuidGenerator\UuidGeneratorController::class,
            'markdown-preview'   => \App\Tools\MarkdownPreview\MarkdownPreviewController::class,
        ];
        foreach ($map as $slug => $class) {
            self::register($slug, $class);
        }
    }
}
