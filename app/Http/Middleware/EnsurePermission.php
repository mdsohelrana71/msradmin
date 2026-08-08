<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsurePermission
{
    public function handle(Request $request, Closure $next, string $permission)
    {
        /** @var Authorizable|null $user */
        $user = Auth::user();

        if (! $user || ! $user->can($permission)) {
            abort(403);
        }

        return $next($request);
    }
}
