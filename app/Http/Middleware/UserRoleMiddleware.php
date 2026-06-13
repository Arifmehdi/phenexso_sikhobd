<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use function League\Flysystem\has;

class UserRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        $roles = explode('|', $role);
        
        foreach ($roles as $r) {
            if ($request->user()->hasRole($r)) {
                return $next($request);
            }
        }

        abort(401);
    }
}
