<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class VerifyUserUrl
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
        $roles = Cache::rememberForever('roles', function () {
            return Role::all()->mapWithKeys(function ($role) {
                return [$role['url'] => $role['name']];
            })->toArray();
        });

        // Check if Request Segment(2) exist in roles table
        if (!array_key_exists($request->segment(2), $roles)) {
            return abort(404);
        }

        // Check if Request Segment(2) is equal to Authenticated User url
        if ($request->segment(2) !== auth()->user()->type->url) {
            return abort(403, "You are a " . $request->user()->type->role->name);
        }

        return $next($request);
    }
}
