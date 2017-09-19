<?php

namespace Laravel\Http\Controllers;
 
use Illuminate\Http\Request;
 
use Laravel\Http\Requests;
use Laravel\Http\Controllers\Controller;

use Laravel\Http\Requests\ContactRequest;

class ContactController extends Controller
{
    public function form()
    {
        return view('form');
    }

	public function confirm(ContactRequest $request)
	{
	    $contact = $request->all();

	    return view('confirm', compact('contact'));
	}
    
	public function complete(Request $request)
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