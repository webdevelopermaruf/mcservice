<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminLoggedIn
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->to('/admin/login');
        }
        return $next($request);
    }
}
