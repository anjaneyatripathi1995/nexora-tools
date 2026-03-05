<?php

namespace App\Tools\TempMail;

use App\Tools\BaseToolController;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TempMailController extends BaseToolController
{
    protected string $slug = 'temp-mail';
    protected string $name = 'Temp Mail';
    protected string $description = 'Disposable temporary email address for quick signups and testing.';
    protected string $viewPath = 'tools.temp_mail.index';

    public function getSlug(): string { return $this->slug; }
    public function getName(): string { return $this->name; }
    public function getDescription(): string { return $this->description; }
    public function getViewPath(): string { return $this->viewPath; }

    public function index(Request $request): View
    {
        $this->recordUsage();
        return view($this->viewPath, [
            'tool' => $this->getToolMeta(),
            'title' => $this->name,
            'description' => $this->description,
        ]);
    }
}
