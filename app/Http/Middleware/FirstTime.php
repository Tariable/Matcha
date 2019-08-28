<?php

namespace App\Http\Middleware;

use App\Preference;
use Illuminate\Support\Facades\Auth;
use Closure;

class FirstTime
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Preference::where('profile_id', Auth::id())) {
            return redirect('/');
        }
        return $next($request);
    }
}
