<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class SetLang
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
        $user_locale = $request->header("lang");
//        dd($user_locale);
        if(empty($user_locale) || !in_array($user_locale, ['cn', 'en'])) {
//           $user_locale = 'en';
            $user_locale = 'zh-CN';
        }
        if($user_locale == 'cn') $user_locale = 'zh-CN';
        $app_locale = App::getLocale();
//        dd($app_locale);
        if($app_locale !==  $user_locale) {
            App::setLocale($user_locale);
        }
//        dd(App::getLocale());
        return $next($request);
    }
}
