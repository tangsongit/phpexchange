<?php

namespace App\Http\Middleware\Auth;

use Closure;

class CheckPaypwd
{
    /**
     * Handle an incoming request.
     * 支付密码未设置
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = auth('api')->user();

        if (!$user || blank($user->payword)){
            return response()->json(['status_code'=>1034,'message'=>'请设置交易密码']);
        }

        return $next($request);
    }
}
