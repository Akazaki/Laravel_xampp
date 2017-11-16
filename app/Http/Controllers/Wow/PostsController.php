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
	// function __construct(EditController $EditController)
	// {
	// 	//$EditController->EditController();
	// }
	var $_tableName = 'posts';

	// 記事取得
	public function postList(Request $request)
	{
		$_listColumns = ['id', 'label_text', 'create_datetime', 'acknowledge'];
		$get_postnum = 5;
		
		$query = Posts::query();

		$posts['posts'] = $query->orderBy('id','desc')->paginate($get_postnum);
		$posts['_listColumns'] = $_listColumns;

		return $posts;
	}

	// 記事取得
	public function postEdit(Request $request, WowEditController $WowEditController)
	{
		$this->validate($request,[
			'id' => 'integer|required'
		]);

		// 編集項目
		$_editColumns = ['label_text', 'detail_richtext', 'main_file', 'postscategory_check', 'created_at', 'acknowledge_radio'];

		$query = Posts::query();

		if((INT)$request->id > 0){
			// データ取得
			$post['post'] = $query->where('id', (INT)$request->id)->get($_editColumns)->first();
		}else{
			// 新規作成
			$post['post'] = $WowEditController->getEmptyData($_editColumns);
			$post['post'] = $post['post'][0];
		}

		$post = json_decode(json_encode($post), true);
		foreach ($post['post'] as $key => $value) {
			$post['post'][$key] = [
				'title' => 'タイトルタイトル',
				'data' => $value,
				'error' => '',
			];
		}

		return $post;
	}

	//記事保存
	public function postDoneEdit(PostRequest $request, WowEditController $WowEditController)
	{
		$result = false;
		$res['res'] = false;
		if(!empty($request) && isset($request->id)){
			$rows = $request->rows;
			$id = (int)$request->id;

			$result = $WowEditController->doneEdit($rows, $this->_tableName, $id);

			if($result){
				$res['res'] = true;
			}
		}

		return $res;
	}
}