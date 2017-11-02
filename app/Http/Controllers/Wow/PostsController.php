<?php
namespace Laravel\Http\Controllers\Wow;
 
use Illuminate\Http\Request;
 
use Laravel\Http\Requests;
use Laravel\Http\Controllers\Controller;
use Auth;
use JWTAuth;
use DB;
use Laravel\Posts;// Model

class PostsController extends Controller
{
	function __construct(Request $request)
	{
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

		// データ取得
		$post['post'] = $query->where('id', (INT)$request->id)->get($_editColumns)->first();

		return $post;
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

	// function s(){
	// 	$checknum = str_pad((string)decbin($@@@['category_check']), count($@@@Master), "0", STR_PAD_LEFT);
	// 	$checknum = strrev($checknum);
	// 	$this->foge['category_check_a'] = str_split($checknum);

	// 	$_array = array();
	// 	foreach($this->foge['category_check_a'] as $key2=>$c){
	// 	 if($c == 1){
	// 	  $this->foge['infocategory_check_a'][$key2] = $@@@categoryMaster[$key2];
	// 	 }else{
	// 	  unset($this->foge['category_check_a'][$key2]);
	// 	 }
	// 	}

	// }
}