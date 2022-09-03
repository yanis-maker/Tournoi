<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $perm)
    {
        if(Auth::user()->permission >= $perm){
            return $next($request);
        }else{
            abort(403, "Vous n'avez pas les droits nécessaires pour accéder à cette page");
        }
    }
}
