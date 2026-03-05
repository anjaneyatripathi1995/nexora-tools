<?php

namespace App\Tools\PdfMerger;

use App\Tools\BaseToolController;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PdfMergerController extends BaseToolController
{
    protected string $slug = 'pdf-merger';
    protected string $name = 'PDF Merger';
    protected string $description = 'Merge multiple PDF files into one.';
    protected string $viewPath = 'tools.pdf_merger.index';

    public function getSlug(): string { return $this->slug; }
    public function getName(): string { return $this->name; }
    public function getDescription(): string { return $this->description; }

    public function index(Request $request): View
    {
        $this->recordUsage();
        return view($this->viewPath, ['tool' => $this->getToolMeta(), 'title' => $this->name, 'description' => $this->description]);
    }
}
