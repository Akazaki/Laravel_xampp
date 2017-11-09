<?php

namespace Laravel\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	// サイト設定
	var $HTTP_DOCUMENT_ROOT = '';
	var $WOW_VIEW = '../view';
	var $WOW_LIB = '';
	var $WOW_SWF = '../swf';
	var $WOW_MODEL = '../model';
	var $WOW_HTML_ROOT = '../html';
	var $SCRIPT_FROM_DOCUMENT_ROOT = '';

	// アクセス制限
	var $ACCESS_PERMISSION = array();
	var $ACCESS_FOLDER = array();
	// TinyMCE
	var $TINY_MCE_SIMPLE = '{ mode : "textareas", editor_selector : "mce-simple", theme : "advanced", language : "ja", theme_advanced_statusbar_location : "bottom", theme_advanced_resize_horizontal : false, plugins : "table,contextmenu", theme_advanced_layout_manager : "SimpleLayout", theme_advanced_buttons1 : "code,separator,bold,italic,insertdate,underline,strikethrough,separator,forecolor,backcolor,separator,sub,sup,separator,bullist,numlist,outdent,indent,separator,hr,table,link,unlink,separator,cleanup,help", theme_advanced_buttons2 : "", theme_advanced_buttons3 : "" }';

	function __construct()
	{
		// 配列などを設定する

		// /*
		//  * アクセスパーミッション
		//  *
		//  * script : 対象のスクリプト。ドキュメントルートからのフルパス指定
		//  * group : （基本的に）編集できるグループID
		//  * acknowledge : （基本的に）承認できるグループID
		//  * permission : 編集パーミッション[作成者|グループ|承認者][4表示|2編集|1承認]
		//  */
		// $this->ACCESS_PERMISSION = array(
		// 	// array('script' => '/wow/user.php', 'group' => 1, 'acknowledge' => FALSE, 'permission' => 0600),
		// 	// array('script' => '/wow/news.php', 'group' => 3 , 'acknowledge' => 2, 'permission' => 0647),
		// 	// array('script' => '/wow/suspendNews.php', 'group' => 1, 'acknowledge' => 1, 'permission' => 0647),
		// 	// array('script' => '/wow/column_info.php', 'group' => 1, 'acknowledge' => FALSE, 'permission' => 0700),
		// 	// array('script' => '/wow/file.php', 'group' => 3, 'acknowledge' => FALSE, 'permission' => 0747),
		// 	// array('script' => '/wow/filewindow.php', 'group' => 3, 'acknowledge' => FALSE, 'permission' => 0747),
		// 	// array('script' => '/wow/afile.php', 'group' => 3, 'acknowledge' => FALSE, 'permission' => 0747),
		// 	// array('script' => '/wow/afilewindow.php', 'group' => 3, 'acknowledge' => FALSE, 'permission' => 0747),
		// );

		// // フォルダごとのアクセスできるグループＩＤの論理和
		// // 例）group1, group3 のどちらかに所属してるユーザのアクセスを許す => 5
		// $this->ACCESS_FOLDER = array(0, 255, 255, 255, 255, 255, 255, 255, 255, 255, 255, 255, 255, 255, 255);

		// // パスの調整
		// $this->_adjustPath($this->WOW_VIEW);
		// $this->_adjustPath($this->WOW_LIB);
		// $this->_adjustPath($this->WOW_SWF);
		// $this->_adjustPath($this->WOW_MODEL);
		// $this->_adjustPath($this->WOW_HTML_ROOT);

		// $this->_gw_template_class = 'smarty/Smarty.class.php';
		// $this->_gw_template_templates_dir = '../view';
		// /*
		//  * 以下のディレクトリへの書き込みを許可する必要がある
		//  */
		// $this->_gw_template_compile_dir = 'smarty/templates_c';

		// $this->_adjustPath($this->_gw_template_class);
		// $this->_adjustPath($this->_gw_template_templates_dir);
		// $this->_adjustPath($this->_gw_template_compile_dir);
		
		// /*
		// *	mailform controller
		// */
		// $this->_MAIL_FORM_EMAILS = array(
		// 	'yasunori.tanochi@gpol.co.jp', 
		// );
		// $this->_REFERER_CODE = $_SERVER['SERVER_NAME'];
		//$this->_REFERER_CODE = '/shinagawa.testing-web.com/';	// テスト用（本番は本番のドメインを記述）

		// $this->SCRIPT_FROM_DOCUMENT_ROOT = str_replace(wowConst('HTTP_DOCUMENT_ROOT') , '', $_SERVER['PHP_SELF']);
	}

	// /*
	//  * パスを調整する
	//  *
	//  * @param string $path : 
	//  */
	// function _adjustPath(&$path)
	// {
	// 	if(is_dir($path) === FALSE && is_file($path) === FALSE){
	// 		$path = dirname(__FILE__) . '/' . $path;
	// 	}
	// }

	// /*
	//  * POST値からパラメータを取得するようにセットする
	//  *
	//  * @param array $params : 
	//  */
	// function _setParams($params)
	// {
	// 	if(count($params) > 0){
	// 		foreach($params as $c){
	// 			if(array_key_exists($c, $this->_gw_params)){
	// 				$this->$c = $this->_gw_params[$c];
	// 			}else{
	// 				$this->$c = '';
	// 			}
	// 		}
	// 	}
	// }

	// /*
	//  * パラメータを配列で取得する
	//  *
	//  * @param array $items : 
	//  */
	// function _getParams(& $items){
	// 	$tArray = array();
	// 	foreach($items as $i){
	// 		if(isset($this->{$i})){
	// 			$tArray[$i] = $this->{$i};
	// 		}
	// 	}
	// 	return $tArray;
	// }

	// /**
	//  * ＤＢを使用する準備
	//  *
	//  * @return DB object
	//  */
	// function _useDb(){
	// 	require_once dirname(__FILE__) . '/Guesswork/DB.php';
	// 	$db = new DB();
	// 	return $db->connect();
	// }

	/**
	 * マスターテーブルを取得する
	 *
	 * @params string $db : DBオブジェクト
	 * @params string $table : テーブル名
	 * @returns array : マスターテーブル配列
	 */
	function _getMaster($db, $table)
	{
		$table = (wowConst('WOW_DATABASE_TYPE') == 'pgsql') ? "\"{$table}\"" : $table;
		$result =& $db->query("SELECT id, label_text FROM {$table} ORDER BY queue");
		$this->rows =& $result->fetchAll(MDB2_FETCHMODE_ASSOC);

		$master = array();
		foreach($this->rows as $r){
			$master[$r['id']] = $r['label_text'];
		}

		return $master;
	}
	
	/**
	 * マスター配列からセレクタHTMLまたは表示HTMLを作成する
	 *
	 * @params String $mode : 'HTML':セレクタ | 'VIEW':表示
	 * @params array $items : マスター配列
	 * @params integer $select : 選択しているマスターID
	 */
	function _createSelect($mode, $items, $select=0)
	{
		$html = '';
		foreach($items as $i => $v){
			if($mode == 'HTML'){
				$html .= '<option value="' . htmlspecialchars($i, ENT_QUOTES) . '"' . ( ($select == $i) ? ' selected="selected">' : '>') . htmlspecialchars($v, ENT_QUOTES) . '</option>';
			}else if($mode == 'VIEW'){
				$html .= ( ($select == $i) ? (htmlspecialchars($v, ENT_QUOTES)) : '');
			}
		}

		return $html;
	}
	/**
	 * マスター配列からチェックボックスHTMLまたは表示HTMLを作成する
	 *
	 * @params String $mode : 'HTML':セレクタ | 'VIEW':表示
	 * @params array $items : マスター配列
	 * @params String $name : input name値
	 * @params integer $select : 選択しているマスターID
	 */
	function _createCheck($mode, $items, $name, $selects='')
	{
		$html = '';
		if(! is_array($selects)){
			$selects = array();
		}
		foreach($items as $i => $v){
			$i = htmlspecialchars($i, ENT_QUOTES);
			if($mode == 'HTML'){
				$html .= "<label><input type=\"checkbox\" name=\"{$name}[]\" id=\"{$name}{$i}\" value=\"{$i}\"" . ( in_array($i, $selects) ? ' checked="checked"/>' : '/>') . htmlspecialchars($v, ENT_QUOTES) . '</label> ';
			}else if($mode == 'VIEW'){
				$html .= htmlspecialchars($v, ENT_QUOTES) . '、';
			}
			$html = mb_substr($html, 0, mb_strlen($html)-1);
		}

		return $html;
	}
	/**
	 * URL形式の相対アドレス指定またはルートアドレス指定を
	 * ディレクトリ形式の絶対パス指定に変換する
	 *
	 * @param String $url : ＵＲＬ
	 */
	function convertToPath($url)
	{
		if(strpos($url, '/') === 0){
			return $_SERVER['DOCUMENT_ROOT'] . $url;
		}else{
			return realpath(dirname(__FILE__) . '/' . $url);
		}
	}
	/**
	 * ディレクトリ形式の相対パス指定および絶対パス指定を
	 * URL形式のルートアドレス指定に変換する
	 *
	 * @param String $path : パス
	 */
	function convertToUrl($path)
	{
		if(strpos($path, '/') === 0){
			return str_replace($_SERVER['DOCUMENT_ROOT'], '', $path);
		}else{
			return str_replace($_SERVER['DOCUMENT_ROOT'], '', realpath(dirname(__FILE__) . '/' . $path));
		}  
	}

	/**
	 * ifset : 変数が定義されていなければ、初期化する
	 *
	 * @params $val mixed 
	 * @params $default mixed
	 * @return mixed
	 */
	function ifset(&$val, $default=NULL)
	{
		if(isset($val) === FALSE){
			$val = $default;
		}
		return $val;
	}

	// /**
	//  * ファイルポインタから行を取得し、CSVフィールドを処理する
	//  *
	//  * @param resource handle
	//  * @param int length
	//  * @param string delimiter
	//  * @param string enclosure
	//  * @return ファイルの終端に達した場合を含み、エラー時にFALSEを返します。
	//  */
	// function fgetcsv_reg (&$handle, $length = null, $d = ',', $e = '"') {
	// 	$d = preg_quote($d);
	// 	$e = preg_quote($e);
	// 	$_line = "";
	// 	while ($eof != true) {
	// 		$_line .= (empty($length) ? fgets($handle) : fgets($handle, $length));
	// 		$itemcnt = preg_match_all('/'.$e.'/', $_line, $dummy);
	// 		if ($itemcnt % 2 == 0) $eof = true;
	// 	}
	// 	$_csv_line = preg_replace('/(?:\r\n|[\r\n])?$/', $d, trim($_line));
	// 	$_csv_pattern = '/('.$e.'[^'.$e.']*(?:'.$e.$e.'[^'.$e.']*)*'.$e.'|[^'.$d.']*)'.$d.'/';
	// 	preg_match_all($_csv_pattern, $_csv_line, $_csv_matches);
	// 	$_csv_data = $_csv_matches[1];
	// 	for($_csv_i=0;$_csv_i<count($_csv_data);$_csv_i++){
	// 		$_csv_data[$_csv_i]=preg_replace('/^'.$e.'(.*)'.$e.'$/s','$1',$_csv_data[$_csv_i]);
	// 		$_csv_data[$_csv_i]=str_replace($e.$e, $e, $_csv_data[$_csv_i]);
	// 	}
	// 	return empty($_line) ? false : $_csv_data;
	// }
}