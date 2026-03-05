<?php

namespace App\Tools\WordCounter;

use App\Tools\BaseToolController;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WordCounterController extends BaseToolController
{
    protected string $slug = 'word-counter';
    protected string $name = 'Word Counter';
    protected string $description = 'Count words, characters, sentences, and paragraphs.';
    protected string $viewPath = 'tools.word_counter.index';

    public function getSlug(): string { return $this->slug; }
    public function getName(): string { return $this->name; }
    public function getDescription(): string { return $this->description; }

    public function index(Request $request): View
    {
        $this->recordUsage();
        return view($this->viewPath, ['tool' => $this->getToolMeta(), 'title' => $this->name, 'description' => $this->description]);
    }
}
