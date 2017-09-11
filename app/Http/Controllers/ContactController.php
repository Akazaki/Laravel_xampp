<?php

namespace Laravel\Http\Controllers;
 
use Illuminate\Http\Request;
 
use Laravel\Http\Requests;
use Laravel\Http\Controllers\Controller;

class ContactController extends Controller
{
    public function form()
    {
        return view('form');
    }

	public function confirm(Request $request)
	{
	    $this->validate($request, [
	        'name'  => 'required',
	        'email' => 'required|email',
	        'message' => 'present',
	    ]);

	    $contact = $request->all();

	    return view('confirm', compact('contact'));
	}
    
	public function process(Request $request)
	{
        // ※要バリデーション
        $action = $request->get('action', 'back');
        // 二つ目は初期値です。
        $input = $request->except('action');
        
        // そして、入力内容からは取り除いておきます。
        if($action === 'submit') {
            // メール送信処理などを実装
			return view('complete');
        } else {
            // 戻る
			return redirect()->action('ContactController@form')->withInput($input);
	    }
	}
}