<?php

namespace Laravel\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\AjaxOnlyMiddleware as Middleware;
// use Closure;

class AjaxOnlyMiddleware
{
	/**
	 * Handle an incoming request.
	 *
	 * @param	 \Illuminate\Http\Request $request
	 * @param	 \Closure $next
	 * @return mixed
	 */
	public function handle($request)
	{
		// リクエストがajaxではない場合の処理
		if (!$request->ajax()) {
			// viewを表示させたい場合 view('someView')という風に記述できます。

			return response()->json(['status' => 'error'], 405);
		}
	}
}