<?php
namespace Laravel\Http\Controllers;
 
use Illuminate\Http\Request;
 
use Laravel\Http\Requests;
use Laravel\Http\Controllers\Controller;

class helloController extends Controller
{
    // getでhello/にアクセスされた場合
    public function index()
    {
        return view('hello', ['message' => 'Hello world!']);
    }

    public function create()
    {
        return view('test');
    }

	public function show() {
		return view('hello', ['message' => 'Hello world!']);
	}

}