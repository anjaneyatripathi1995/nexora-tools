<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use App\Http\Controllers\ToolController as PublicToolController;
use Illuminate\Http\Request;

class ToolController extends Controller
{
    public function index()
    {
        $tools = Tool::orderBy('category')->orderBy('name')->paginate(20);
        return view('admin.tools.index', compact('tools'));
    }

    public function create()
    {
        $categories = array_keys(PublicToolController::fullCatalog());
        return view('admin.tools.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:tools,slug',
            'category' => 'required|string|max:128',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:64',
            'is_active' => 'boolean',
        ]);
        $data['is_active'] = $request->boolean('is_active', true);
        Tool::create($data);
        return redirect()->route('admin.tools.index')->with('success', 'Tool created.');
    }

    public function edit(Tool $tool)
    {
        $categories = array_keys(PublicToolController::fullCatalog());
        return view('admin.tools.edit', compact('tool', 'categories'));
    }

    public function update(Request $request, Tool $tool)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:tools,slug,' . $tool->id,
            'category' => 'required|string|max:128',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:64',
            'is_active' => 'boolean',
        ]);
        $data['is_active'] = $request->boolean('is_active', true);
        $tool->update($data);
        return redirect()->route('admin.tools.index')->with('success', 'Tool updated.');
    }

    public function destroy(Tool $tool)
    {
        $tool->delete();
        return redirect()->route('admin.tools.index')->with('success', 'Tool deleted.');
    }
}
