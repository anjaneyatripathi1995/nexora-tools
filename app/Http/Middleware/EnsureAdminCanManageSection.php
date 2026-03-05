<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminCanManageSection
{
    public function handle(Request $request, Closure $next, string $section): Response
    {
        if (!$request->user() || !$request->user()->canManage($section)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'You do not have access to manage this section.'], 403);
            }
            return redirect()->route('admin.dashboard')->with('error', 'You do not have access to manage this section.');
        }

        return $next($request);
    }
}
