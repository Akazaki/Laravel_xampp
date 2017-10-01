<?php
namespace Laravel\Http\Controllers;
 
use Illuminate\Http\Request;
 
use Laravel\Http\Requests;
use Laravel\Http\Controllers\Controller;
use Auth;

class WowController extends Controller
{   
	function __construct()
	{
		// loginチェック
		$this->middleware('wowauth');
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

	public function postSignin(Request $request)
	{
		$this->validate($request,[
			'email' => 'email|required',
			'password' => 'required|min:4'
		]);
	
		if(Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])){
			return redirect()->route('user.profile');
		}

		return redirect()->back();
	}
}