<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Make sure current locale exists else return config('app.locale')
        $locale = $request->segment(1);
        if (!array_key_exists($locale, config('app.available_locales'))) {
            return abort(404);
        }
        app()->setLocale($locale);
        return $next($request);
    }
}
