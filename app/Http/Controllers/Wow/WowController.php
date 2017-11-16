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
	function __construct()
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
             return response()->json(['error' => $validator->messages()],422);
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

	 /**
	 * マスターデータ取得
	 * @param {table_name} string - 
	 */
	public function getMasterData(Request $request)
	{
		// $this->validate($request,[
		// 	'id' => 'integer|required'
		// ]);

		//radioとcheckboxのマスターデータ取得
		if(strpos($request->table_name,'_radio') !== false){
			$table_name = str_replace('_radio', '', $request->table_name);
			$master = DB::table($table_name)->get();
		}else if(strpos($request->table_name,'_check') !== false){
			$table_name = str_replace('_check', '', $request->table_name);
			$master = DB::table($table_name)->get();
		}

		//カテゴリ名のみ摘出
		$master_data = array();
		if(!empty($master)){
			foreach($master as $r){
				$master_data[$r->id] = $r->label_text;
			}
		}
		
		return $master_data;
	}
	
	 /**
	 * メニューデータ取得
	 */
	public function getMenuData()
	{
		$_tableName = 'wowmenu';

		$menu_data = DB::table($_tableName)->get();

		return $menu_data;
	}
}