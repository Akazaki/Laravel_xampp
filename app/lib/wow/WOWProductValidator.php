<?php
/**
 */
class WOWProductValidator extends Validator
{
	function validateDoneEdit($values)
	{
		//名称
		if($this->isEmpty($values['label_text'])){
			$this->addError('label_text', '必須項目です');
		}
		// else{
		// 	$db = $this->_useDb();
		// 	$label_result = $db->query("SELECT id FROM `product` WHERE label_text = '" . $values['label_text'] . "' AND delete_datetime IS NULL AND acknowledge = '3'");
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

		// キャップ
		$values['capsselect_text'] = str_replace(',','', $values['capsselect_text']);
		if($this->isEmpty($values['capsselect_text'])){
			$this->addError('capsselect_text', '必須項目です');
		}

		// 付属品
		// $values['accessoryselect_text'] = str_replace(',','', $values['accessoryselect_text']);
		// if($this->isEmpty($values['accessoryselect_text'])){
		// 	$this->addError('accessoryselect_text', '必須項目です');
		// }

		$tmp_array = array();

		//レコメンド商品1
		if(!$this->isEmpty($values['recommenda_text'])){

			//入力されている場合、商品名が登録されているかチェック
			$db = $this->_useDb();
			$result =& $db->query("SELECT id FROM `product` WHERE label_text = '" . $values['recommenda_text'] . "' AND delete_datetime IS NULL AND acknowledge = '3'");
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
			$result =& $db->query("SELECT id FROM `product` WHERE label_text = '" . $values['recommendb_text'] . "' AND delete_datetime IS NULL AND acknowledge = '3'");
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
			$result =& $db->query("SELECT id FROM `product` WHERE label_text = '" . $values['recommendc_text'] . "' AND delete_datetime IS NULL AND acknowledge = '3'");
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
			$result =& $db->query("SELECT id FROM `product` WHERE label_text = '" . $values['recommendd_text'] . "' AND delete_datetime IS NULL AND acknowledge = '3'");
			$row =& $result->fetchRow(MDB2_FETCHMODE_ASSOC);

			if(count($row) == 0){
				$this->addError('recommendd_text', '登録されていない商品です');
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
		
		if($this->isEmpty($values['acknowledge'])){
			$this->addError('acknowledge', '必須項目です');
		}

//		else if($this->getMaxCharacter($values['label_text']) > 20){
//			$this->addError('label_text', '20文字以内を指定してください');
//		}

		//素材
		// if($this->isEmpty($values['material_radio'])){
		// 	$this->addError('material_radio', '必須項目です');
		// }
		// if(!$this->isEmpty($values['material_radio']) && $values['material_radio'] == 1){
		
		// 	if(!$this->isEmpty($values['plastic_radio']) && $values['plastic_radio'] != 1){
		// 		$this->addError('material_radio', 'ガラスの場合は「プラスチック 種別」を「なし」に設定してください');
		// 	}else if(!$this->isEmpty($values['other_radio']) && $values['other_radio'] != 1){
		// 		$this->addError('material_radio', 'ガラスの場合は「その他 種別」を「なし」に設定してください');
		// 	}
		// }
		
		// if(!$this->isEmpty($values['material_radio']) && $values['material_radio'] == 2){
		
		// 	if(!$this->isEmpty($values['plastic_radio']) && $values['plastic_radio'] == 1){
		// 		$this->addError('material_radio', 'プラスチックの場合は「プラスチック 種別」を「なし」以外に設定してください');
		// 	}else if(!$this->isEmpty($values['other_radio']) && $values['other_radio'] != 1){
		// 		$this->addError('material_radio', 'プラスチックの場合は「その他 種別」を「なし」に設定してください');
		// 	}
		// }
		
		// if(!$this->isEmpty($values['material_radio']) && $values['material_radio'] == 3){
		
		// 	if(!$this->isEmpty($values['plastic_radio']) && $values['plastic_radio'] != 1){
		// 		$this->addError('material_radio', 'その他の場合は「プラスチック 種別」を「なし」に設定してください');
		// 	}else if(!$this->isEmpty($values['other_radio']) && $values['other_radio'] == 1){
		// 		$this->addError('material_radio', 'その他の場合は「その他 種別」を「なし」以外に設定してください');
		// 	}
		// }
		
		
		// //プラスティック 種別
		// if($this->isEmpty($values['plastic_radio'])){
		// 	$this->addError('plastic_radio', '必須項目です');
		// }


		
		// //その他 種別
		// if($this->isEmpty($values['other_radio'])){
		// 	$this->addError('other_radio', '必須項目です');
		// }
		
		
//		//口形状
//		if($this->isEmpty($values['mouth_check'])){
//			$this->addError('mouth_check', '必須項目です');
//		}

		//容器形状
		// if($this->isEmpty($values['container_radio'])){
		// 	$this->addError('container_radio', '必須項目です');
		// }
		
//		//用途
//		if($this->isEmpty($values['use_check'])){
//			$this->addError('use_check', '必須項目です');
//		}

		// //サンプル請求
		// if($this->isEmpty($values['order_radio'])){
		// 	$this->addError('order_radio', '必須項目です');
		// }

		//容量
		if(!$this->isEmpty($values['capacity_net_float'])){
			if(!$this->isNumber($values['capacity_net_float'])){
				$this->addError('capacity_net_float', '数値を入力してください');
			}else{
				if($this->isDecimal($values['capacity_net_float'])){
					if(!$this->isNumWithDecimal($values['capacity_net_float'], 2)){
						$this->addError('capacity_net_float', '小数点第二位までを指定してください');
					}
				}
			}
		}
		// //重量
		// if($this->isEmpty($values['weight_float'])){
		// 	$this->addError('weight_float', '必須項目です');
		// }else if(!$this->isNumber($values['weight_float'])){
		// 	$this->addError('weight_float', '数値を入力してください');
		// }else{
		// 	if($this->isDecimal($values['weight_float'])){
		// 		if(!$this->isNumWithDecimal($values['weight_float'], 2)){
		// 			$this->addError('weight_float', '小数点第二位までを指定してください');
		// 		}
		// 	}
		// }
		//幅
		if(!$this->isEmpty($values['width_float'])){
			if(!$this->isNumber($values['width_float'])){
				$this->addError('width_float', '数値を入力してください');
			}else{
				if($this->isDecimal($values['width_float'])){
					if(!$this->isNumWithDecimal($values['width_float'], 2)){
						$this->addError('width_float', '小数点第二位までを指定してください');
					}
				}
			}
		}
		//直径
		if(!$this->isEmpty($values['diameter_float'])){
			if(!$this->isNumber($values['diameter_float'])){
				$this->addError('diameter_float', '数値を入力してください');
			}else{
				if($this->isDecimal($values['diameter_float'])){
					if(!$this->isNumWithDecimal($values['diameter_float'], 2)){
						$this->addError('diameter_float', '小数点第二位までを指定してください');
					}
				}
			}
		}
		//高さ
		if(!$this->isEmpty($values['height_float'])){
			if(!$this->isNumber($values['height_float'])){
				$this->addError('height_float', '数値を入力してください');
			}else{
				if($this->isDecimal($values['height_float'])){
					if(!$this->isNumWithDecimal($values['height_float'], 2)){
						$this->addError('height_float', '小数点第二位までを指定してください');
					}
				}
			}
		}
/*
		//キャップ
		if($this->isEmpty($values['cap_text'])){
			$this->addError('cap_text', '必須項目です');
		}else if($this->getMaxCharacter($values['cap_text']) > 20){
			$this->addError('cap_text', '20文字以内を指定してください');
		}
		
		//入数
		if($this->isEmpty($values['qty_text'])){
			$this->addError('qty_text', '必須項目です');
		}else if($this->getMaxCharacter($values['qty_text']) > 20){
			$this->addError('qty_text', '20文字以内を指定してください');
		}
		
		//材質/色

		if($this->isEmpty($values['color_text'])){
			$this->addError('color_text', '必須項目です');
		}else if($this->getMaxCharacter($values['color_text']) > 20){
			$this->addError('color_text', '20文字以内を指定してください');
		}
*/

		//詳細
		// if($this->isEmpty($values['detail_textarea'])){
		// 	$this->addError('detail_textarea', '必須項目です');
		// }else if($this->getMaxCharacter($values['detail_textarea']) > 500){
		// 	$this->addError('detail_textarea', '500文字以内を指定してください');
		// }
		// if($this->isEmpty($values['f1_0_file'])){
		// 	$this->addError('f1_0_file', '必須項目です');
		// }
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
