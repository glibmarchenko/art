<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class RedirectNonValid
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
        if($request->user()->role === 0) {
            return redirect()->route('register.main');
        }

        if(!$request->user()->name || (!$request->user()->phone && $request->user()->role === 2)) {
            return redirect()->route('register.step1',$request->user()->role);
        }

        return $next($request);
    }
}
