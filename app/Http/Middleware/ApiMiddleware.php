<?php

namespace App\Http\Middleware;

use Auth;
use JWTAuth;
use Closure;
use Illuminate\Http\Request;

class ApiMiddleware
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
        //$user = Auth::user();

        // if($user->accesible){
        //     // redirect page or error.
        // }


        // if (Auth::check()) {
        //     return $next($request);
        // } else {
        //     return response()->json('Unauthorized.', 401);
        // }



    }
}
