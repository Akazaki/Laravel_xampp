<?php

/**
 *
 */
class WOWInputType
{
	var $ctrl = NULL;

	var $errorList = NULL;
	var $acknowledge = NULL;
	var $viewacknowledge = TRUE;
	var $permission = array('', '承予', '承書', '承読', 'グ予', 'グ書', 'グ読', '所予', '所書', '所読');

	var $display = array('', '非表示', '表示');

	function WOWInputType(& $_ctrl, $_useacknowledge=TRUE)
	{
		$this->ctrl =& $_ctrl;

		if($_useacknowledge){
			$this->acknowledge = array('', '下書き', '承認要請', '承認');
		}else{
//			$this->acknowledge = array('', '不使用', '不使用', '使用');
			$this->acknowledge = array('', '非公開', '非公開', '公開');
		}
	}

	/*
	 * 表示用のアイテムを作成する
	 *
	 * @param string $column : カラム名
	 * @return string : フォームＨＴＭＬ
	 */
	function getViewItem($_column, & $_dataObject)
	{
		if($_dataObject){
			$this->dataObject =& $_dataObject;
		}

		list($labelHead, $labelIndex, $labelType) = $this->_getInputType($_column);

		$viewMethod = '_getViewItem_' . $labelType;

		// タイプ（接尾後）がない場合はデフォルトタイプを使用
		if(! method_exists($this, $viewMethod)){
			$viewMethod = '_getViewItem_default';
		}

		if(array_key_exists($labelHead . '_' . $labelType, $this->dataObject)){
			return $this->$viewMethod($labelHead, '', $labelType);
		}else if(array_key_exists($labelType, $this->dataObject)){
			return $this->$viewMethod('', '', $labelType);
		}else if(array_key_exists($labelHead . '0_' . $labelType, $this->dataObject)){
			if($labelType == 'text'){
			// 値連番型
				$html = '';
				for($i=0; ; $i++){
					if(array_key_exists($labelHead . $i . '_' . $labelType, $this->dataObject)){
						$html .= $this->$viewMethod($labelHead, $i, $labelType);
					}else{
						break;
					}
				}
				return $html;
			}else{
			// テーブル別名リンク型
				return $this->$viewMethod($labelHead, $labelIndex, $labelType);
			}
		}else{
			return FALSE;
		}
	}
	/*
	 * 編集用のアイテムを作成する
	 *
	 * @param string $column : カラム名
	 * @param string $values : データオブジェクト
	 * @return string : フォームＨＴＭＬ
	 */
	function getEditItem($_column, $_dataObject, $hidden=FALSE)
	{
		if($_dataObject){
			$this->dataObject =& $_dataObject;
		}

		list($labelHead, $labelIndex, $labelType) = $this->_getInputType($_column);
		$viewMethod = '_getEditItem_' . $labelType;

		// タイプ（接尾後）がない場合はデフォルトタイプを使用
		if(! method_exists($this, $viewMethod)){
			$viewMethod = '_getEditItem_default';
		}
		if(array_key_exists($labelHead . '_' . $labelType, $this->dataObject)){
			return $this->$viewMethod($labelHead, '', $labelType);
		}else if(array_key_exists($labelType, $this->dataObject)){
			return $this->$viewMethod('', '', $labelType);
		}else if(array_key_exists($labelHead . '0_' . $labelType, $this->dataObject)){
			if($labelType == 'text'){
			// 値連番型
				if($labelIndex != 0) return FALSE;
				$html = '';
				for($i=0; ; $i++){
					if(array_key_exists($labelHead . $i . '_' . $labelType, $this->dataObject)){
						$html .= $this->$viewMethod($labelHead, $i, $labelType);
					}else{
						break;
					}
				}
				return $html;
			}else{
			// テーブル別名リンク型
				return $this->$viewMethod($labelHead, $labelIndex, $labelType);
			}
		}else{
			return FALSE;
		}
	}

	/*
	 * カラム名配列からフォーム名配列を取得する
	 *
	 * @param array $columns : カラム名配列
	 * @return array : フォーム名配列
	 */
	function getParameters($_columns)
	{
		$tParams = array();
		foreach($_columns as $c){
			list($labelHead, $labelIndex, $labelType) = $this->_getInputType($c);

			$method = '_getParameters_' . $labelType;

			// タイプ（接尾後）がない場合はデフォルトタイプを使用
			if(method_exists($this, $method)){
				$this->$method($tParams, $c);
			}else{
				$tParams[] = $c;
			}
		}
		return $tParams;
	}
	/*
	 * カラム名配列からフォーム名データ配列を取得する
	 *
	 * @param array $columns : カラム名配列
	 * @return array : フォームデータ名配列
	 */
	function getFormData($_columns)
	{
		$tData = array();
		foreach($_columns as $c){
			list($labelHead, $labelIndex, $labelType) = $this->_getInputType($c);

			$method = '_getFormData_' . $labelType;

			if(method_exists($this, $method)){
			// メソッドがある特別型の場合
				$tData[$c] = $this->$method($c);
			}else if(isset($this->ctrl->{$c})){
			// 通常型の場合
				$tData[$c] = $this->ctrl->{$c};
			}else{
			// なし
				$tData[$c] = '';
			}
		}
		return $tData;
	}

	/*
	 * 確認用隠しアイテムを作成する
	 *
	 * @param string $column : カラム名
	 * @return string : フォームＨＴＭＬ
	 */
	function _getHideItem($column, $values='')
	{
		return $this->_getEditItem($column, $values, TRUE);
	}

	/*
	 * アイテムのエラー表示を作成する
	 *
	 * @param string $column : カラム名
	 * @return string : フォームＨＴＭＬ
	 */
	function _getErrorItem($column, $errors)
	{
		if(isset($errors[$column])){
			return '　<span class="error-message">' . htmlspecialchars($errors[$column], ENT_QUOTES) . '</span>';
		}else{
			return '';
		}
	}

	/**
	 * 表示用メソッドを設定する
	 *
	 * @param string $type : タイプ（接尾語）
	 * @param function $func : メソッド
	 */
	function _setViewFunction($type, $func)
	{
		$this->viewFunctions[$type] = $func;
	}

	/**
	 * 編集用メソッドを設定する
	 *
	 * @param string $type : タイプ（接尾語）
	 * @param function $func : メソッド
	 */
	function _setEditFunction($type, $func)
	{
		$this->editFunctions[$type] = $func;
	}
	/**
	 * カラム名を取得する
	 *
	 * @param string $_column : カラム名
	 * @return array :
	 */
	function _getInputType($_column)
	{
		if(preg_match('/^(f\d+_)(\d*)_?(file)$/', $_column, $matches)){
			return array($matches[1], $matches[2], $matches[3]);
		}else if(preg_match('/^(f\d+_)(\d*)_?(afile)$/', $_column, $matches)){
			return array($matches[1], $matches[2], $matches[3]);
		}else if(preg_match('/^(\D+)(\d*)_(select)$/', $_column, $matches)){
			return array($matches[1].$matches[2],'', $matches[3]);
//		}else if(preg_match('/^([^\d]+)([\d]*)_([\w]+)$/', $_column, $matches)){
		}else if(preg_match('/^(\w*[^\d])([\d]*)_([\w]+)$/', $_column, $matches)){
			if(count($matches) == 4){
				return array($matches[1], $matches[2], $matches[3]);
			}else{
				return array($matches[1], '', $matches[2]);
			}
		}else{
			return array('', '', $_column);
		}
	}

//--------------------------------------------------------------------------------
// タイプメソッド
//--------------------------------------------------------------------------------
	/*
	 * acknowledge : 特殊タイプ　承認
	 */
	function _getViewItem_acknowledge($_labelHead, $_labelIndex, $_labelType)
	{
		$column = $_labelType;
		return $this->acknowledge[$this->dataObject[$column]];
	}
	function _getEditItem_acknowledge($_labelHead, $_labelIndex, $_labelType, $_hidden=FALSE)
	{
		$column = $_labelType;

		$items = array();
		for($i=1; $i<count($this->acknowledge); $i++){
			// 権限不使用の場合の2をスキップ
			if($i == 2 && $this->acknowledge[1] == $this->acknowledge[2]) continue;
			if($i == 3 && ! $this->viewacknowledge) continue;
			$items[] = array('id' => $i, 'label_text' => $this->acknowledge[$i]);
		}
		if(!isset($this->dataObject[$column]) || $this->dataObject[$column] == 0){
			$this->dataObject[$column] = 3;
		}
		if($this->dataObject[$column] == 3 && ! $this->viewacknowledge){
			$this->dataObject[$column] = 2;
		}

		$html = '';
		foreach($items as $i){
			$html .= "<label for=\"{$column}{$i['id']}\" class=\"" . (isset($this->errors[$column]) ? ' error-message' : '') . "\"" . (($_hidden) ? "\" style=\"display: none;" : '') . "><input type=\"radio\" id=\"{$column}{$i['id']}\" name=\"{$column}\" value=\"{$i['id']}\" " . (($i['id'] == $this->dataObject[$column]) ? 'checked="checked" ' : '') . "/><span class=\"w30\">" . htmlspecialchars($i['label_text'], ENT_QUOTES) . "</span></label>";
		}
		return $html;
	}
	/*
	 * _bin : バイナリ（画像データ）
	 */
	function _getViewItem_bin($_labelHead, $_labelIndex, $_labelType)
	{
		if(basename($_SERVER['SCRIPT_NAME']) == 'file.php' || basename($_SERVER['SCRIPT_NAME']) == 'filewindow.php'){
			return "<a href=\"../f.php?id={$this->dataObject['id']}\" title=\"ファイル\" class=\"cboxaction\"><img src=\"../f.php?id={$this->dataObject['id']}&amp;mode=icon\" width=\"120\" height=\"120\" alt=\"ファイル\" /></a>";
		}else{
			return "<a href=\"../a.php?id={$this->dataObject['id']}\" title=\"ファイル\" target=\"_blank\"><img src=\"img/extension/file-{$this->dataObject['type_view']}.gif\" width=\"120\" height=\"120\" alt=\"ファイル\" /></a>";
		}
	}
	function _getEditItem_bin($_labelHead, $_labelIndex, $_labelType, $_hidden=FALSE)
	{
		$column = $_labelHead . $_labelIndex . '_' . $_labelType;

		$tid = 0;
		if(isset($this->dataObject['id'])){
			$tid = $this->dataObject['id'];
		}

		if(basename($_SERVER['SCRIPT_NAME']) == 'file.php' || basename($_SERVER['SCRIPT_NAME']) == 'filewindow.php'){
			if($tid == 0 && !empty($this->dataObject['data_bin'])){

				$_file = "../wow/uploadfiles/" . $this->dataObject['data_bin'];
				list($width, $height, $type, $attr) = getimagesize($_file);

				if($width>$height){
					if($width>120){
						$height = (int)($height * 120/$width);
						$width = 120;
					}
				}else{
					if($height>120){
						$width = (int)($width * 120/$height);
						$height = 120;
					}
				}

				return "<img id=\"{$column}_b\" src=\"common/img/upload_btn02.gif\" class=\"rollover\" width=\"78\" height=\"21\" alt=\"アップロード\" /><br /><img id=\"{$column}_i\" src=\"../wow/uploadfiles/{$this->dataObject['data_bin']}\" width=\"{$width}\" height=\"{$height}\" alt=\"\" /><input type=\"hidden\" id=\"{$column}\" name=\"{$column}\" value=\"{$this->dataObject['data_bin']}\" />";
			}else{
				return "<img id=\"{$column}_b\" src=\"common/img/upload_btn02.gif\" class=\"rollover\" width=\"78\" height=\"21\" alt=\"アップロード\" /><br /><img id=\"{$column}_i\" src=\"../f.php?id={$tid}&amp;mode=icon\" width=\"120\" height=\"120\" alt=\"\" /><input type=\"hidden\" id=\"{$column}\" name=\"{$column}\" />";
			}
		}else if(basename($_SERVER['SCRIPT_NAME']) == 'afile.php' || basename($_SERVER['SCRIPT_NAME']) == 'afilewindow.php'){
			if($tid == 0 && !empty($this->dataObject['data_bin'])){
				return "<img id=\"{$column}_b\" src=\"common/img/upload_btn02.gif\" class=\"rollover\" width=\"78\" height=\"21\" alt=\"アップロード\" /><br /><img id=\"{$column}_i\" src=\"img/extension/file-{$this->dataObject['type_view']}.gif\" width=\"120\" height=\"120\" alt=\"\" /><input type=\"hidden\" id=\"{$column}\" name=\"{$column}\" value=\"{$this->dataObject['data_bin']}\" />";
			}else{
				return "<img id=\"{$column}_b\" src=\"common/img/upload_btn02.gif\" class=\"rollover\" width=\"78\" height=\"21\" alt=\"アップロード\" /><br /><img id=\"{$column}_i\" src=\"img/extension/file-{$this->dataObject['type_view']}.gif\" width=\"120\" height=\"120\" alt=\"\" /><input type=\"hidden\" id=\"{$column}\" name=\"{$column}\" />";
			}
		}else{
			return "<img id=\"{$column}_b\" src=\"common/img/upload_btn02.gif\" class=\"rollover\" width=\"78\" height=\"21\" alt=\"アップロード\" /><br /><img id=\"{$column}_i\" src=\"img/extension/file-{$this->dataObject['type_view']}.gif\" width=\"120\" height=\"120\" alt=\"\" /><input type=\"hidden\" id=\"{$column}\" name=\"{$column}\" />";
		}
	}
	/*
	 * id : 特殊タイプ　ＩＤ
	 */
	function _getViewItem_id($_labelHead, $_labelIndex, $_labelType)
	{
		$column = $_labelType;
		$length = strlen($this->dataObject[$column]);
		if($length < 4){
			return str_repeat('0', 5 - $length) . htmlspecialchars($this->dataObject[$column], ENT_QUOTES);
		}else{
			return htmlspecialchars($this->dataObject[$column], ENT_QUOTES);
		}
	}
	function _getEditItem_id($_labelHead, $_labelIndex, $_labelType, $_hidden=FALSE)
	{
		return $this->_getViewItem_id($_labelHead, $_labelIndex, $_labelType);
	}
	/*
	 * permission : 特殊タイプ　承認
	 */
	function _getViewItem_permission($_labelHead, $_labelIndex, $_labelType)
	{
		$column = $_labelType;

		$html = '';
		for($i=1; $i<count($this->permission); $i++){
			if($this->dataObject[$column] & (1 << ($i-1))){
				$html .= $this->permission[$i] . ", ";
			}
		}
		return (strlen($html)) ? htmlspecialchars(substr($html, 0, -2), ENT_QUOTES) : "&nbsp;";
	}
	function _getEditItem_permission($_labelHead, $_labelIndex, $_labelType, $_hidden=FALSE)
	{
		$column = $_labelType;

		$html = '';
		for($i=1; $i<count($this->permission); $i++){
			$html .= "<label for=\"{$column}{$i}\" class=\"" . (isset($this->errors[$column]) ? ' error-message' : '') . "\"" . (($_hidden) ? "\" style=\"display: none;" : '') . "><input type=\"checkbox\" id=\"{$column}{$i}\" name=\"{$column}[]\" value=\"{$i}\" " . ((1 << ($i-1) & $this->dataObject[$column]) ? 'checked="checked" ' : '') . "/><span class=\"w30\">" . htmlspecialchars($this->permission[$i], ENT_QUOTES) . "</span></label>";
		}
		return $html;
	}
	function _getFormData_permission($_column)
	{
		return $this->_getFormData_check($_column);
	}
	/*
	 * _default : デフォルトタイプ
	 *	   どのタイプにも当てはまらない時に使用される
	 */
	function _getViewItem_default($_labelHead, $_labelIndex, $_labelType)
	{
		return $this->_getViewItem_text($_labelHead, $_labelIndex, $_labelType);
	}
	function _getEditItem_default($_labelHead, $_labelIndex, $_labelType, $_hidden=FALSE)
	{
		return $this->_getEditItem_text($_labelHead, $_labelIndex, $_labelType, $_hidden);
	}
	/*
	 * _check : チェックボックス
	 *			項目が32以下の場合
	 */
	function _getViewItem_check($_labelHead, $_labelIndex, $_labelType)
	{
		$masters = $this->ctrl->model->getMaster($_labelHead);
		$column = $_labelHead . $_labelIndex . '_' . $_labelType;

		$html = '';
		for($i=1; $i<=count($masters); $i++){
			if($this->dataObject[$column] & (1 << ($i-1))){
				$html .= $masters[$i] . ", ";
			}
		}
		return (strlen($html)) ? htmlspecialchars(substr($html, 0, -2), ENT_QUOTES) : "&nbsp;";
	}
	function _getEditItem_check($_labelHead, $_labelIndex, $_labelType, $_hidden=FALSE)
	{
		$column = $_labelHead . $_labelIndex . '_' . $_labelType;
		$items = $this->ctrl->model->getMaster($_labelHead);
		$html = '';
		foreach($items as $k => $i){
			$html .= "<label for=\"{$column}{$k}\" class=\"" . (isset($this->errors[$column]) ? ' error-message' : '') . "\"" . (($_hidden) ? "\" style=\"display: none;" : '') . "><input type=\"checkbox\" id=\"{$column}{$k}\" name=\"{$column}[]\" value=\"{$k}\" " . ((1 << ($k-1) & $this->dataObject[$column]) ? 'checked="checked" ' : '') . "/><span class=\"w30\">" . htmlspecialchars($i, ENT_QUOTES) . "</span></label>";
		}
		return $html;
	}
	function _getFormData_check($_column)
	{
		$tv = 0;
		if(is_array($this->ctrl->{$_column})){
			foreach($this->ctrl->{$_column} as $tc){
				$tv += 1 << ($tc - 1);
			}
		}
		return $tv;
	}
	/*
	 * _date : 月日タイプ Y-m-d 形式
	 */
//	function _getViewItem_date($_labelHead, $_labelIndex, $_labelType)
//	{
//		return $this->_getViewItem_text($_labelHead, $_labelIndex, $_labelType);
//	}
	function _getEditItem_date($_labelHead, $_labelIndex, $_labelType, $_hidden=FALSE)
	{
		$column = $_labelHead . $_labelIndex . '_' . $_labelType;
		preg_match('/^(\d{4}-\d\d-\d\d)$/', $this->dataObject[$column], $matches);
		if(count($matches) == 2){
			$date = $matches[1];
		}else{
//			$date = date('Y-m-d');
			$date = '';
		}
		$options = $this->_createTimeList();

		return "<input type=\"text\" class=\"w80 dateScript" . (!$_hidden && isset($this->errorList[$column]) ? ' error' : '') . "\" id=\"{$column}\" name=\"" . $column . "\" value=\"" . $date . (($_hidden) ? "\" style=\"display: none;" : '') . "\" />";
	}
	/*
	 * _datetime : 日時タイプ Y-m-d H:i:s 形式
	 */
	function _getViewItem_datetime($_labelHead, $_labelIndex, $_labelType)
	{
		return $this->_getViewItem_text($_labelHead, $_labelIndex, $_labelType);
	}
	function _getEditItem_datetime($_labelHead, $_labelIndex, $_labelType, $_hidden=FALSE)
	{
		$column = $_labelHead . $_labelIndex . '_' . $_labelType;
		preg_match('/^(\d{4}-\d\d-\d\d) (\d\d:\d\d:\d\d)$/', $this->dataObject[$column], $matches);
		if(count($matches) == 3){
			list(, $date, $time) = $matches;
		}else{
			$date = date('Y-m-d');
			$time = date('H:i:s');
		}
		$options = $this->_createTimeList();
		$select = '<select name="' . $column . '_t' . '" class="w80">';
		foreach($options as $o){
			$isSelected = ($o == $time) ? ' selected="selected"' : '';
			$select .= "<option value=\"{$o}\"{$isSelected}>" . substr($o, 0, 5) . "</option>";
		}
		$select .= '</select>';

		return "<input type=\"text\" class=\"w80 dateScript" . (!$_hidden && isset($this->errorList[$column]) ? ' error' : '') . "\" id=\"{$column}\" name=\"" . $column . '_d' . "\" value=\"" . $date . (($_hidden) ? "\" style=\"display: none;" : '') . "\" />{$select}";
	}
	function _getParameters_datetime(& $_params, $_column)
	{
		$_params[] = $_column . '_d';
		$_params[] = $_column . '_t';
	}
	function _getFormData_datetime($_column)
	{
		$date = ifset($this->ctrl->{$_column . '_d'});
		$time = ifset($this->ctrl->{$_column . '_t'});
		if($date === NULL && $time !== NULL){
			$date = date('Y-m-d');
		}
		if($date !== NULL && $time === NULL){
			$time = '00:00:00';
		}
		return $date . ' ' . $time;
	}
	/*
	 * _file : 画像ファイル
	 */
	function _getViewItem_file($_labelHead, $_labelIndex, $_labelType)
	{
		if($_labelHead){
			$column = $_labelHead . $_labelIndex . '_' . $_labelType;
		}else{
			$column = $_labelType;
		}
		return htmlspecialchars($this->dataObject[$column], ENT_QUOTES);
	}
	function _getEditItem_file($_labelHead, $_labelIndex, $_labelType, $_hidden=FALSE)
	{
		if($_labelHead){
			$column = $_labelHead . $_labelIndex . '_' . $_labelType;
		}else{
			$column = $_labelType;
		}

		$data = $this->ctrl->model->getData('file', array('id', 'label_text'), "WHERE delete_datetime IS NULL AND acknowledge = 3 AND id = " . intval($this->dataObject[$column]), TRUE);
		if(! count($data)){
			$this->dataObject[$column] = '';
		}

		$html = "<div class=\"file-upload\"" . (($this->dataObject[$column]) ? ' style="display: none;"' : ''). "><a title=\"画像管理\" href=\"./filewindow.php?action=list&amp;dir={$column}\" id=\"{$column}_a\" class=\"cboxaction\"><img height=\"21\" border=\"0\" width=\"137\" class=\"rollover\" alt=\"\" src=\"common/img/upload_btn.gif\"/></a></div>";
		$html .= "<div class=\"file-cancel\"" . ((! $this->dataObject[$column]) ? ' style="display: none;"' : ''). "><div><span>" . (isset($data[0]['label_text']) ? $data[0]['label_text'] : '') . "</span></div><a href=\"cancel.html\" onclick=\"return cancelImage('{$column}');\"><img height=\"21\" border=\"0\" width=\"20\" class=\"rollover\" src=\"common/img/upload_c_btn.gif\" alt=\"cancel file\"/></a><br /><img class=\"file-icon\" src=\"" . (isset($data[0]['label_text']) ? "../f.php?id={$data[0]['id']}&amp;mode=icon" : "common/img/loading.gif") . "\" />";

		return "<input type=\"text\" class=\"w640" . (!$_hidden && isset($this->errorList[$column]) ? ' error' : '') . "\" id=\"{$column}\" name=\"{$column}\" value=\"" . htmlspecialchars($this->dataObject[$column], ENT_QUOTES) . "\" style=\"display: none;\" /></div>{$html}";
	}
	/*
	 * _afile : アプリケーションファイル
	 */
	function _getViewItem_afile($_labelHead, $_labelIndex, $_labelType)
	{
		if($_labelHead){
			$column = $_labelHead . $_labelIndex . '_' . $_labelType;
		}else{
			$column = $_labelType;
		}
		return htmlspecialchars($this->dataObject[$column], ENT_QUOTES);
	}
	function _getEditItem_afile($_labelHead, $_labelIndex, $_labelType, $_hidden=FALSE)
	{


		if($_labelHead){
			$column = $_labelHead . $_labelIndex . '_' . $_labelType;
		}else{
			$column = $_labelType;
		}

		$data = $this->ctrl->model->getData('afile', array('id', 'label_text', 'type_view'), "WHERE delete_datetime IS NULL AND acknowledge = 3 AND id = " . intval($this->dataObject[$column]), TRUE);
		if(! count($data)){
			$this->dataObject[$column] = '';
		}

		$html = "<div class=\"file-upload\"" . (($this->dataObject[$column]) ? ' style="display: none;"' : ''). "><a title=\"ファイル管理\" href=\"./afilewindow.php?action=list&amp;dir={$column}\" id=\"{$column}_a\" class=\"cboxaction\"><img height=\"21\" border=\"0\" width=\"137\" class=\"rollover\" alt=\"\" src=\"common/img/upload_btn.gif\"/></a></div>";
		$html .= "<div class=\"file-cancel\"" . ((! $this->dataObject[$column]) ? ' style="display: none;"' : ''). "><div><span>" . (isset($data[0]['label_text']) ? $data[0]['label_text'] : '') . "</span></div><a href=\"cancel.html\" onclick=\"return cancelImage('{$column}');\"><img height=\"21\" border=\"0\" width=\"20\" class=\"rollover\" src=\"common/img/upload_c_btn.gif\" alt=\"cancel file\"/></a><br /><img class=\"file-icon\" src=\"" . (isset($data[0]['label_text']) ? "../a.php?id={$data[0]['id']}&amp;mode=icon" : "common/img/loading.gif") . "\" />";

		return "<input type=\"text\" class=\"w640" . (!$_hidden && isset($this->errorList[$column]) ? ' error' : '') . "\" id=\"{$column}\" name=\"{$column}\" value=\"" . htmlspecialchars($this->dataObject[$column], ENT_QUOTES) . "\" style=\"display: none;\" /></div>{$html}";
	}
	/*
	 * _iradio : ラジオ
	 *	   内部変数を利用したラジオボタン
	 */
	function _getViewItem_iradio($_labelHead, $_labelIndex, $_labelType)
	{
		$masters = $this->{$_labelHead};
		$column = $_labelHead . $_labelIndex . '_' . $_labelType;
		return htmlspecialchars($masters[$this->dataObject[$column]], ENT_QUOTES);
	}
	function _getEditItem_iradio($_labelHead, $_labelIndex, $_labelType, $_hidden=FALSE)
	{
		$masters = $this->{$_labelHead};
		$column = $_labelHead . $_labelIndex . '_' . $_labelType;

		$html = '';
		for($i=1; $i<count($masters); $i++){
			$html .= "<label for=\"{$column}{$i}\" class=\"" . (isset($this->errors[$column]) ? ' error-message' : '') . "\"" . (($_hidden) ? "\" style=\"display: none;" : '') . "><input type=\"radio\" id=\"{$column}{$i}\" name=\"{$column}\" value=\"{$i}\" " . (($i == $this->dataObject[$column]) ? 'checked="checked" ' : '') . "/><span class=\"w30\">" . htmlspecialchars($masters[$i], ENT_QUOTES) . "</span></label>";
		}
		return $html;
	}
	/*
	 * _longcheck : チェックボックス
	 *			項目が32以上の場合
	 */
	function _getViewItem_longcheck($_labelHead, $_labelIndex, $_labelType)
	{
		$masters = $this->ctrl->model->getMaster($_labelHead);
		$column = $_labelHead . $_labelIndex . '_' . $_labelType;

		$html = '';
		$checks = explode(',', substr($this->dataObject[$column], 1, -1));
		for($i=1; $i<=count($masters); $i++){
			if(in_array($i, $checks)){
				$html .= $masters[$i] . ", ";
			}
		}
		return (strlen($html)) ? htmlspecialchars(substr($html, 0, -2), ENT_QUOTES) : "&nbsp;";
	}
	function _getEditItem_longcheck($_labelHead, $_labelIndex, $_labelType, $_hidden=FALSE)
	{
		$column = $_labelHead . $_labelIndex . '_' . $_labelType;
		$items = $this->ctrl->model->getMaster($_labelHead);
		$html = '';
		$checks = explode(',', substr($this->dataObject[$column], 1, -1));
		foreach($items as $k => $i){
			$html .= "<label for=\"{$column}{$k}\" class=\"" . (isset($this->errors[$column]) ? ' error-message' : '') . "\"" . (($_hidden) ? "\" style=\"display: none;" : '') . "><input type=\"checkbox\" id=\"{$column}{$k}\" name=\"{$column}[]\" value=\"{$k}\" " . (in_array($k, $checks) ? 'checked="checked" ' : '') . "/><span class=\"w30\">" . htmlspecialchars($i, ENT_QUOTES) . "</span></label>";
		}
		return $html;
	}
	function _getFormData_longcheck($_column)
	{
		if(is_array($this->ctrl->{$_column})){
			return '{' . implode(',', $this->ctrl->{$_column}) . '}';
		}else{
			return '{}';
		}
	}
	/*
	 * _password : パスワード
	 */
	function _getViewItem_password($_labelHead, $_labelIndex, $_labelType)
	{
		return '********';
	}
	function _getEditItem_password($_labelHead, $_labelIndex, $_labelType, $_hidden=FALSE)
	{
		$column = $_labelHead . $_labelIndex . '_' . $_labelType;

		return "<input type=\"password\" class=\"w160" . (!$_hidden && isset($this->errorList[$column]) ? ' error' : '') . "\" id=\"{$column}_confirm0\" name=\"" . $column . '_confirm0' . "\" value=\"" . (isset($this->dataObject[$column . '_confirm0']) ? $this->dataObject[$column . '_confirm0'] : '') . (($_hidden) ? "\" style=\"display: none;" : '') . "\" /><br /><input type=\"password\" class=\"w160" . (!$_hidden && isset($this->errorList[$column]) ? ' error' : '') . "\" id=\"{$column}_confirm1\" name=\"" . $column . '_confirm1' . "\" value=\"" . (isset($this->dataObject[$column . '_confirm1']) ? $this->dataObject[$column . '_confirm1'] : '') . (($_hidden) ? "\" style=\"display: none;" : '') . "\" />";
	}
	function _getParameters_password(& $_params, $_column)
	{
		$_params[] = $_column . '_confirm0';
		$_params[] = $_column . '_confirm1';
	}
	function _getFormData_password($_column)
	{
		if($this->ctrl->{$_column . '_confirm0'}){
			return sha1($this->ctrl->{$_column . '_confirm0'});
		}else{
			return '';
		}
	}
	/*
	 * _radio : ラジオ
	 *	   ラジオボタン
	 */
	function _getViewItem_radio($_labelHead, $_labelIndex, $_labelType)
	{
		$masters = $this->ctrl->model->getMaster($_labelHead);

		$column = $_labelHead . $_labelIndex . '_' . $_labelType;
		return htmlspecialchars($masters[$this->dataObject[$column]], ENT_QUOTES);
	}
	function _getEditItem_radio($_labelHead, $_labelIndex, $_labelType, $_hidden=FALSE)
	{
		$column = $_labelHead . $_labelIndex . '_' . $_labelType;

//		$items = $this->ctrl->model->getMaster($_labelHead);

		//カラムに数字があれば切り分ける（入力フォームのname属性は本来のもの）
		if(preg_match('/^([a-zA-Z]+)(\d+)$/', $_labelHead, $matches)){
			$items = $this->ctrl->model->getMaster($matches[1]);
		}else{
			$items = $this->ctrl->model->getMaster($_labelHead);
		}



		$html = '';
		foreach($items as $k => $i){
			$html .= "<label for=\"{$column}{$k}\" class=\"" . (isset($this->errors[$column]) ? ' error-message' : '') . "\"" . (($_hidden) ? "\" style=\"display: none;" : '') . "><input type=\"radio\" id=\"{$column}{$k}\" name=\"{$column}\" value=\"{$k}\" " . (($k == $this->dataObject[$column]) ? 'checked="checked" ' : '') . "/><span class=\"w30\">" . htmlspecialchars($i, ENT_QUOTES) . "</span></label>";
		}
		return $html;
	}
	/*
	 * _richtext : リッチテキストタイプ
	 *	   一般的なリッチテキストフォーム
	 */
	function _getViewItem_richtext($_labelHead, $_labelIndex, $_labelType)
	{
		$column = $_labelHead . $_labelIndex . '_' . $_labelType;
		return $this->dataObject[$column];
	}
	function _getEditItem_richtext($_labelHead, $_labelIndex, $_labelType, $_hidden=FALSE)
	{

		$column = $_labelHead . $_labelIndex . '_' . $_labelType;

		//カラム名に「2」が含まれているかチェック
		if(mb_ereg('2', $_labelHead, $matches)){
			return	"<textarea id=\"{$column}\" name=\"{$column}\" rows=\"12\" cols=\"60\" class=\"w640 mce-simple2" . (isset($this->errorList[$column]) ? ' error' : '') . (($_hidden) ? "\" style=\"display: none;" : '') . "\">" . htmlspecialchars($this->dataObject[$column], ENT_QUOTES) . "</textarea>";
		}
		//カラム名に「3」が含まれているかチェック
		if(mb_ereg('3', $_labelHead, $matches)){
			return	"<textarea id=\"{$column}\" name=\"{$column}\" rows=\"12\" cols=\"60\" class=\"w640 mce-simple3" . (isset($this->errorList[$column]) ? ' error' : '') . (($_hidden) ? "\" style=\"display: none;" : '') . "\">" . htmlspecialchars($this->dataObject[$column], ENT_QUOTES) . "</textarea>";
		}

		return	"<textarea id=\"{$column}\" name=\"{$column}\" rows=\"12\" cols=\"60\" class=\"w640 mce-simple" . (isset($this->errorList[$column]) ? ' error' : '') . (($_hidden) ? "\" style=\"display: none;" : '') . "\">" . htmlspecialchars($this->dataObject[$column], ENT_QUOTES) . "</textarea>";

	}
	/*
	 * _select : セレクトオプション
	 */
	function _getViewItem_select($_labelHead, $_labelIndex, $_labelType)
	{
		$masters = $this->ctrl->model->getMaster($_labelHead);

		$column = $_labelHead . $_labelIndex . '_' . $_labelType;
		if(isset($masters[$this->dataObject[$column]])){
			return $masters[$this->dataObject[$column]];
		}else{
			return NULL;
		}
	}
	function _getEditItem_select($_labelHead, $_labelIndex, $_labelType, $_hidden=FALSE)
	{
		$column = $_labelHead . $_labelIndex . '_' . $_labelType;

		//カラムに数字があれば切り分ける（入力フォームのname属性は本来のもの）
//		if(preg_match('/^(\w+)(\d+)$/', $_labelHead, $matches)){
		if(preg_match('/^([a-zA-Z]+)(\d+)$/', $_labelHead, $matches)){
			$items = $this->ctrl->model->getMaster($matches[1]);
		}else{
			$items = $this->ctrl->model->getMaster($_labelHead);
		}

		$html = "<select id=\"{$column}\" name=\"{$column}\" >";
		if(! isset($items[0])){
			$html .= "<option value=\"0\">--------</option>";
		}
		$showFolderGroup = array();
		if($_labelHead == 'folder'){
			$showFolderGroup = wowConst('ACCESS_FOLDER');
		}
		foreach($items as $k => $i){
			if(! isset($showFolderGroup[$k]) || $showFolderGroup[$k] & $_SESSION['user']['group_check']){
				$html .= "<option value=\"{$k}\" " . (($k == $this->dataObject[$column]) ? 'selected="selected" ' : '') . ">" . htmlspecialchars($i, ENT_QUOTES) . "</option>";
			}
		}
		$html .= "</select>\n";
		return $html;
	}
	/*
	 * _separator : 区切りタイプ
	 *	   一般的なテキストフォーム
	 */
	function _getEditItem_separator($_labelHead, $_labelIndex, $_labelType, $_hidden=FALSE)
	{
		if($_labelHead){
			$column = $_labelHead . $_labelIndex . '_' . $_labelType;
		}else{
			$column = $_labelType;
		}
		return "<hr class=\"separator\" />";
	}
	/*
	 * _text : テキストタイプ
	 *	   一般的なテキストフォーム
	 */
	function _getViewItem_text($_labelHead, $_labelIndex, $_labelType)
	{
		if($_labelHead){
			$column = $_labelHead . $_labelIndex . '_' . $_labelType;
		}else{
			$column = $_labelType;
		}
		return htmlspecialchars($this->dataObject[$column], ENT_QUOTES);
	}
	function _getEditItem_text($_labelHead, $_labelIndex, $_labelType, $_hidden=FALSE)
	{
		if($_labelHead){
			$column = $_labelHead . $_labelIndex . '_' . $_labelType;
		}else{
			$column = $_labelType;
		}
		return "<input type=\"text\" class=\"w640" . (!$_hidden && isset($this->errorList[$column]) ? ' error' : '') . "\" id=\"{$column}\" name=\"{$column}\" value=\"" . htmlspecialchars($this->dataObject[$column], ENT_QUOTES) . (($_hidden) ? "\" style=\"display: none;" : '') . "\" />";
	}
	/*
	 * _textarea : テキストエリアタイプ
	 *	   一般的な複数行テキストフォーム
	 */
	function _getViewItem_textarea($_labelHead, $_labelIndex, $_labelType)
	{
		$column = $_labelHead . $_labelIndex . '_' . $_labelType;
		return nl2br(htmlspecialchars($this->dataObject[$column], ENT_QUOTES));
	}
	function _getEditItem_textarea($_labelHead, $_labelIndex, $_labelType, $_hidden=FALSE)
	{
		$column = $_labelHead . $_labelIndex . '_' . $_labelType;
		return "<textarea id=\"{$column}\" name=\"{$column}\" rows=\"4\" cols=\"60\" class=\"w640" . (!$_hidden && isset($this->errorList[$column]) ? ' error' : '') . (($_hidden) ? "\" style=\"display: none;" : '') . "\">" . htmlspecialchars($this->dataObject[$column], ENT_QUOTES) . "</textarea>";
	}
	/*
	 * _float : 浮動小数点
	 */
	function _getViewItem_float($_labelHead, $_labelIndex, $_labelType)
	{
		return $this->_getViewItem_text($_labelHead, $_labelIndex, $_labelType);
	}
	/*
	 * _view : 編集不可テキストタイプ
	 */
	function _getEditItem_view($_labelHead, $_labelIndex, $_labelType, $_hidden=FALSE)
	{
		if($_labelHead){
			$column = $_labelHead . $_labelIndex . '_' . $_labelType;
		}else{
			$column = $_labelType;
		}
		return "<input type=\"text\" class=\"w640" . (!$_hidden && isset($this->errorList[$column]) ? ' error' : '') . "\" id=\"{$column}\" name=\"{$column}\" value=\"" . htmlspecialchars($this->dataObject[$column], ENT_QUOTES) . (($_hidden) ? "\" style=\"display: none;" : '') . "\" readonly=\"readonly\" />";
	}
	/**
	 * HH:MM:SS形式の時刻テキスト配列を作成する
	 *
	 * @param string $interval : 時刻間隔　[数値][h,m,s]
	 * @return array : 時刻テキスト配列
	 */
	function _createTimeList($interval='1h')
	{
		preg_match('/^(\d+.*\d*)([hms])$/', $interval, $matches);
		if(count($matches) != 3){
			$interval = 3600;
		}else if($matches[2] == 'h'){
			$interval = floor($matches[1] * 3600);
		}else if($matches[2] == 'm'){
			$interval = floor($matches[1] * 60);
		}else if($matches[2] == 's'){
			$interval = floor($matches[1]);
		}
		if($interval == 0){
			$interval = 3600;
		}
		$tList = array();
		for($current = 54000; $current < 140400; $current += $interval){
			$tList[] = date('H:i:s', $current);
		}
		return $tList;
	}
/*
???				$html .= "<label for=\"{$column}{$i['id']}\"{$hidden} class=\"" . (isset($this->errors[$column]) ? ' error-message' : '') . "\"><input type=\"checkbox\" id=\"{$column}{$i['id']}\" name=\"{$column}[]\" value=\"{$i['id']}\" " . ((is_array($values->{$column}) && in_array($i['id'], $values->{$column})) ? 'checked="checked" ' : '') . "/>" . htmlspecialchars($i['label_text'], ENT_QUOTES) . "</label>";

		}else if($type == 'longcheck'){
			$items = $this->_getItems($label);
			foreach($items as $i){
				if(is_array($values->{$column}) && in_array($i['id'], $values->{$column})){
					$html .= htmlspecialchars($i['label_text'], ENT_QUOTES) . ', ';
				}
			}
			$html = (strlen($html)) ? substr($html, 0, strlen($html) - 2) : '&nbsp;';
		}else if($type == 'longcheck'){
			$items = $this->_getItems($label);
			foreach($items as $i){
				$html .= "<label for=\"{$column}{$i['id']}\"{$hidden} class=\"" . (isset($this->errors[$column]) ? ' error-message' : '') . "\"><input type=\"checkbox\" id=\"{$column}{$i['id']}\" name=\"{$column}[]\" value=\"{$i['id']}\" " . ((is_array($values->{$column}) && in_array($i['id'], $values->{$column})) ? 'checked="checked" ' : '') . "/>" . htmlspecialchars($i['label_text'], ENT_QUOTES) . "</label>";
			}
			$html .= $this->_getErrorItem($column);
*/
}
?>
