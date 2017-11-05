<?php
namespace Laravel\Http\Controllers\Wow;
 
use Illuminate\Http\Request;
 
use Laravel\Http\Requests;
use Laravel\Http\Controllers\Controller;
use Laravel\Http\Controllers\Wow\WowEditController;
use Auth;
use JWTAuth;
use DB;
use Laravel\Posts;// Model

class PostsController extends Controller
{
	function __construct(EditController $EditController)
	{
		//$EditController->EditController();
	}

	// 記事取得
	public function postList(Request $request)
	{
		$_listColumns = ['id', 'label_text', 'create_datetime', 'acknowledge'];
		$get_postnum = 6;
		
		$query = Posts::query();

		$posts['posts'] = $query->orderBy('id','desc')->paginate($get_postnum);
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
		$_editColumns = ['label_text', 'detail_richtext', 'main_file', 'postscategory_check', 'created_at', 'acknowledge_radio'];

		$query = Posts::query();

		if((INT)$request->id > 0){
			// データ取得
			$post['post'] = $query->where('id', (INT)$request->id)->get($_editColumns)->first();
		}else{
			// 新規作成
			$post['post'] = $this->getEmptyData($_editColumns);
			$post['post'] = $post['post'][0];
		}

		return $post;
	}

	/**
	 * 空のデータを取得する（新規追加時に使用）
	 *
	 * @params array $columns : カラム名配列
	 */
	function getEmptyData($columns=array('*'))
	{
		$data = array();
		foreach($columns as $c){
			if($c == 'id'){
				$data[$c] = '*****';
			}else{
				$data[$c] = '';
			}
			// foreach(wowConst('ACCESS_PERMISSION') as $acc){
			// 	if(strpos($this->ctrl->SCRIPT_FROM_DOCUMENT_ROOT, $acc['script']) === 0){
			// 		$data['permission'] = $acc['permission'];
			// 		break;
			// 	}
			// }
		}
		return array($data);
	}

	
	 /**
	 * マスターデータ取得
	 * @param {table_name} string - 
	 */
	public function getMasterData(Request $request)
	{
		// $this->validate($request,[
		// 	'id' => 'integer|required'
		// ]);

		//radioとcheckboxのマスターデータ取得
		if(strpos($request->table_name,'_radio') !== false){
			$table_name = str_replace('_radio', '', $request->table_name);
			$master = DB::table($table_name)->get();
		}else if(strpos($request->table_name,'_check') !== false){
			$table_name = str_replace('_check', '', $request->table_name);
			$master = DB::table($table_name)->get();
		}

		//カテゴリ名のみ摘出
		$master_data = array();
		if(!empty($master)){
			foreach($master as $r){
				$master_data[$r->id] = $r->label_text;
			}
		}
		
		return $master_data;
	}
}