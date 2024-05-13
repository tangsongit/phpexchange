<?php

namespace App\Http\Middleware;

use Closure;

class CheckTransactionCode
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
        $switch = false;
        if (!$switch) return $next($request);

        try {
            $user = auth('api')->user();

            if ($user) {
                $purchase_code = $user['purchase_code'] ?? null;
                if (empty($purchase_code)) return api_response()->error(40002, 'You have not filled in the transaction code');
            }
        } catch (\Exception $exception) {
            return api_response()->error(0, 'error');
        }

        return $next($request);
    }
}
