<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $param)
    {
        if (Auth::guest()) {
            return redirect()->route('login');
        }else{

                $is_permission = \App\Permission::where('role_id',Auth::user()->role_id)
                ->whereIn('route_name',explode('|', $param))
                ->get()
                ->count();

                if(!$is_permission){
                    abort(401);
                }

        }

        return $next($request);
    }
}
