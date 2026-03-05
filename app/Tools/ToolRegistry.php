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
        $map = [
            'temp-mail' => \App\Tools\TempMail\TempMailController::class,
            'json-formatter' => \App\Tools\JsonFormatter\JsonFormatterController::class,
            'base64-encoder' => \App\Tools\Base64Encoder\Base64EncoderController::class,
            'password-generator' => \App\Tools\PasswordGenerator\PasswordGeneratorController::class,
            'word-counter' => \App\Tools\WordCounter\WordCounterController::class,
            'image-compressor' => \App\Tools\ImageCompressor\ImageCompressorController::class,
            'pdf-merger' => \App\Tools\PdfMerger\PdfMergerController::class,
            'url-encoder' => \App\Tools\UrlEncoder\UrlEncoderController::class,
            'uuid-generator' => \App\Tools\UuidGenerator\UuidGeneratorController::class,
            'markdown-preview' => \App\Tools\MarkdownPreview\MarkdownPreviewController::class,
        ];
        foreach ($map as $slug => $class) {
            self::register($slug, $class);
        }
    }
}
