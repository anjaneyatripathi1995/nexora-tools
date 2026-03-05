<?php

namespace App\Tools\WordCounter;

use App\Tools\BaseToolService;

class WordCounterService extends BaseToolService
{
    public static function count(string $text): array
    {
        $words = str_word_count($text, 0);
        $chars = strlen($text);
        $charsNoSpaces = strlen(preg_replace('/\s/', '', $text));
        $sentences = max(1, preg_match_all('/[.!?]+/', $text));
        $paragraphs = max(1, count(preg_split('/\n\s*\n/', trim($text), -1, PREG_SPLIT_NO_EMPTY)));
        return compact('words', 'chars', 'charsNoSpaces', 'sentences', 'paragraphs');
    }
}
