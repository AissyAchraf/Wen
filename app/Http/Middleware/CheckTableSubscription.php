<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Table;
use App\Models\Restaurent;
use App\Models\Subscription;

class CheckTableSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $tableId = $request->route('id');
        
        $table = Table::find($tableId);

        if(!$table) {
            return redirect()->route('index', ['language'=>\App::getLocale()]);
        }

        $restaurant = Restaurent::find($table->restaurent_id);

        if(!$restaurant) {
            return redirect()->route('index', ['language'=>\App::getLocale()]);
        }

        $subscription = Subscription::where('restaurant_id', $restaurant->id)->where('status', 1)->get()->first();

        if ($restaurant && 
                (auth()->user()->role === "admin") || ($subscription && (
                    $subscription->type_id === 2 || 
                    $subscription->type_id === 3
                ))) {
            return $next($request);
        }

        return redirect()->route('subscriptions', ['language'=>\App::getLocale()]);
    }
}
