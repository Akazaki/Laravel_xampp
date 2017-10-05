<?php
/**
 */
class WOWCapsValidator extends Validator
{
	function validateDoneEdit($values)
	{
		//名称
		if($this->isEmpty($values['label_text'])){
			$this->addError('label_text', '必須項目です');
		}

		// else{
		// 	$db = $this->_useDb();
		// 	$label_result = $db->query("SELECT id FROM `caps` WHERE label_text = '" . $values['label_text'] . "' AND delete_datetime IS NULL AND acknowledge = '3'");
		// 	$label_row = $label_result->fetchRow(MDB2_FETCHMODE_ASSOC);

		// 	if(count($label_row) > 0){
		// 		$this->addError('label_text', '既に登録されてる商品名です');
		// 	}
		// }
		
		if($this->isEmNumberEnglish($values['label_text'])){
			$this->addError('label_text', '全角英数字は登録できません');
		}

		if($this->isEmpty($values['f1_0_file'])){
			$this->addError('f1_0_file', '必須項目です');
		}

		$tmp_array = array();

		//レコメンド商品1
		if(!$this->isEmpty($values['recommenda_text'])){

			//入力されている場合、商品名が登録されているかチェック
			$db = $this->_useDb();
			$result = $db->query("SELECT id FROM `caps` WHERE label_text = '" . $values['recommenda_text'] . "' AND delete_datetime IS NULL AND acknowledge = '3'");
			$row =& $result->fetchRow(MDB2_FETCHMODE_ASSOC);

			if(count($row) == 0){
				$this->addError('recommenda_text', '登録されていない商品です');
			}else{
				if($values['label_text'] != '' && $values['label_text'] == $values['recommenda_text']){
					$this->addError('recommenda_text', '登録商品は関連商品に登録できません');
				}

				array_push($tmp_array, $values['recommenda_text']);
			}
		}

		//レコメンド商品2
		if(!$this->isEmpty($values['recommendb_text'])){
			//入力されている場合、商品名が登録されているかチェック
			$db = $this->_useDb();
			$result = $db->query("SELECT id FROM `caps` WHERE label_text = '" . $values['recommendb_text'] . "' AND delete_datetime IS NULL AND acknowledge = '3'");
			$row =& $result->fetchRow(MDB2_FETCHMODE_ASSOC);

			if(count($row) == 0){
				$this->addError('recommendb_text', '登録されていない商品です');
			}else{
				//関連商品の重複チェック
				if(array_search($values['recommendb_text'], $tmp_array) !== false){
					$this->addError('recommendb_text', '既に登録されている関連商品です');
				}else{

					if($values['label_text'] != '' && $values['label_text'] == $values['recommendb_text']){
						$this->addError('recommendb_text', '登録商品は関連商品に登録できません');
					}

					array_push($tmp_array, $values['recommendb_text']);
				}
			}
		}

		//レコメンド商品3
		if(!$this->isEmpty($values['recommendc_text'])){
			//入力されている場合、商品名が登録されているかチェック
			$db = $this->_useDb();
			$result = $db->query("SELECT id FROM `caps` WHERE label_text = '" . $values['recommendc_text'] . "' AND delete_datetime IS NULL AND acknowledge = '3'");
			$row =& $result->fetchRow(MDB2_FETCHMODE_ASSOC);

			if(count($row) == 0){
				$this->addError('recommendc_text', '登録されていない商品です');
			}else{
				//関連商品の重複チェック
				if(array_search($values['recommendc_text'], $tmp_array) !== false){
					$this->addError('recommendc_text', '既に登録されている関連商品です');
				}else{

					if($values['label_text'] != '' && $values['label_text'] == $values['recommendc_text']){
						$this->addError('recommendc_text', '登録商品は関連商品に登録できません');
					}

					array_push($tmp_array, $values['recommendc_text']);
				}
			}
		}

		//レコメンド商品4
		if(!$this->isEmpty($values['recommendd_text'])){
			//入力されている場合、商品名が登録されているかチェック
			$db = $this->_useDb();
			$result =& $db->query("SELECT id FROM `caps` WHERE label_text = '" . $values['recommendd_text'] . "' AND delete_datetime IS NULL AND acknowledge = '3'");
			$row = $result->fetchRow(MDB2_FETCHMODE_ASSOC);

			if(count($row) == 0){
				$this->addError('recommendd_text', '登録されていない商品です');
			}
		}
		
		if($this->isEmpty($values['acknowledge'])){
			$this->addError('acknowledge', '必須項目です');
		}else{
			//関連商品の重複チェック
			if(array_search($values['recommendd_text'], $tmp_array) !== false){
				$this->addError('recommendd_text', '既に登録されている関連商品です');
			}else{

				if($values['label_text'] != '' && $values['label_text'] == $values['recommendd_text']){
					$this->addError('recommendd_text', '登録商品は関連商品に登録できません');
				}

				array_push($tmp_array, $values['recommendd_text']);
			}
		}
	}


	//整数チェック
	function isNumber($value) {
		if (preg_match("/^([1-9]\d*|0)(\.\d+)?$/", $value)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	//小数点チェック
	function isDecimal($value) {
		if (preg_match("/^([1-9]\d*|0)(\.\d+)$/", $value)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	//小数許容（第2引数が小数点以下の桁数）
	function isNumWithDecimal($val, $deci){
		if(preg_match('/^([1-9]\d*|0)(\.\d{1,'.$deci.'})$/', $val)){
			return TRUE;
		}else{
			return FALSE;
		}
	}


	
	//全角英数チェック
	function isEmNumberEnglish($value) {
		if (preg_match("/[ａ-ｚＡ-Ｚ０-９]/u", $value)) {
			return TRUE;
		} else {
			return FALSE;
	
		}
	}
	
	
	
	/**
	 * DBを使用する準備
	 *
	 * @return DB object
	 */
	function _useDb(){
		require_once dirname(__FILE__) . '/../../lib/Guesswork/DB.php';
		$db = new DB();
		return $db->connect();
	}
}
?>
