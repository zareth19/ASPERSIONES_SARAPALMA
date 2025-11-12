<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class FincaAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() && !session('finca_logged')) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}