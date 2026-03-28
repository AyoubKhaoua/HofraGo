<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login.form');
        }

        $userRole = $user->role?->name;

        if (! in_array($userRole, $roles, true)) {
            abort(403, 'Access denied for this role.');
        }

        return $next($request);
    }
}
