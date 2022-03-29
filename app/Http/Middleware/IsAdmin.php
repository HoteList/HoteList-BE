<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // error_log($request->user()->role == 'admin');
        // error_log(auth()->user());
        if(auth()->user()->role == 'admin'){
            // print(auth()->user()->role);
            return $next($request);
        }

        return redirect('home')->with('error',"You don't have admin access.");
    }
}
