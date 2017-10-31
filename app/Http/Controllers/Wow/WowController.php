<?php
namespace Laravel\Http\Controllers\Wow;
 
use Illuminate\Http\Request;
 
use Laravel\Http\Requests;
use Laravel\Http\Controllers\Controller;
use Auth;
use JWTAuth;
use DB;
use Validator;
use Laravel\Admins;// Model
use Laravel\Posts;// Model

class WowController extends Controller
{   
	function __construct(Request $request)
	{
	}

	public function login(Request $request)
	{
		return view('wow/login');
	}

	public function dashboard(Request $request)
	{
		return view('wow/dashboard');
	}

	// public function signIn(Request $request)
	// {
	// 	$this->validate($request,[
	// 		'email_text' => 'email|required',
	// 		'password' => 'required|min:4'
	// 	]);

	// 	if(Auth::attempt(['email_text' => $request->input('email_text'), 'password' => $request->input('password')])){
	// 		//ログイン成功
	// 	}else{
	// 		return response()->json(['error' => 'invalid_credentials'], 401);
	// 	}

	// 	return response()->json(['status' => 'success', 'user' => Auth::user()->label_text], 200);
	// }
	
	// 登録
	public function signUp(Request $request)
	{
		// バリデーション
		$validator = Validator::make($request->all(), [
            'label_text' => 'required',
			'email_text' => 'email|required|unique:admins',
			'password' => 'required|min:4'
        ]);
        if ($validator->fails()) {
             return response()->json(['error' => $validator->messages()],401);
        }
	 
		// DBインサート
		$user = new Admins([
			'label_text' => $request->input('label_text'),
			'email_text' => $request->input('email_text'),
			'password' => bcrypt($request->input('password'))
		]);
	 
		// 保存
		$user->save();

		if(Auth::attempt(['email_text' => $request->input('email_text'), 'password' => $request->input('password')])){
			return redirect('wow');
		}
	}

	// ログアウト
	public function signOut(){
		//Auth::logout();
		return redirect('wow/login');
	}

	// ログイン処理
	public function signIn(Request $request)
	{
		$this->validate($request,[
			'email_text' => 'email|required',
			'password' => 'required|min:4'
		]);

		// grab credentials from the request
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

		$user = Admins::where('email_text', $request->email_text)->first();

		// all good so return the token
		return response()->json(compact('user', 'token'));
	}

	// ログインチェック
	public function getCurrentUser(Request $request)
	{
		$user = JWTAuth::parseToken()->authenticate();
		return response()->json(compact('user'));
	}
}