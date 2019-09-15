<?php

namespace App\Http\Middleware;

use Closure;
use App\Preference;
use App\Profile;
use Illuminate\Support\Facades\Auth;

class ProfileExists
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
        if ($this->profileExists()) {
            if ($this->preferenceExists()) {
                return $next($request);
            } else {
                return redirect('/preferences/create');
            }
        } else {
            return redirect('/profiles/create');
        }
    }

    public function profileExists()
    {
        return Profile::where('id', Auth::id())->first() ? 1 : 0;
    }


    public function preferenceExists()
    {
        return Preference::where('id', Auth::id())->first() ? 1 : 0;
    }
}
