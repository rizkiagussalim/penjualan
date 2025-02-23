<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePembeli
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()->role !== 'pembeli') {
            abort(403, 'Akses ditolak.');
        }
        return $next($request);
    }
}

