<?php

namespace App\Tools\Base64Encoder;

use App\Tools\BaseToolController;
use Illuminate\Http\Request;
use Illuminate\View\View;

class Base64EncoderController extends BaseToolController
{
    protected string $slug = 'base64-encoder';
    protected string $name = 'Base64 Encoder';
    protected string $description = 'Encode and decode text or files to Base64.';
    protected string $viewPath = 'tools.base64_encoder.index';

    public function getSlug(): string { return $this->slug; }
    public function getName(): string { return $this->name; }
    public function getDescription(): string { return $this->description; }

    public function index(Request $request): View
    {
        $this->recordUsage();
        return view($this->viewPath, ['tool' => $this->getToolMeta(), 'title' => $this->name, 'description' => $this->description]);
    }
}
