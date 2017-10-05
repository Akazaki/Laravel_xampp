<?php

/**
 * WOWEditModel
 *
 */
class WOWEditModel
{
	var $ctrl = NULL;

	var $db = NULL;
	var $data = array();
	var $master = array();
	var $info = array();

	var $databaseCharacter = 'UTF-8';

	function WOWEditModel($_ctrl)
	{
		$this->ctrl = $_ctrl;
		$this->db = $this->_useDb();
	}

	/**
	 * テーブルからデータを取得する
	 *
	 * @params string $table : テーブル名
	 * @params array $columns : カラム名配列
	 * @params string $option : 選択オプション
	 * @params boolean $reset : 再読込み
	 */
	function getData($table, $columns=array('*'), $option='', $reset=FALSE)
	{
		if(! isset($this->data[$table]) || $reset){
			// セパレータを変換
			foreach($columns as $k => $v){
				if(strpos($v, '_separator') > 0){
					$columns[$k] = 'TRUE AS ' . $columns[$k];
				}
			}

			// 必須項目が無ければ付加
			if(! in_array('*', $columns)){
				if(! in_array('acknowledge', $columns)){
					array_unshift($columns, 'acknowledge');
				}
				if(! in_array('permission', $columns)){
					array_unshift($columns, 'permission');
				}
				if(! in_array('user_select', $columns)){
					array_unshift($columns, 'user_select');
				}
				if(! in_array('id', $columns)){
					array_unshift($columns, 'id');
				}
			}
			$tCol = implode(', ', $columns);
			$tCol = str_replace('data_bin, ', '1 AS data_bin, ', $tCol);
			$table = (wowConst('WOW_DATABASE_TYPE') == 'pgsql') ? "\"{$table}\"" : "`{$table}`";
			$result = $this->db->query("SELECT {$tCol} FROM {$table} {$option};");

			if(is_a($result, 'MDB2_Error')){
				echo '<plaintext>';print_r($result);die(); // -- CHECK CODE --
			}
			$this->data[$table] = $result->fetchAll(MDB2_FETCHMODE_ASSOC);
		}
		return $this->data[$table];
	}
	/**
	 * マスターテーブルからＩＤをキーにした配列を取得する
	 *
	 * @params string $table : テーブル名
	 */
	function getMaster($table)
	{
		if(! isset($this->master[$table])){
			$table = (wowConst('WOW_DATABASE_TYPE') == 'pgsql') ? "\"{$table}\"" : "`{$table}`";
			$result = $this->db->query("SELECT id, label_text FROM {$table} ORDER BY queue ASC;");
			if(is_a($result, 'MDB2_Error')){
				echo '<plaintext>';print_r($result);die(); // -- CHECK CODE --
			}
			$rows =& $result->fetchAll(MDB2_FETCHMODE_ASSOC);
			$tMaster = array();
			foreach($rows as $row){
				$tMaster[$row['id']] = $row['label_text'];
			}
			$this->master[$table] = $tMaster;
		}
		return $this->master[$table];
	}
	/**
	 * 情報テーブルからカラムの情報配列を取得
	 *
	 * @params string $table : テーブル名
	 */
	function getInformation($table)
	{
		if(! isset($this->info[$table])){
			$tInfo = array();
			foreach($this->getData('column_info', array('*'), 'WHERE table_text = \'' . $table . '\' ORDER BY queue, id', TRUE) as $row){
				$tInfo[$row['label_text']] = array('labeljp' => $row['labeljp_text'], 'remark' => $row['remark_text'] );
			}
			$this->info[$table] = $tInfo;
		}

		return $this->info[$table];
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
			foreach(wowConst('ACCESS_PERMISSION') as $acc){
				if(strpos($this->ctrl->SCRIPT_FROM_DOCUMENT_ROOT, $acc['script']) === 0){
					$data['permission'] = $acc['permission'];
					break;
				}
			}
		}
		return array($data);
	}
	/**
	 * データをテーブルに保存する
	 *
	 * @params string $table : テーブル名
	 * @params integer $id : ＩＤ
	 * @params array $columns : カラム名配列
	 */
	function setData($table, $columns, $data)
	{
		$id = intval($data['id']);

		// 事前調査
		$beforData = array();
		$table = (wowConst('WOW_DATABASE_TYPE') == 'pgsql') ? "\"{$table}\"" : "`{$table}`";
		if($id > 0){
			$result = $this->db->query("SELECT * FROM {$table} WHERE id = {$id};");
			$beforData =& $result->fetchRow(MDB2_FETCHMODE_ASSOC);
		}

		// 書き込み権限のチェック
		if(FALSE){
			return FALSE;
		}

		$sql = '';
		if($beforData){
		// 更新
			// 準備
			$columns = array_diff($columns, array('id'));

			// 更新
			$sql = "UPDATE {$table} SET ";
			foreach($columns as $c){
				if(isset($data[$c]) && $data[$c] == '' && preg_match('/^.*_password$/', $c)){
				// パスワードが空で入力された場合は更新しない
					continue;
				}else if(isset($data[$c]) && $c == 'data_bin'){
					if(! $data[$c]) continue;

					$originalPath = $_SERVER['DOCUMENT_ROOT'] . wowConst('HTTP_DOCUMENT_ROOT') . '/wow/uploadfiles/' . $data[$c];
					$iconPath = $_SERVER['DOCUMENT_ROOT'] . wowConst('HTTP_DOCUMENT_ROOT') . '/wow/uploadfiles/i' . $data[$c];
					// オリジナル画像の保存
					$original = $this->_readImageFile($originalPath);

					$sql .= "data_bin = " . $this->db->quote($original, 'blob') . ", ";

					// アイコン画像の保存
					if(mb_eregi(".+\.(jpe?g|gif|png)$", $originalPath)){
						require_once dirname(__FILE__) . '/FileTool.php';
						$ft = new FileTool($originalPath);
						$ft->resizeImage($iconPath, 120, 120, '#FFFFFF');

						$icon = $this->_readImageFile($iconPath);
						$sql .= "icon_bin = " . $this->db->quote($icon, 'blob') . ", ";
					}

				}else if(isset($data[$c]) && preg_match('/^.*_bin$/', $c)){
					$bin = $this->_readImageFile($_SERVER['DOCUMENT_ROOT'] . wowConst('HTTP_DOCUMENT_ROOT') . '/wow/uploadfiles/' . $data[$c]);
					$sql .= "{$c} = " . $this->db->quote($bin, 'blob') . ", ";
				}else if(isset($data[$c]) && preg_match('/^.*_separator$/', $c)){
				}else if(isset($data[$c])){
					$sql .= "{$c} = " . $this->db->quote($this->_changeLocalCharacter($data[$c])) . ", ";
				}else{
					$sql .= "{$c} = '', ";
				}
			}
			$sql = (strlen($sql)) ? substr($sql, 0, -2) : '';

			$sql .= " WHERE id = '{$id}'";
		}else{
		// 新規追加
			// 準備
			$columns = array_diff($columns, array('id'));

			if(in_array('permission', $this->ctrl->_definedColumns)){
				$columns[] = 'permission';
				$data['permission'] = 0700;

				foreach(wowConst('ACCESS_PERMISSION') as $acc){
					if(strpos($this->ctrl->SCRIPT_FROM_DOCUMENT_ROOT, $acc['script']) === 0){
						$data['permission'] = $acc['permission'];
						break;
					}
				}
			}
			if(in_array('user_select', $this->ctrl->_definedColumns)){
				$columns[] = 'user_select';
				$data['user_select'] = $_SESSION['user']['id']; // SET する
			}

			$columns = array_unique($columns);

			// 挿入
			$col = $val = '';
			foreach($columns as $c){
				if(isset($data[$c]) && $c == 'data_bin'){
					$originalPath = $_SERVER['DOCUMENT_ROOT'] . wowConst('HTTP_DOCUMENT_ROOT') . '/wow/uploadfiles/' . $data[$c];
					$iconPath = $_SERVER['DOCUMENT_ROOT'] . wowConst('HTTP_DOCUMENT_ROOT') . '/wow/uploadfiles/i' . $data[$c];
					// オリジナル画像の保存
					$col .= "{$c}, ";
					$original = $this->_readImageFile($originalPath);
					$val .= $this->db->quote($original, 'blob') . ", ";

					// アイコン画像の保存
					if(mb_eregi(".+\.(jpe?g|gif|png)$", $originalPath)){
						require_once dirname(__FILE__) . '/FileTool.php';
						$ft = new FileTool($originalPath);
						$ft->resizeImage($iconPath, 120, 120, '#FFFFFF');

						$col .= "icon_bin, ";
						$icon = $this->_readImageFile($iconPath);
						$val .= $this->db->quote($icon, 'blob') . ", ";
					}
				}else if(isset($data[$c]) && preg_match('/^.*_separator$/', $c)){
				}else if(isset($data[$c])){
					$col .= "{$c}, ";
					$val .= $this->db->quote($this->_changeLocalCharacter($data[$c])) . ", ";
				}else{
					$col .= "{$c}, ";
					$val .= "NULL, ";
				}
			}
			$col = (strlen($col)) ? substr($col, 0, -2) : '';
			$val = (strlen($val)) ? substr($val, 0, -2) : '';
			$sql = "INSERT INTO {$table} ( {$col} ) values ( {$val} )";
		}

		return $this->db->exec($sql);
	}

	/*
	 * テーブルのカラム名配列を取得
	 *
	 * @param string $table :
	 * @return array :
	 */
	function getColumns($table)
	{
		$label = array();

		$result =& $this->db->query("SELECT label_text FROM column_info WHERE table_text = '{$table}' ORDER BY queue, id");
		$rows =& $result->fetchAll(MDB2_FETCHMODE_ASSOC);
		foreach($rows as $r){
//			if($r['label_text'] != 'table' && $r['label_text'] != 'id' && $r['label_text'] != 'queue'){
			if($r['label_text'] != 'table'){
				$label[] = $r['label_text'];
			}
		}

		$dbtype = wowConst('WOW_DATABASE_TYPE');
		if($dbtype == 'pgsql'){
			$result =& $this->db->query("SELECT att.attname FROM pg_attribute as att INNER JOIN pg_stat_user_tables stat ON att.attrelid = stat.relid WHERE att.attnum > 0 AND stat.schemaname='public' AND stat.relname='{$table}' AND att.attisdropped = false ORDER BY att.attnum");
			$rows =& $result->fetchAll(MDB2_FETCHMODE_ASSOC);
			foreach($rows as $r){
				$label[] = $r['attname'];
			}
		}else if($dbtype == 'mysql'){
			$result =& $this->db->query("SHOW COLUMNS FROM {$table}");
			$rows =& $result->fetchAll(MDB2_FETCHMODE_ASSOC);
			foreach($rows as $r){
				$label[] = $r['field'];
			}
		}else{
		}

		if(count($label)){
			$label = array_unique($label);
			return $label;
		}
		return $label;
	}

	/**
	 * ＤＢを使用する準備
	 *
	 * @return DB object
	 */
	function _useDb(){
		require_once dirname(__FILE__) . '/../../lib/Guesswork/DB.php';
		$db = new DB();
		return $db->connect();
	}

	/**
	 *
	 */
	function _readImageFile($path)
	{
		$fp = fopen($path, 'rb');
		$bin = fread($fp, filesize($path));
		fclose($fp);

		return $bin;
	}

	/**
	 * DBがUTF8でない場合に機種依存文字を変換する
	 */
	function _changeLocalCharacter($string)
	{
		if($this->databaseCharacter == 'EUC'){
			// 波ダッシュを全角チルダに変換
			$string = mb_ereg_replace('\xE3\x80\x9C', '～', $string);
			// 特殊なシングルクォートを変換
			$string = mb_ereg_replace('\xCA\xBC', '\'', $string);
			return $string;
		}else{
			return $string;
		}
	}

}
?>
