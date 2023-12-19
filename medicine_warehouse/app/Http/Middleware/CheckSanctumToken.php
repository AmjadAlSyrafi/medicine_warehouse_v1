<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSanctumToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {           if (!$request->bearerToken()){
                     return $next($request);
    }
                // Check if the request has a valid Sanctum token
                if (!$request->bearerToken() || !auth()->guard('sanctum')->check()) {
                    return response()->json([
                        'status' => 'false.',
                        'error' => 'Unauthorized. Sanctum token is missing or invalid.'
                    ], 401);
                }
        return $next($request);
    }
}
