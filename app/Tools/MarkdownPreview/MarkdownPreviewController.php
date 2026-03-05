<?php

namespace App\Tools\MarkdownPreview;

use App\Tools\BaseToolController;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MarkdownPreviewController extends BaseToolController
{
    protected string $slug = 'markdown-preview';
    protected string $name = 'Markdown Preview';
    protected string $description = 'Preview Markdown as HTML in real time.';
    protected string $viewPath = 'tools.markdown_preview.index';

    public function getSlug(): string { return $this->slug; }
    public function getName(): string { return $this->name; }
    public function getDescription(): string { return $this->description; }

    public function index(Request $request): View
    {
        $this->recordUsage();
        return view($this->viewPath, ['tool' => $this->getToolMeta(), 'title' => $this->name, 'description' => $this->description]);
    }
}
