<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Restaurent;
use App\Models\Table;

class CheckTableManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get the table ID from the route parameters
        $tableId = $request->route('id');
        
        // Get the authenticated user
        $user = auth()->user();

        if(!$user) {
            return redirect()->route('login', ['language'=>\App::getLocale()]);
        }

        $table = Table::find($tableId);

        if(!$table) {
            return redirect()->route('index', ['language'=>\App::getLocale()]);
        }

        // Check if the user is logged in and is the manager of the restaurent or is the admin
        if ($user && ($user->id === Restaurent::find($table->restaurent_id)->user_manager || auth()->user()->role === "admin")) {
            return $next($request);
        }

        // If the user is not the manager and is not admin, redirect to an error page or any other appropriate action
        return redirect()->route('index', ['language'=>\App::getLocale()]);
    }
}
