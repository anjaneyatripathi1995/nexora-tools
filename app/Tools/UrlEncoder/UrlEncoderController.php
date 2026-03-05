<?php

namespace App\Tools\UrlEncoder;

use App\Tools\BaseToolController;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UrlEncoderController extends BaseToolController
{
    protected string $slug = 'url-encoder';
    protected string $name = 'URL Encoder';
    protected string $description = 'Encode and decode URL strings.';
    protected string $viewPath = 'tools.url_encoder.index';

    public function getSlug(): string { return $this->slug; }
    public function getName(): string { return $this->name; }
    public function getDescription(): string { return $this->description; }

    public function index(Request $request): View
    {
        $this->recordUsage();
        return view($this->viewPath, ['tool' => $this->getToolMeta(), 'title' => $this->name, 'description' => $this->description]);
    }
}
