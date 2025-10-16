<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
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
        try{
            $activeModule = Auth::user()->active_modules;
            $moduleId = $request->id;
            if (!$moduleId){

                if (str_contains($request->url(), 'link') ||
                str_contains($request->url(), 'shorten') ||
                str_contains($request->url(), 'api/s/')
                ){
                    $moduleId = 1;
                }
            }

            if (!$activeModule || !in_array($moduleId, $activeModule)){
                return response()->json((object)[
                    "error" => "Module inactive. Please activate this module to use it."
                ], 403);
            }
        } catch (Exception $ex){
            return response()->json((object)[
                "error" => "Module inactive. Please activate this module to use it."
            ], 403);
        }
        return $next($request);
    }
}
