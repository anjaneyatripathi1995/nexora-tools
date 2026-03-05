<?php

namespace App\Http\Controllers;

use App\Tools\ToolRegistry;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Dispatches /tools/{slug} to the correct App\Tools\* controller.
 * Keeps existing tools (from old ToolController) working by falling back.
 */
class ToolsDispatcherController extends Controller
{
    public function __construct()
    {
        ToolRegistry::registerDefaultTools();
    }

    public function show(Request $request, string $slug)
    {
        $controller = ToolRegistry::getController($slug);
        if ($controller) {
            return $controller->index($request);
        }
        // Fallback to existing ToolController for legacy tools (emi-calculator, etc.)
        return app(ToolController::class)->show($slug);
    }

    public function process(Request $request, string $slug)
    {
        $controller = ToolRegistry::getController($slug);
        if ($controller && method_exists($controller, 'process')) {
            return $controller->process($request);
        }
        return back();
    }
}
