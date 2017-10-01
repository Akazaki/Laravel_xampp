<?php

namespace Laravel\Http\Middleware;
use Illuminate\Support\Facades\Auth;

use Closure;

class WowAuth
{
    /**
     * 送信されてきたリクエストの処理
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //ログイン判定
        //WowAuth::loginCheck();
        if (Auth::check()) {
            return redirect('/wow/login');
        }

        return $next($request);
    }
}
