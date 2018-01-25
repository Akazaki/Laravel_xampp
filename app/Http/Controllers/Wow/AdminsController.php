<?php
namespace Laravel\Http\Controllers\Wow;
 
use Illuminate\Http\Request;
 
use Laravel\Http\Requests;
use Laravel\Http\Controllers\Controller;
use Laravel\Http\Controllers\Wow\WowEditController;
use Laravel\Http\Requests\AdminRequest;// バリデート
use Auth;
use JWTAuth;
use DB;
use Laravel\Admins;// Model

class AdminsController extends Controller
{
	var $_tableName = 'admins';
	var $WowEdit;

	function __construct()
	{
		$this->WowEdit = new WowEditController;
	}

	// 記事取得
	public function postList(Request $request)
	{
		$_listColumns = ['id', 'タイトル', '公開時刻', '公開状態'];
		$get_postnum = 5;
		
		$query = Admins::query();
		$search = $request->searchValue;
		$acknowledge = $request->acknowledge;

		// 検索
		$posts['posts'] = $query->orderBy('id','desc')
						//検索あれば
						->when($search, function ($query) use ($search) {
							return $query->where('label_text', 'like', '%'.$request->searchValue.'%');
        				})
        				//公開されている記事のみ
						->when($acknowledge, function ($query) use ($acknowledge) {
							return $query->where('acknowledge_radio', $acknowledge);
        				})
        				->paginate($get_postnum);
        				
		$posts['_listColumns'] = $_listColumns;

		return $posts;
	}

	// 記事取得
	public function postEdit(Request $request)
	{
		$this->validate($request,[
			'id' => 'integer|required'
		]);

		// 編集項目
		$_editColumns = ['label_text', 'email_text', 'password', 'created_at'];
		$_editColumnsName = ['label_text'=>'タイトル', 'email_text'=>'メールアドレス', 'password'=>'パスワード', 'created_at'=>'公開時刻'];

		$query = Admins::query();

		if((INT)$request->id > 0){
			// データ取得
			$post['post'] = $query->where('id', (INT)$request->id)->get($_editColumns)->first();
		}else{
			// 新規作成
			$post['post'] = $this->WowEdit->getEmptyData($_editColumns);
			$post['post'] = $post['post'][0];
		}

		$tmpArray = [];
		$post = json_decode(json_encode($post), true);
		foreach ($post['post'] as $key => $value) {
			$tmpArray['post'][$key] = [
				'title' => $_editColumnsName[$key],
				'data' => $value,
				'error' => '',
			];

			// パスワードあれば確認追加
			if($key === 'password'){
				$tmpArray['post']['password_confirmation'] = [
					'title' => 'パスワード確認',
					'data' => '',
					'error' => '',
				];
			}
		}

		return $tmpArray;
	}

	//記事保存
	public function postDoneEdit(AdminRequest $request)
	{
		$result = false;
		$res['res'] = false;
		if(!empty($request) && isset($request->id)){
			$rows = $request->rows;
			$id = (int)$request->id;

			$result = $this->WowEdit->doneEdit($rows, $this->_tableName, $id);

			if($result){
				$res['res'] = true;
			}
		}

		return $res;
	}
}