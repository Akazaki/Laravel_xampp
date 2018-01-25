<?php
namespace Laravel\Http\Controllers\Wow;
 
use Illuminate\Http\Request;
 
use Laravel\Http\Requests;
use Laravel\Http\Controllers\Controller;
use Laravel\Http\Controllers\Wow\WowEditController;
use Laravel\Http\Requests\PostRequest;// バリデート
use Auth;
use JWTAuth;
use DB;
use Laravel\Posts;// Model

class PostsController extends Controller
{
	var $_tableName = 'posts';
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
		
		$query = Posts::query();
		$search = $request->searchValue;
		$acknowledge = $request->acknowledge;

		// 検索
		$posts['posts'] = $query->orderBy('id','desc')
						//検索あれば
						->when($search, function ($query) use ($search) {
							return $query->where('label_text', 'like', '%'.$request->searchValue.'%');
        				})
        				//acknowledgeあれば
						->when($acknowledge, function ($query) use ($acknowledge) {
							return $query->where('acknowledge_radio', $acknowledge);
        				})
        				->paginate($get_postnum);

		$posts['_listColumns'] = $_listColumns;

		return $posts;
	}

	// 個別記事取得
	public function postEdit(Request $request)
	{
		$this->validate($request,[
			'id' => 'integer|required'
		]);

		// 編集項目
		$_editColumns = ['label_text', 'detail_richtext', 'main_file', 'postscategory_check', 'created_at', 'acknowledge_radio'];
		$_editColumnsName = ['label_text'=>'タイトル', 'detail_richtext'=>'詳細', 'main_file'=>'画像', 'postscategory_check'=>'カテゴリ', 'created_at'=>'公開時刻', 'acknowledge_radio'=>'公開状態'];

		$query = Posts::query();

		if((INT)$request->id > 0){
			// データ取得
			$post['post'] = $query->where('id', (INT)$request->id)->get($_editColumns)->first();
		}else{
			// 新規作成
			$post['post'] = $this->WowEdit->getEmptyData($_editColumns);
			$post['post'] = $post['post'][0];
		}

		$post = json_decode(json_encode($post), true);
		foreach ($post['post'] as $key => $value) {
			$post['post'][$key] = [
				'title' => $_editColumnsName[$key],
				'data' => $value,
				'error' => '',
			];
		}

		return $post;
	}

	//記事保存
	public function postDoneEdit(PostRequest $request)
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

	//記事一括処理
	public function postMultiAction(Request $request)
	{
		$result = false;
		$query = Posts::query();

		if(!empty($request)){
			$result = $this->WowEdit->doneMultiAction($request, $query);
		}

		return $result;
	}

	/*--------- publish --------*/

	// 公開記事取得
	public function publishPostList(Request $request)
	{
		$get_postnum = 5;
		
		$query = Posts::query();
		$search = $request->searchValue;
		$acknowledge = $request->acknowledge;

		// 検索
		$posts['posts'] = $query->orderBy('id','desc')
						//検索あれば
						->when($search, function ($query) use ($search) {
							return $query->where('label_text', 'like', '%'.$request->searchValue.'%');
        				})
        				->where('acknowledge_radio', 1)
        				->paginate($get_postnum);

		return $posts;
	}

	// 個別記事取得
	public function publishPostEdit(Request $request)
	{
		$this->validate($request,[
			'id' => 'integer|required'
		]);

		// 編集項目
		$_editColumns = ['label_text', 'detail_richtext', 'main_file', 'postscategory_check', 'created_at'];

		$query = Posts::query();

		$post['post'] = $query->where('id', (INT)$request->id)->get($_editColumns)->first();

		return $post;
	}
}