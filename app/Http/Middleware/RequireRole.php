<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequireRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->session()->get('user');

        if (! $user || ! in_array($user['role'] ?? null, $roles, true)) {
            return redirect()->route('home')->with('status', 'This area is not available for your role.');
        }

        return $next($request);
    }
}
