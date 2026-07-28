<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->is_admin)) {
            return $next($request);
        }

        return redirect()->route('dashboard')->with('error', 'Acesso restrito para administradores.');
    }
        
}