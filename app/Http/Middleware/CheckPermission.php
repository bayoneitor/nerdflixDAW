<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $roles)
    {
        $roles_ar = explode('|', $roles);

        foreach($roles_ar as $role){
            if ($request->user()->hasRole($role)) {
                return $next($request);
            }
        }
        abort(403,"Non authorized");
    }
}
