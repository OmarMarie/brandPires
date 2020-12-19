<?php

namespace App\Http\Middleware;

use App\Models\Player;
use App\User;
use Closure;
use Auth;
use Cache;
use Carbon\Carbon;

class LastUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $expiresAt = Carbon::now()->addMinutes(1);
            Cache::put('user-is-online-' . auth()->user()->id, true, $expiresAt);
            Player::where('id', auth()->user()->id)->update([
                'is_online' => 1,
                'last_activity' => now()
            ]);
        }
        return $next($request);
    }
}