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

	public function signIn(Request $request)
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

	public function signUp(Request $request)
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

		if(Auth::attempt(['email_text' => $request->input('email_text'), 'password' => $request->input('password')])){
			return redirect('wow');
		}
	}

	public function signOut(){
		Auth::logout();
		return redirect('wow/login');
	}

	public function postList($table){
		dd($table);
		return view('wow/postlist');
	}
}