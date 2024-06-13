<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class isSuperadmin
{
    public function handle($request, Closure $next)
    {
        if (!auth()->user()->issuperadmin) {
            abort(403);
        }

        return $next($request);
    }
}
