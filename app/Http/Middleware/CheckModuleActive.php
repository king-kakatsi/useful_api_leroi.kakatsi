<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckModuleActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $activeModule = Auth::user()->active_modules;
        if (!$activeModule || !in_array($request->id, $activeModule)){
            return response()->json((object)[
                "error" => "Module inactive. Please activate this module to use it."
            ], 403);
        }
        return $next($request);
    }
}
