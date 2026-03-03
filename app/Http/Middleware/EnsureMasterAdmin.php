<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureMasterAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !$request->user()->isMasterAdmin()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Only the master admin can manage admins.'], 403);
            }
            return redirect()->route('admin.dashboard')->with('error', 'Only the master admin can manage admins.');
        }

        return $next($request);
    }
}
