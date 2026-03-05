<?php

namespace App\Tools;

use App\Models\Tool as ToolModel;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Base controller for all SaaS tools. Each tool module extends this.
 */
abstract class BaseToolController
{
    protected string $slug;
    protected string $name;
    protected string $description;
    protected string $viewPath;

    /** Tool slug for URL (e.g. temp-mail, json-formatter). */
    abstract public function getSlug(): string;

    /** Display name. */
    abstract public function getName(): string;

    /** Short description for meta and listing. */
    abstract public function getDescription(): string;

    /** Blade view path for the tool UI. */
    public function getViewPath(): string
    {
        return $this->viewPath ?: 'tools.' . str_replace('-', '_', $this->getSlug());
    }

    /** Optional: handle POST (process form). */
    public function process(Request $request)
    {
        return back();
    }

    /** Show the tool page. */
    public function index(Request $request): View
    {
        $this->recordUsage();
        return view($this->getViewPath(), [
            'tool' => $this->getToolMeta(),
            'title' => $this->getName(),
            'description' => $this->getDescription(),
        ]);
    }

    protected function getToolMeta(): array
    {
        return [
            'slug' => $this->getSlug(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
        ];
    }

    protected function recordUsage(): void
    {
        $tool = ToolModel::where('slug', $this->getSlug())->first();
        if ($tool) {
            \App\Models\ToolUsageStat::record($tool->id);
        }
    }
}
