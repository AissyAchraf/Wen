<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!auth()->check()) {
            return redirect()->route('login', ['language'=>\App::getLocale()]);
        }

        // Check if the user is authenticated and has the 'admin' role
        if (auth()->check() && auth()->user()->role === "admin") {
            
            return $next($request);
        }

        // If the user is not an admin, you can redirect them to an error page or any other appropriate action
        return redirect()->route('index', ['language'=>\App::getLocale()]);
    }
}
