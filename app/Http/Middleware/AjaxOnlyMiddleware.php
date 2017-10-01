<?php

namespace App\Http\Middleware;

use Closure;

class AjaxOnlyMiddleware
{
	/**
	 * Handle an incoming request.
	 *
	 * @param	 \Illuminate\Http\Request $request
	 * @param	 \Closure $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		// リクエストがajaxではない場合の処理
		if (!$request->ajax()) {
			// viewを表示させたい場合 view('someView')という風に記述できます。

			return return response()->json(['status' => 'error']);
		}
		
		// ajaxからのアクセスだと、そのまま次の処理に進みます
		return $next($request);
	}
}