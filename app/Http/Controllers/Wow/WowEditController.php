<?php
namespace Laravel\Http\Controllers\Wow;

use Illuminate\Http\Request; 
use Laravel\Http\Requests;
use DB;

/**
 * エディットコントローラ
 *
 * 一覧＞編集・削除の流れの開発ベースクラス
 */
class WowEditController
{
	var $_gw_default_action = 'list';
	// テーブル名
	var $_tableName = 'article';
	// 並び順
	var $_dataSort = 'id ASC';
	// 一覧表示項目
	var $_listColumns = array('id', 'label_text', 'permission');
	// 編集表示項目
	var $_editColumns = array();
	// 新規デフォルトデータ設定
	var $_defaultdatas = array();
	// 編集用のHEAD項目。JSなどがはいる
	var $_editHead = '';
	// テーブル内のカラム名配列
	var $_definedColumns = array();
	// バリデートをおこなうスクリプト
	var $_validateScript = FALSE; // '/wow/' . $this->_gw_validate_class . '.php';
	// プレビューをおこなうスクリプト
	var $_previewScript = FALSE; // '../database/facility/detail.php';
	// 一覧表示件数
	var $_listMax = 10;
	// 記事ID
	var $id = 0;
	// ページングインデックス
	var $p = 0;
	var $hiddenaction = '';
	//検索用キーワード
	var $default = "";
	var $search = "";
	var $search_button_x = "";
	var $_searchColumns = array('label_text');

	var $accessor = NULL;
	var $inputType = NULL;
	var $model = NULL;
	var $view = NULL;

	// 表示ＨＴＭＬのヘッダ部分
	var $head = NULL;
	// 表示ＨＴＭＬのボディ部分
	var $body = NULL;
	// 表示ＨＴＭＬのメッセージ部分
	var $message = array();

	function EditController()
	{
		// // アクションの書き換え。IE7以下対応
		// if($_POST['hiddenaction']){
		// 	$_POST['action'] = $_POST['hiddenaction'];
		// }

		// ConfigController::ConfigController();

		// require_once dirname(__FILE__) . '/../model/wow/WOWAccessor.php';
		// $this->accessor = new WOWAccessor($this);
		// require_once dirname(__FILE__) . '/../model/wow/WOWInputType.php';
		// $this->inputType = new WOWInputType($this, $this->accessor->checkNeedAcknowledge($this->SCRIPT_FROM_DOCUMENT_ROOT));
		// require_once dirname(__FILE__) . '/../model/wow/WOWEditModel.php';
		// $this->model = new WOWEditModel($this);
		// require_once dirname(__FILE__) . '/../model/wow/WOWEditView.php';
		// $this->view = new WOWEditview($this);
		// if($this->_validateScript){
		// 	require_once dirname(__FILE__) . '/../model/' . $this->_validateScript;
		// }

		// $this->_definedColumns = $this->model->getColumns($this->_tableName);
		// if(! $this->_listColumns){
		// 	$this->_listColumns = array('id', 'label_text');
		// }
		// if(! $this->_editColumns){
		// 	$this->_editColumns = $this->_definedColumns;
		// }
	}

	/**
	 * 記事を保存する
	 *
	 * @param array $arr : 保存データ
	 * @param string $table_name : テーブル名
	 * @param number $id : 記事id
	 * @return bool:
	 */
	function doneEdit($arr, $table_name, $id){

		foreach ($arr as $key => $value) {
			if(preg_match('/_check/',$key)){
				//checkboxの場合、10進数に変換
				$arr[$key] = $this->getBit_checkbox($value);
			}else if(preg_match('/password_confirmation/', $key)){
				//パスワード確認は除外
				unset($arr[$key]);
			}else if(preg_match('/password/',$key)){
				//ハッシュ化
				$arr[$key] = bcrypt($value);
			}
		};

		//idあれば削除
		// if(!empty($arr['id'])){
		// 	unset($arr['id']);
		// }

		//保存
		$result = false;
		if((int)$id > 0){
			$result = DB::table($table_name)->where('id', (int)$id)->update($arr);
		}else{
			$result = DB::table($table_name)->insert($arr);
		}

		return $result;
	}

	/**
	 * 一括処理
	 *
	 * @param number $id : id
	 * @param object $model : 
	 * @return bool:
	 */
	function doneMultiAction($request, $model){
		$validatedData = $request->validate([
			'id' => 'required|array',
		]);
		
		$result = false;
		if($request->action === 'delete'){
			//削除
			$result = $model->whereIn('id', $request->id)->delete();
		}else if($request->action == 'private'){
			//非公開
			$result = $model->whereIn('id', $request->id)->update(['acknowledge_radio'=>2]);
		}else if($request->action == 'publish'){
			//公開
			$result = $model->whereIn('id', $request->id)->update(['acknowledge_radio'=>1]);
		}

		return $result;
	}

	/**
	 * カラム名を取得する
	 *
	 * @param string $arr : カラム名
	 * @return array :
	 */
	function getInputType($arr)
	{
		if(preg_match('/^(f\d+_)(\d*)_?(file)$/', $arr, $matches)){
			return array($matches[1], $matches[2], $matches[3]);
		}else if(preg_match('/^(f\d+_)(\d*)_?(afile)$/', $arr, $matches)){
			return array($matches[1], $matches[2], $matches[3]);
		}else if(preg_match('/^(\D+)(\d*)_(select)$/', $arr, $matches)){
			return array($matches[1].$matches[2],'', $matches[3]);
//		}else if(preg_match('/^([^\d]+)([\d]*)_([\w]+)$/', $arr, $matches)){
		}else if(preg_match('/^(\w*[^\d])([\d]*)_([\w]+)$/', $arr, $matches)){
			if(count($matches) == 4){
				return array($matches[1], $matches[2], $matches[3]);
			}else{
				return array($matches[1], '', $matches[2]);
			}
		}else{
			return array('', '', $arr);
		}
	}

	/**
	 * checkboxを10進数で保存
	 *
	 * @param array $arr : 定数名
	 * @return mixed : 定数
	 */
	function getBit_checkbox($arr)
	{
		$tv = 0;
		if(is_array($arr)){
			foreach($arr as $tc){
				if($tc){
					$tv += 1 << ($tc - 1);
				}
			}
		}
		return $tv;
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
			// if($c == 'id'){
			// 	$data[$c] = '*****';
			// }else{
			// 	$data[$c] = '';
			// }
			$data[$c] = '';
			// foreach(wowConst('ACCESS_PERMISSION') as $acc){
			// 	if(strpos($this->ctrl->SCRIPT_FROM_DOCUMENT_ROOT, $acc['script']) === 0){
			// 		$data['permission'] = $acc['permission'];
			// 		break;
			// 	}
			// }
		}
		return array($data);
	}

	// /*
	//  * _check : チェックボックス
	//  *			項目が32以下の場合
	//  */
	// function _getViewItem_check($_labelHead, $_labelIndex, $_labelType)
	// {
	// 	$masters = $this->ctrl->model->getMaster($_labelHead);
	// 	$column = $_labelHead . $_labelIndex . '_' . $_labelType;

	// 	$html = '';
	// 	for($i=1; $i<=count($masters); $i++){
	// 		if($this->dataObject[$column] & (1 << ($i-1))){
	// 			$html .= $masters[$i] . ", ";
	// 		}
	// 	}
	// 	return (strlen($html)) ? htmlspecialchars(substr($html, 0, -2), ENT_QUOTES) : "&nbsp;";
	// }

// 	function init()
// 	{
// 		if(! $this->accessor->checkView($this->SCRIPT_FROM_DOCUMENT_ROOT)){
// 			return $this->redirectToPath(wowConst('HTTP_DOCUMENT_ROOT') . '/wow/index.php?action=forbidden');
// //		}else if(! $this->accessor->checkView($this->SCRIPT_FROM_DOCUMENT_ROOT)){
// //			return $this->redirectToPath(wowConst('HTTP_DOCUMENT_ROOT') . '/wow/index.php?action=expired');
// 		}

// 		if($this->_previewScript){
// 			$base_url = wowConst('HTTP_DOCUMENT_ROOT') . '/wow/' . dirname($this->_previewScript) . '/';
// 		}else{
// 			$base_url = wowConst('HTTP_DOCUMENT_ROOT') . '/';
// 		}

// 		$this->_editHead .= '<script type="text/javascript">tinyMCE.init({ content_css : "js/tiny_mce/tinymce.css", document_base_url: "' . $base_url . '", mode : "textareas", editor_selector : "mce-simple", theme : "advanced", language : "ja", theme_advanced_statusbar_location : "bottom", theme_advanced_resize_horizontal : true, convert_urls : false, forced_root_block : "", plugins : "table,contextmenu", theme_advanced_layout_manager : "AdvancedLayout", theme_advanced_buttons1 : "code,separator,bold,italic,insertdate,underline,strikethrough,separator,forecolor,backcolor,separator,sub,sup,separator,bullist,numlist,outdent,indent,separator,hr,table,link,unlink,separator,cleanup,help", theme_advanced_buttons2 : "", theme_advanced_buttons3 : "" });</script>';

// 		$this->_editHead .= '<script type="text/javascript">tinyMCE.init({ content_css : "js/tiny_mce/tinymce.css", document_base_url: "' . $base_url . '", mode : "textareas", editor_selector : "mce-simple2", theme : "advanced", language : "ja", theme_advanced_statusbar_location : "bottom", theme_advanced_resize_horizontal : true, convert_urls : false, forced_root_block : "", plugins : "table,contextmenu", theme_advanced_layout_manager : "SimpleLayout", theme_advanced_buttons1 : "code,separator,bold,italic,insertdate,underline,strikethrough,separator,forecolor,backcolor,separator,link,unlink,separator,cleanup,help", theme_advanced_buttons2 : "", theme_advanced_buttons3 : "" });</script>';
// 		$this->_editHead .= '<script type="text/javascript">tinyMCE.init({ content_css : "js/tiny_mce/tinymce.css", document_base_url: "' . $base_url . '", mode : "textareas", editor_selector : "mce-simple3", theme : "advanced", language : "ja", theme_advanced_statusbar_location : "bottom", theme_advanced_resize_horizontal : true, convert_urls : false, forced_root_block : "", plugins : "table,contextmenu", theme_advanced_layout_manager : "SimpleLayout", theme_advanced_buttons1 : "code,separator,bold,italic,insertdate,underline,strikethrough,separator,link,unlink,separator,cleanup,help", theme_advanced_buttons2 : "", theme_advanced_buttons3 : "" });</script>';

// 		$params = array('id');
// 		if($this->_gw_action == 'list'){
// 		}else if($this->_gw_action == 'edit'){
// 		}else if($this->_gw_action == 'doneEdit'){
// 			$params = array_merge($params, $this->inputType->getParameters($this->_editColumns));

// 			array_push($params, 'btnDoneEdit_x', 'btnCancelEdit_x');
// 		}else if($this->_gw_action == 'delete'){
// 		}
// 		$this->_setParams(array_unique($params));
// 	}

// 	/**
// 	 * 一覧の処理
// 	 */
// 	function prepareList()
// 	{
// 		$this->p = intval($this->p);
// 		$this->p = htmlspecialchars($this->p, ENT_QUOTES);
// 	}
// 	function executeList()
// 	{
// 		if($this->default){
// 		// 検索用ワードを削除する
// 			unset($_SESSION[$this->_tableName]["search"]);
// 		}else if($this->search || $_POST['search'] === ''){
// 		// 検索用ワードを設定する
// 			$_SESSION[$this->_tableName]["search"] = htmlspecialchars($this->search, ENT_QUOTES);
// 		}

// 		$whereSQL = "";
// 		//検索ワードがある場合
// 		if($_SESSION[$this->_tableName]["search"]){

// 			$whereSQL = " AND ";
// 			$whereSQL .= " ( ";

// 			foreach( $this->_searchColumns as $key => $value ){
// 				if($key < 1){
// 					$whereSQL .= " ".$value." LIKE '%{$_SESSION[$this->_tableName]["search"]}%' ";
// 				}else{
// 					$whereSQL .= " OR ".$value." LIKE '%{$_SESSION[$this->_tableName]["search"]}%' ";
// 				}

// 			}
// 			$whereSQL .= " ) ";

// 		}

// 		//ソート処理がある場合
// 		if(isset($_GET["sort"]) AND isset($_GET["type"])){
// 			// sort処理
// 			$sort = htmlspecialchars($_GET["sort"], ENT_QUOTES);
// 			$flg = 0;
// 			foreach($this->_listColumns as $key => $val){
// 				if((strpos($sort, $val) !== false) && (strpos($sort, $val) == 0) && (mb_strlen($sort) == mb_strlen($val))){
// 					$flg = 1;
// 					break;
// 				}	
// 			}
// 			if($flg != 1){
// 				$sort = 'label_text';
// 			}
			
// 			// type処理
// 			$type = htmlspecialchars($_GET["type"], ENT_QUOTES);
// 			if((strpos($type, 'ASC') !== false && strpos($type, 'ASC') == 0 && mb_strlen($type) == mb_strlen('ASC')) || (strpos($type, 'DESC') !== false && strpos($type, 'DESC') == 0 && mb_strlen($type) == mb_strlen('DESC'))){
// 			}
// 			else{
// 				$type = 'ASC';
// 			}
			
// 			$this->_dataSort = '`'.$sort.'` '.$type.', id desc';	// mysql用「id」ソート以外のソートは全て「id」は常に降順
// 		}

// 		// 一覧用のデータをＤＢから取得する
// 		$rows = $this->model->getData($this->_tableName, $this->_listColumns, 'WHERE delete_datetime IS NULL '.$whereSQL.' ORDER BY ' . $this->_dataSort);

// 		// ページネーション
// 		$this->_rowsCount = count($rows);
// 		if($this->p < 0){
// 			$this->p = ($this->p % $this->_listMax) + $this->_rowsCount + 1;
// 		}else if($this->p >= $this->_rowsCount){
// 			$this->p %= $this->_listMax;
// 		}
// 		$rows = array_slice($rows, $this->p, $this->_listMax);

// 		//ページ用の変数設定
// 		$_SESSION[$this->_tableName]["p"] = htmlspecialchars($this->p, ENT_QUOTES);

// 		$this->view->setHeadContents();

// 		// 一覧表示部分を作成し表示する
// 		return $this->viewList($rows);
// 	}
// 	/**
// 	 * 一覧表示部分を作成し表示する
// 	 *
// 	 * @param array $rows : 
// 	 */
// 	function viewList($rows)
// 	{
// 		$this->view->setPreContents();
// 		$this->view->setMenuContents();
// 		$this->view->setListContents($this->_tableName, $this->_listColumns, $rows);
// 		$this->view->setPostContents();
// 		$this->view->setFooterContents();
// 		return $this->renderHtml('wowbase/contents');
// 	}

// 	/**
// 	 * 記事編集フォームを表示する
// 	 *
// 	 * DBからデータを読み込み編集画面へ遷移する
// 	 */
// 	function prepareEdit()
// 	{
// 		$this->id = intval($this->id);
// 		$this->p = intval($this->p);
// 		$this->p = htmlspecialchars($this->p, ENT_QUOTES);
// 	}
// 	function executeEdit()
// 	{
// 		// 編集用のデータをＤＢから取得する
// 		if(intval($this->id) > 0){
// 			$rows = $this->model->getData($this->_tableName, $this->_editColumns, 'WHERE id = ' . intval($this->id));
// 		}else{
// 			$rows = $this->model->getEmptyData($this->_editColumns);

// 			//デフォルトのデータ設定があればデータを設定する
// 			if(is_array($this->_defaultdatas)){
// 				foreach( $this->_defaultdatas as $key => $val ){
// 					$rows[0][$key] = $val;
// 				}
// 			}

// 		}

// 		if(count($rows) == 0){
// 			// 記事がない時の処理
// 		}

// 		// 編集表示部分を作成し表示する
// 		$this->inputType->viewacknowledge = $this->accessor->checkItemAcknowledgable($this->SCRIPT_FROM_DOCUMENT_ROOT, $rows[0]);

// 		return $this->viewEdit($rows);
// 	}
// 	/**
// 	 * 編集表示部分を作成し表示する
// 	 *
// 	 * @param array $rows : 
// 	 */
// 	function viewEdit($rows)
// 	{
// 		$this->view->setHeadContents();
// 		$this->view->setPreContents();
// 		$this->view->setMenuContents();
// 		$this->view->setEditContents($this->_tableName, $this->_editColumns, $rows);
// 		$this->view->setPostContents();
// 		$this->view->setFooterContents();

// 		return $this->renderHtml('wowbase/contents');
// 	}

// 	/**
// 	 * 記事の保存確認を表示する
// 	 *
// 	 * 戻るボタンが押されてれば編集画面
// 	 * 編集内容をチェックしエラーがあれば編集画面
// 	 * 進むボタンが押されていれば完了画面、なければ確認画面
// 	 */
// 	function executeDoneEdit()
// 	{
// 		// CSRF対策
// 		if($_POST['confirmssid'] !== session_id()){
// 			return $this->redirectToPath(wowConst('HTTP_DOCUMENT_ROOT') . '/wow/index.php?action=forbidden');
// 		}

// 		// 編集用のデータをフォームから取得する
// 		$rows = array($this->inputType->getFormData($this->_editColumns));

// 		//一覧ページへのアクション設定
// 		$link = "list";

// 		//ソートデータ
// 		if($this->sort){$link .= "&sort=".$this->sort;	}
// 		//ソートタイプ
// 		if($this->type){$link .= "&type=".$this->type;	}
// 		//ページデータ
// 		if($this->p){$link .= "&p=".$this->p;			}

// 		if($this->btnCancelEdit_x > 0){
// 		// キャンセルボタンが押された
// 			//return $this->executeList();
// 			return $this->redirectTo($link);
// 		}else if($this->_validateScript && ! $this->validate()){
// 		// バリデート違反
// 			$this->view->setErrors($this->getErrors());
// 		}else{
// 		// 保存
// 			$rows[0]['id'] = $this->id;
// 			$this->model->setData($this->_tableName, $this->_editColumns, $rows[0]);

// 			if(method_exists($this, 'finishDoneEdit')){
// 				$this->finishDoneEdit();
// 			}

// 			return $this->redirectTo($link);
// 		}

// 		// 編集表示部分を作成し表示する
// 		$this->inputType->viewacknowledge = $this->accessor->checkItemAcknowledgable($this->SCRIPT_FROM_DOCUMENT_ROOT, $rows[0]);
// 		return $this->viewEdit($rows);
// 	}

// 	/**
// 	 * 記事を削除する
// 	 */
// 	function executeDelete()
// 	{

// 		//一覧ページへのアクション設定
// 		$link = "list";
// 		//ソートデータ
// 		if($this->sort){$link .= "&sort=".$this->sort;	}
// 		//ソートタイプ
// 		if($this->type){$link .= "&type=".$this->type;	}
// 		//ページデータ
// 		if($this->p){$link .= "&p=".$this->p;			}

// 		if(! $this->id){
// 		}else{
// 			// 非配列を配列にして処理を一括
// 			if(! is_array($this->id)) $this->id = array($this->id);

// 			// 取得
// 			foreach($this->id as $i){
// 				$rows = $this->model->getData($this->_tableName, array('id', 'permission'), 'WHERE id = ' . intval($i), TRUE);

// 				if(! $this->accessor->checkItemWritable($this->SCRIPT_FROM_DOCUMENT_ROOT, $rows[0])){
// 					continue; // 承認以外→権限なし
// 				}
// 				$rows[0]['delete_datetime'] = date('Y-m-d H:i:s');
// 				$this->model->setData($this->_tableName, array('delete_datetime'), $rows[0]);
// 			}
// 		}
// 		return $this->redirectTo($link);
// 	}
// 	/**
// 	 * コピーし編集フォームを表示する
// 	 */
// 	function executeCopy()
// 	{
// 		// 編集用のデータをＤＢから取得する
// 		if(intval($this->id) > 0){
// 			$rows = $this->model->getData($this->_tableName, $this->_editColumns, 'WHERE id = ' . intval($this->id));
// 		}else{
// 			$rows = $this->model->getEmptyData($this->_editColumns);
// 		}
// 		// 変更
// 		$rows[0]['id'] = 0;
// 		$rows[0]['acknowledge'] = 1;
// 		// インサート
// 		$this->model->setData($this->_tableName, $this->_editColumns, $rows[0]);
// 		$this->id = $this->model->db->lastInsertId($this->_tableName, 'id');

// 		// 
// 		$rows = $this->model->getData($this->_tableName, $this->_editColumns, 'WHERE id = ' . intval($this->id), true);

// 		// 編集表示部分を作成し表示する
// 		$this->inputType->viewacknowledge = $this->accessor->checkItemAcknowledgable($this->SCRIPT_FROM_DOCUMENT_ROOT, $rows[0]);
// 		return $this->viewEdit($rows);
// 	}
// 	/**
// 	 * 記事を下書き/不使用をする
// 	 */
// 	function executeInactive()
// 	{
// 		return $this->_subChangeAcknowledge(1);
// 	}
// 	/**
// 	 * 記事を承認要請をする
// 	 */
// 	function executeSuspend()
// 	{
// 		return $this->_subChangeAcknowledge(2);
// 	}

// 	/**
// 	 * 記事を承認/使用をする
// 	 */
// 	function executeAcknowledge()
// 	{
// 		return $this->_subChangeAcknowledge(3);
// 	}
// 	/**
// 	 * executeInactine(), executeSuspend(), executeAcknowledge()から呼ばれる
// 	 *
// 	 * @param integer $value : 1(下書き／不使用)、2(承認要請)、3(承認／使用)
// 	 */
// 	function _subChangeAcknowledge($value)
// 	{

// 		//一覧ページへのアクション設定
// 		$link = "list";
// 		//ソートデータ
// 		if($this->sort){$link .= "&sort=".$this->sort;	}
// 		//ソートタイプ
// 		if($this->type){$link .= "&type=".$this->type;	}
// 		//ページデータ
// 		if($this->p){$link .= "&p=".$this->p;			}

// 		if(! $this->id){
// 		}else{
// 			// 非配列を配列にして処理を一括
// 			if(! is_array($this->id)) $this->id = array($this->id);

// 			// 取得
// 			foreach($this->id as $i){
// 				$rows = $this->model->getData($this->_tableName, array('id', 'permission'), 'WHERE id = ' . intval($i), TRUE);

// 				if($value == 3 && ! $this->accessor->checkItemAcknowledgable($this->SCRIPT_FROM_DOCUMENT_ROOT, $rows[0])){
// 					continue; // 承認処理→承認権限なし
// 				}else if(! $this->accessor->checkItemWritable($this->SCRIPT_FROM_DOCUMENT_ROOT, $rows[0])){
// 					continue; // 承認以外→権限なし
// 				}
// 				$rows[0]['acknowledge'] = $value;
// 				$this->model->setData($this->_tableName, array('acknowledge'), $rows[0]);
// 			}
// 		}
// 		return $this->redirectTo($link);
// 	}

// 	function renderHtml($path)
// 	{
// 		$this->head = $this->view->getHead();
// 		$this->body = $this->view->getBody();
// 		return $this->render($path);
// 	}
// 	/**
// 	 * ＤＢ内の画像をファイルにする
// 	 * @param integer $id : テーブルID
// 	 * @param String $file : 出力ファイル
// 	 */
// 	function _copyImage($id, $file)
// 	{
// 		$result = $this->model->db->query("SELECT data_bin, type_view, name_text FROM file WHERE id = '{$id}' LIMIT 1");
// 		$row =& $result->fetchRow(MDB2_FETCHMODE_ASSOC);

// 		$fp = fopen($file, 'wb');
// 		if(wowConst('WOW_DATABASE_TYPE') == 'pgsql'){
// 			fwrite($fp, pg_unescape_bytea($row['data_bin']));
// 		}else{
// 			fwrite($fp, $row['data_bin']);
// 		}
// 		fclose($fp);
// 	}
}
?>
