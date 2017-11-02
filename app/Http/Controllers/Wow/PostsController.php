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
		$_editColumns = ['label_text', 'detail_richtext', 'main_file', 'postscategory_check', 'create_datetime', 'acknowledge_radio'];

		$query = Posts::query();

		//radioとcheckboxのマスターデータ取得
		foreach ($_editColumns as $key => $value) {
			if(strpos($value,'_radio') !== false){
				$table_name = str_replace('_radio', '', $value);
				$master = DB::table($table_name)->get();
			}else if(strpos($value,'_check') !== false){
				$table_name = str_replace('_check', '', $value);
				$master = DB::table($table_name)->get();
			}

			if(!empty($master)){
				$post[$table_name.'_master'] = $master;
			}
		}

		// データ取得
		$post['post'] = $query->where('id', (INT)$request->id)->first();
		$post['_editColumns'] = $_editColumns;

		return $post;
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