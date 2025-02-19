<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class MustAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Bisa melewati middleware jika role = Admin
        if (!Auth::check()) {
            abort(404);
        } elseif (Auth::user()->role == 'Admin') {
            return $next($request);
        } else {
            abort(404);
        }
    }
}