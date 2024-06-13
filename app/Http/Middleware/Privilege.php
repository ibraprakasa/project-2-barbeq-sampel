<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Privilege extends Middleware
{
    /**
     * The authentication factory instance.
     *
     * @var Auth
     */
    protected $auth;

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string[] ...$guards
     * @return mixed
     *
     * @throws AuthenticationException
     */
//     public function handle($request, Closure $next, ...$guards)
//     {
//         if (strpos($request->url(), 'create') != false) {
//             return redirect('produk')->with('success', 'not permitted');
//         } elseif (strpos($request->url(), 'edit') != false) {
//             return redirect('produk')->with('success', 'not permitted');
//         }

//         if ($request->method()== 'DELETE') {
//             return redirect('produk')->with('success', 'not permitted');
//         }
//         return $next($request);
//     }
}
