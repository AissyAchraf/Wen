<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Chalet;
use App\Models\Subscription;

class CheckChaletSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $chaletId = $request->route('id');
        
        $chalet = Chalet::find($chaletId);

        if(!$chalet) {
            return redirect()->route('index', ['language'=>\App::getLocale()]);
        }

        // Check if the user is admin or if the hotel has active subscription
        $subscription = Subscription::where('chalet_id', $chalet->id)->where('status', 1)->get()->first();

        if ($chalet && 
                (auth()->user()->role === "admin") || ($subscription && (
                    $subscription->type_id === 2 || 
                    $subscription->type_id === 3
                ))) {
            return $next($request);
        }

        return redirect()->route('subscriptions', ['language'=>\App::getLocale()]);
    }
}
