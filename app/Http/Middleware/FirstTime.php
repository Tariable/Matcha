<?php

namespace App\Http\Middleware;

use App\Preference;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
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
        $controllerName = class_basename(Route::current()->controller);
        $controller = 'App\\' . substr($controllerName, 0, strrpos($controllerName, 'C'));
        if ($controller::where('id', Auth::id())->first() !== null) {
            return redirect('/');
        }
        return $next($request);
    }
}
