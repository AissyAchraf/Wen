<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\Subscription;

class CheckRoomSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $roomId = $request->route('id');
        
        $room = Room::find($roomId);

        if(!$room) {
            return redirect()->route('index', ['language'=>\App::getLocale()]);
        }

        $hotel = Hotel::find($room->hotel);

        if(!$hotel) {
            return redirect()->route('index', ['language'=>\App::getLocale()]);
        }

        // Check if the user is admin or if the hotel has active subscription
        $subscription = Subscription::where('hotel_id', $hotel->id)->where('status', 1)->get()->first();

        if ($hotel && 
                (auth()->user()->role === "admin") || ($subscription && (
                    $subscription->type_id === 2 || 
                    $subscription->type_id === 3
                ))) {
            return $next($request);
        }

        return redirect()->route('subscriptions', ['language'=>\App::getLocale()]);
    }
}
