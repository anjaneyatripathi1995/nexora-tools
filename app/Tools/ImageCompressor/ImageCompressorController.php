<?php

namespace App\Tools\ImageCompressor;

use App\Tools\BaseToolController;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ImageCompressorController extends BaseToolController
{
    protected string $slug = 'image-compressor';
    protected string $name = 'Image Compressor';
    protected string $description = 'Compress images to reduce file size.';
    protected string $viewPath = 'tools.image_compressor.index';

    public function getSlug(): string { return $this->slug; }
    public function getName(): string { return $this->name; }
    public function getDescription(): string { return $this->description; }

    public function index(Request $request): View
    {
        $this->recordUsage();
        return view($this->viewPath, ['tool' => $this->getToolMeta(), 'title' => $this->name, 'description' => $this->description]);
    }
}
