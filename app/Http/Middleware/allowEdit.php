<?php

namespace App\Http\Middleware;

use Closure;
use App\Preference;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class allowEdit
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
        if (!$controller::where('id', Auth::id())->exists()) {
            $path = lcfirst(substr($controllerName, 0, strrpos($controllerName, 'C'))) . "s/create";
            return redirect($path);
        }
        return $next($request);
    }
}
