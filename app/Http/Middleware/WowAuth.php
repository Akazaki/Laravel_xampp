<?php

namespace Laravel\Http\Middleware;
use Illuminate\Support\Facades\Auth;

use Closure;

class WowAuth
{
	/**
	 * 送信されてきたリクエストの処理
	 *
	 * @param	\Illuminate\Http\Request	$request
	 * @param	\Closure	$next
	 * @return mixed
	 */
	public function handle($request, Closure $next, $guard = null)
	{
		if (Auth::guard($guard)->guest()) {
			if ($request->ajax() || $request->wantsJson()) {
				return response('Unauthorized.', 401);
			} else {
				return redirect('/wow/login');
			}
		}

		//ログイン判定
		//WowAuth::loginCheck();
		// if (!$request->is('wow/login') /*&& Auth::check()*/) {
		//		 return redirect('/wow/login');
		// }

		return $next($request);
	}
}
