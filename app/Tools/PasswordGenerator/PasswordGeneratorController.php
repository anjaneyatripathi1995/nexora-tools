<?php

namespace App\Tools\PasswordGenerator;

use App\Tools\BaseToolController;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PasswordGeneratorController extends BaseToolController
{
    protected string $slug = 'password-generator';
    protected string $name = 'Password Generator';
    protected string $description = 'Generate strong random passwords.';
    protected string $viewPath = 'tools.password_generator.index';

    public function getSlug(): string { return $this->slug; }
    public function getName(): string { return $this->name; }
    public function getDescription(): string { return $this->description; }

    public function index(Request $request): View
    {
        $this->recordUsage();
        return view($this->viewPath, ['tool' => $this->getToolMeta(), 'title' => $this->name, 'description' => $this->description]);
    }
}
