<?php

namespace App\Tools\JsonFormatter;

use App\Tools\BaseToolController;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JsonFormatterController extends BaseToolController
{
    protected string $slug = 'json-formatter';
    protected string $name = 'JSON Formatter';
    protected string $description = 'Format, validate, and beautify JSON data.';
    protected string $viewPath = 'tools.json_formatter.index';

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

    public function process(Request $request)
    {
        $request->validate(['json' => 'nullable|string']);
        $json = $request->input('json', '');
        $decoded = null;
        $error = null;
        try {
            $decoded = json_decode($json);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $error = json_last_error_msg();
            }
        } catch (\Throwable $e) {
            $error = $e->getMessage();
        }
        return back()->with(compact('decoded', 'error', 'json'));
    }
}
