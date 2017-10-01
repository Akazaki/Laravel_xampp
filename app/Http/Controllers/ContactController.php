<?php

namespace Laravel\Http\Controllers;
 
use Illuminate\Http\Request;
 
use Laravel\Http\Requests;
use Laravel\Http\Controllers\Controller;

use Laravel\Http\Requests\ContactRequest;// バリデート
use Intervention\Image\Facades\Image;// 画像処理
use Laravel\Contact;// Model

class ContactController extends Controller
{
		public $prefecture_master = [
				1 => '北海道', '青森県', '岩手県', '宮城県','秋田県', '山形県', '福島県', '茨城県','栃木県', '群馬県', '埼玉県', '千葉県','東京都', '神奈川県', '新潟県', '富山県','石川県', '福井県', '山梨県', '長野県', '岐阜県', '静岡県', '愛知県', '三重県','滋賀県', '京都府', '大阪府', '兵庫県','奈良県', '和歌山県', '鳥取県', '島根県','岡山県', '広島県', '山口県', '徳島県','香川県','愛媛県','高知県', '福岡県','佐賀県', '長崎県', '熊本県', '大分県','宮崎県', '鹿児島県', '沖縄県'
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

		private $tmp_path = '/public/tmpfile/';
		private $uploads_path = '/uploads/';

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
	 
		if($action === 'submit') {

			//$data = $request->all();
			$hobby = array_sum($request->get('hobby'));//配列の値の合計

			//画像uploadsにcopy
			if($request->get('img_path')){
				$img_path = base_path().$request->get('img_path');
				if(file_exists($img_path)){
					$file_info = pathinfo($img_path);
					$img_extension = strtolower($file_info['extension']);
					$uploads_file = base_path().$this->uploads_path.md5(sha1(uniqid(mt_rand(), true))).'.'.$img_extension;
					copy($img_path, $uploads_file);
				}
			}

			//DB保存
			$data = [
				"name" => $request->get('name'),
				"email" => $request->get('email'),
				"tel" => $request->get('tel'),
				"zip" => $request->get('zip'),
				"prefecture" => $request->get('prefecture'),
				"address" => $request->get('address'),
				"age" => $request->get('age')[0],
				"hobby" => $hobby,
				"upfile" => $request->get('img_name'),
				"message" => $request->get('message'),
			];

			$contact = new Contact;

			$contact->fill($data)->save();
			//$contact->fill($request->all())->save();

			//$contact['name'] = $request->get('name');
			//$user->where('id', $id)->update(array('status' => $status));
			// $contact->fill($data);
			// //$contact->name = $request->get('name');
			// // $contact->email = $request->get('email');
			// $contact->save();

			return view('complete');
		} else {
			// 戻る
			return redirect()->action('ContactController@form')->withInput($input);
		}
	}


}