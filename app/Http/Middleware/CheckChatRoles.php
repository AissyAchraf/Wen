<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use Auth;
use DB;


class CheckChatRoles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userId = $request->id;

        $user = User::find($userId);

        if(!$user) {
            return redirect()->route('chatify');
        }

        if(!auth()->check()) {
            return redirect()->route('login', ["language"=>'en']);
        }

        $auth_user = Auth::user();

        // Check if the auth user is admin
        if($auth_user->role == "admin") {
            return $next($request);
        } elseif($auth_user->role == "manager" && $user->role == "user") {
            $message = DB::table('ch_messages')->where(['from_id'=>$user->id, 'to_id'=>$auth_user->id])
            ->get()->first();
            if(!$message) {
                return redirect()->route('chatify');
            } else {
                return $next($request);
            }
        } elseif($auth_user->role == "user" && $user->role == "manager") {
            return $next($request);
        } elseif ($user->role == "admin") {
            return $next($request);
        } else {
            return redirect()->route('chatify');
        }
    }
}