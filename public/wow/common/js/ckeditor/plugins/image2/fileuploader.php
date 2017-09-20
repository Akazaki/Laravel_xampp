<?php
/*
set_time_limit(0);
ini_set("display_errors"	 , "on");
ini_set("post_max_size" 	 , 2147483647);
ini_set("upload_max_filesize", 2147483647);
ini_set("max_execution_time" , "36000");
ini_set("max_input_time"	 , "36000");
ini_set("memory_limit"		 , -1	);
*/


/**
 * 容量制限値（※少なくともphp.ini(.htaccess)「post_max_size」「upload_max_filesize」「memory_limit」
 * 及び、my.cnf「max_allowed_packet」が下記設定値以上であること
 */
define('DEF_UPLOAD_MAX_FILESIZE', 2); //2M

/**
 * ファイルアップロードコントローラ
 */
class FileuploaderController
{
	var $ext;
	var $uploadfile;
	var $uploaddirfile;
	var $name = 'upload';
	
	//response object
	var $response;

	function FileuploaderController()
	{
		if(!$this->isFile()){
			//異常値設定 不正なパラメータが指定されました。
			$this->response->error->code = 1;
			$this->response->error->message = "不正なファイルが指定されました。";
		}else{
			$uploaddir = dirname(__FILE__) . '/uploadfiles/';
			$this->ext = $this->getExtension($_FILES[$this->name]['name']);
			$this->uploadfile = mktime() . '_' . basename(rand()).'.'.$this->ext;
			$this->uploaddirfile = $uploaddir . $this->uploadfile;

			$this->_checkFile();
		}

		if(isset($this->response->error)){
			$this->response = <<<_EOS_
<script>
alert("CODE:{$this->response->error->code} => {$this->response->error->message}");
</script>
_EOS_;
		}
		
		echo $this->response;
		exit;
	}

	function isFile()
	{
		$bRet = false;

		//
		if(isset($_FILES[$this->name])){
			$bRet = true;
		}

		return $bRet;
	}

	function _checkFile()
	{
		//php.iniのファイルアップロード制限を調べてみる
		if($_FILES[$this->name]['error'] == UPLOAD_ERR_INI_SIZE){
			$this->response->error->code = 2;
			//$this->response->error->message = "アップロードされたファイルは、php.ini の upload_max_filesize ディレクティブの値を超えています。";
			$this->response->error->message = "ファイルサイズは".ini_get('upload_max_filesize')."以内を指定してください。";
		}else if($_FILES[$this->name]['error'] == UPLOAD_ERR_FORM_SIZE){
			$this->response->error->code = 3;
			$this->response->error->message = "アップロードされたファイルは、HTML フォームで指定された MAX_FILE_SIZE を超えています。";
		}else if($_FILES[$this->name]['error'] == UPLOAD_ERR_PARTIAL){
			$this->response->error->code = 4;
			$this->response->error->message = "アップロードされたファイルは一部のみしかアップロードされていません。";
		}else if($_FILES[$this->name]['error'] == UPLOAD_ERR_NO_FILE){
			$this->response->error->code = 5;
			$this->response->error->message = "ファイルはアップロードされませんでした。";
		}else if($_FILES[$this->name]['error'] == UPLOAD_ERR_NO_TMP_DIR){
			$this->response->error->code = 6;
			$this->response->error->message = "テンポラリフォルダがありません。PHP 4.3.10 と PHP 5.0.3 で導入されました。";
		}else if($_FILES[$this->name]['error'] == UPLOAD_ERR_CANT_WRITE){
			$this->response->error->code = 7;
			$this->response->error->message = "ディスクへの書き込みに失敗しました。PHP 5.1.0 で導入されました。";
		}else if($_FILES[$this->name]['error'] > 0){
			$this->response->error->code = 8;
			$this->response->error->message = "ファイルのアップロードに失敗しました。";
		}else if($_FILES[$this->name]['size'] > 1048576 * DEF_UPLOAD_MAX_FILESIZE){
			$this->response->error->code = 9;
			$this->response->error->message = "ファイルサイズは".DEF_UPLOAD_MAX_FILESIZE."M以内を指定してください。";
		}else if(empty($_FILES[$this->name]['name'])){
			$this->response->error->code = 10;
			$this->response->error->message = "ファイル拡張子が一致しません。";
		}else if(! mb_eregi(".+\.(jpe?g|gif|png|pdf|xls|doc)$", $_FILES[$this->name]['name'])){
			$this->response->error->code = 11;
			$this->response->error->message = "ファイル拡張子が一致しません。";
		}else if (move_uploaded_file($_FILES[$this->name]['tmp_name'], $this->uploaddirfile)) {

			$this->ext = $this->getExtension($_FILES[$this->name]['name']);
			$info = getimagesize($this->uploaddirfile);

			if($this->ext == 'jpg' || $this->ext == 'gif' || $this->ext == 'png'){
				
				//横幅900以上の場合リサイズ
				if(900<$info[0]){
					require_once '../../../../../../cgi-bin/lib/Guesswork/FileTool.php';
					$ft = new FileTool();
					$ft->imagecreateto($ft->resizeImage($this->uploaddirfile, 900, $info[1]*(900/$info[0]), '#FFFFFF'), $this->uploaddirfile);
				}
				
				$n = $_GET['CKEditorFuncNum'];
				$url = dirname($_SERVER["SCRIPT_NAME"]) . '/uploadfiles/' . $this->uploadfile;
				$message = '';

				$this->response = <<<_EOS_
<script>
window.parent.CKEDITOR.tools.callFunction({$n}, '{$url}', '{$message}')
</script>
_EOS_;
			}else{
				$this->response->error->code = 12;
				$this->response->error->message = "ファイル拡張子が一致しません。";
			}

		} else {
			$this->response->error->code = 99;
			$this->response->error->message = "ファイルアップロードに失敗しました。";
		}
	}

	/**
	 * ファイルから拡張子を整形して取り出す
	 * 拡張子がリストに無い場合は'unknown'を返す
	 */
	function getExtension($filename){
		if(mb_ereg('^.*\.([^\.]*)$', $filename, $matches)){
			$ext = strtolower($matches[1]);
			if($ext == 'jpeg'){ $ext = 'jpg'; }

			if(in_array($ext, array('jpg', 'gif', 'png', 'pdf', 'doc', 'xls'))){
				return $ext;
			}
		}
		return 'unknown';
	}
}

$controller = new FileuploaderController();
?>
