<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRolePermission
{
    public function handle(Request $request, Closure $next, $permission): Response
    {
        $user = $request->user();

        if (!$user || !$user->role || !in_array($permission, $user->role->permissions ?? [])) {
            abort(403, 'Akses Ditolak.');
        }

        return $next($request);
    }
}

