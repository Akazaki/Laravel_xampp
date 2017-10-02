<?php
namespace Laravel\Http\Controllers;
 
use Illuminate\Http\Request;
 
use Laravel\Http\Requests;
use Laravel\Http\Controllers\Controller;
use Auth;
use Laravel\Admins;// Model

class WowController extends Controller
{   
	function __construct(Request $request)
	{
		// loginチェック
		//$this->middleware('wowauth');
	}

	public function index(Request $request)
	{
		return view('/wow/dashboard');
	}

	public function login(Request $request)
	{
		return view('wow/login');
	}

	public function dashboard(Request $request)
	{
		return view('wow/dashboard');
	}

	public function signin(Request $request)
	{
		$this->validate($request,[
			'email_text' => 'email|required',
			'password' => 'required|min:4'
		]);

		if(Auth::attempt(['email_text' => $request->input('email_text'), 'password' => $request->input('password')])){
			return redirect('wow');
		}

		return redirect()->back();
	}

	public function register(Request $request)
	{
		return view('wow/register');
	}

	public function signup(Request $request)
	{
		// バリデーション
		$this->validate($request,[
			'label_text' => 'required',
			'email_text' => 'email|required|unique:admins',
			'password' => 'required|min:4'
		]);
	 
		// DBインサート
		$user = new Admins([
			'label_text' => $request->input('label_text'),
			'email_text' => $request->input('email_text'),
			'password' => bcrypt($request->input('password'))
		]);
	 
		// 保存
		$user->save();
	 
		// リダイレクト
		return redirect('wow');
	}

	public function signout(){
		Auth::logout();
		return redirect('wow/login');
	}
}