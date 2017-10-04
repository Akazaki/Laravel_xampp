<?php
namespace Laravel\Http\Controllers;
 
use Illuminate\Http\Request;
 
use Laravel\Http\Requests;
use Laravel\Http\Controllers\Controller;
use Auth;
use Laravel\Admins;// Model

class WowUserController extends Controller
{   
	function __construct(Request $request)
	{
	}

	public function user(){
		return view('wow/postlist');
	}
}