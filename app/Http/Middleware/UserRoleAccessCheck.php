<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Session\Session;

class UserRoleAccessCheck
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

         $userId = Session::get('userId') ;
        $method = strtoupper($request->getMethod());
        DB::table('user')
            ->join('user_role', 'user.id', '=', 'user_role.user_id')
            ->join('role_access', 'user_role.role_id', '=', 'role_access.role_id')
            ->join('access', 'access.id', '=', 'role_access.access_id')
            ->select('access.id', 'access.urls', 'access.method')
            ->where('user.id','=',$userId)
            ->where('access.method','=',$method)
            ->get();

        return $next($request);
    }
}
