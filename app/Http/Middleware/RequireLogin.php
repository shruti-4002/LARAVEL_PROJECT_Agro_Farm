<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequireLogin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->session()->has('user')) {
            return redirect()->route('login')->with('status', 'Please login first.');
        }

        return $next($request);
    }
}
