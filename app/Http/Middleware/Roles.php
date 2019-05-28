<?php

namespace App\Http\Middleware;

use Closure;

class Roles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$role)
    {

        if($role=="admin"){
            if (auth()->user()->isAdministrator()) {
                return $next($request);
            }
            return redirect('login'); //check this page again


        }
        if($role=="instructor"){
            if (auth()->user()->isInstructor()) {
                return $next($request);
            }
            return redirect('login'); //check this page again
        }






        return $next($request);
    }
}
