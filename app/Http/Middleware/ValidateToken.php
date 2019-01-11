<?php

namespace App\Http\Middleware;

use Closure;

class ValidateToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->get('token') != env('API_TOKEN')) {
            return abort(403);
        }
        return $next($request);
    }
}
