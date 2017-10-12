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
	public function handle($request, Closure $next)
	{
        $credentials = $request->only('email_text', 'password');

		try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        
        return response()->json(['sssss' => 'could_not_create_token'], 200);

		//ログイン判定
		//WowAuth::loginCheck();
		// if (!$request->is('wow/login') /*&& Auth::check()*/) {
		//		 return redirect('/wow/login');
		// }
	}
}
