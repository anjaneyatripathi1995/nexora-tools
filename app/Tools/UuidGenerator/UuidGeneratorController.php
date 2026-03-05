<?php

namespace App\Tools\UuidGenerator;

use App\Tools\BaseToolController;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UuidGeneratorController extends BaseToolController
{
    protected string $slug = 'uuid-generator';
    protected string $name = 'UUID Generator';
    protected string $description = 'Generate UUID v4 identifiers.';
    protected string $viewPath = 'tools.uuid_generator.index';

    public function getSlug(): string { return $this->slug; }
    public function getName(): string { return $this->name; }
    public function getDescription(): string { return $this->description; }

    public function index(Request $request): View
    {
        $this->recordUsage();
        return view($this->viewPath, ['tool' => $this->getToolMeta(), 'title' => $this->name, 'description' => $this->description]);
    }
}
