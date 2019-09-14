<?php

namespace App\Http\Middleware;

use App\Preference;
use App\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Closure;

class FirstTime
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $controllerName = class_basename(Route::current()->controller);
        $controller = 'App\\' . substr($controllerName, 0, strrpos($controllerName, 'C'));
        if ($controller == "App\Profile") {
            if ($this->profileExists()) {
                if ($this->preferenceExists()) {
                    return redirect('/recs');
                } else {
                    return redirect('/preferences/create');
                }
            } else {
                return $next($request);
            }
        } elseif ($controller == "App\Preference") {
           if ($this->profileExists()) {
               if ($this->preferenceExists()) {
                   return redirect('/recs');
               } else {
                   return $next($request);
               }
           }  else {
               return redirect('/profiles/create');
           }
        }
        return $next($request);
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
