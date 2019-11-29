<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Cookie;

class Language
{
    public function handle($request, \Closure $next)
    {
        $locale = $request->cookie('locale', session('locale'));
        if (array_key_exists($locale, config('app.languages'))) {
            Cookie::queue('locale', $locale);
            app()->setLocale($locale);
            Carbon::setLocale($locale);
        } else { // This is optional as Laravel will automatically set the fallback language if there is none specified
            app()->setLocale(config('app.fallback_locale'));
            Carbon::setLocale(config('app.fallback_locale'));
            Cookie::queue('locale', config('app.fallback_locale'));
        }

        return $next($request);
    }
}