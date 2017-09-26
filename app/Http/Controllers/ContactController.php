<?php

namespace Laravel\Http\Controllers;
 
use Illuminate\Http\Request;
 
use Laravel\Http\Requests;
use Laravel\Http\Controllers\Controller;

use Laravel\Http\Requests\ContactRequest;
use Intervention\Image\Facades\Image;

class ContactController extends Controller
{
    public $prefecture_master = [
        1 => '北海道', 
        '青森県', 
        '岩手県', 
        '宮城県',
        '秋田県', 
        '山形県', 
        '福島県', 
        '茨城県',
        '栃木県', 
        '群馬県', 
        '埼玉県', 
        '千葉県',
        '東京都', 
        '神奈川県', 
        '新潟県', 
        '富山県',
        '石川県', 
        '福井県', 
        '山梨県', 
        '長野県', 
        '岐阜県', 
        '静岡県', 
        '愛知県', 
        '三重県',
        '滋賀県', 
        '京都府', 
        '大阪府', 
        '兵庫県',
        '奈良県', 
        '和歌山県', 
        '鳥取県', 
        '島根県',
        '岡山県', 
        '広島県', 
        '山口県', 
        '徳島県',
        '香川県',
        '愛媛県',
        '高知県', 
        '福岡県',
        '佐賀県', 
        '長崎県', 
        '熊本県', 
        '大分県',
        '宮崎県', 
        '鹿児島県', 
        '沖縄県'
    ];

    public $age_master = [
        1 => '20',
        '30',
        '40'
    ];

    public $hobby_master = [
        1 => 'Football',
        'Basketball',
        'Swimming'
    ];

    /**
     * 入力画面
     *
     */
    public function form()
    {
        $prefecture_master = $this->prefecture_master;
        return view('form', compact('prefecture_master'));
    }

    /**
     * 確認画面
     *
     * @param  ContactRequest  $request
     */
	public function confirm(ContactRequest $request)
	{
        // $request->validate($request, [
        //     'name' => 'required|unique:posts|zip'
        // ]);

	    $contact = $request->all();

        // 年齢のマスター参照
        $contact['age_text'] = $this->age_master[(int)$contact['age']];

        // 住所のマスター参照
        $contact['prefecture_text'] = $this->prefecture_master[(int)$contact['prefecture']];

        // 趣味のマスター参照
        foreach ($contact['hobby'] as $key => $value) {
            $contact['hobby_text'][$key] = $this->hobby_master[(int)$contact['hobby'][$key]];
        }

// if(!empty($contact['upfile'])){
//     //getClientOriginalName():アップロードしたファイルのオリジナル名を取得します
//     $upfile = str_shuffle(time().$contact['upfile']->getClientOriginalName()). '.' . $contact['upfile']->getClientOriginalExtension();
//     //$upfile =  $contact['upfile']->getClientOriginalName();
//     //getRealPath():アップロードしたファイルのパスを取得します。
//     $image = Image::make($contact['upfile']->getRealPath());
//     //画像を保存する
//     $image->save(public_path().'/tmpfile/'.$upfile);
//     //パス
//     $contact['img_path'] = '/public/tmpfile/'.$upfile;
// }else if(!empty($contact['img'])){
//     //パス
//     $contact['img_path'] = $contact['img'];
// }

	    return view('confirm', compact('contact'));
	}
    
    /**
     * 完了画面
     *
     * @param  Request  $request
     */
	public function complete(ContactRequest $request)
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