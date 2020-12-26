<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class JsonMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->route() !== null && in_array('api', $request->route()->middleware())) {
            $request->headers->set('Accept', 'application/vnd.api+json');
        }
        return $next($request);
    }
}
