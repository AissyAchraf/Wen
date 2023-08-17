<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Chalet;

class CheckChaletManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get the hotel ID from the route parameters
        $chaletId = $request->route('id');

        // Get the authenticated user
        $user = auth()->user();

        if(!$user) {
            return redirect()->route('login', ['language'=>\App::getLocale()]);
        }

        // Check if the user is logged in and is the manager of the hotel
        if ($user && ($user->id === Chalet::find($chaletId)->user_manager || auth()->user()->role === "admin")) {
            return $next($request);
        }

        // If the user is not the manager, redirect to an error page or any other appropriate action
        return redirect()->route('index', ['language'=>\App::getLocale()]);
    }
}
