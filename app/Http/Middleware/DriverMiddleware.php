<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DriverMiddleware
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {
        if (
            !$request->user() ||
            $request->user()->role !== 'driver'
        ) {
            abort(403, 'Unauthorized driver access.');
        }

        return $next($request);
    }
}