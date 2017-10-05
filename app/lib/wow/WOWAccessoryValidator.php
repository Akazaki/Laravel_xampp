<?php
/**
 */
class WOWAccessoryValidator extends Validator
{
	function validateDoneEdit($values)
	{
		//名称
		if($this->isEmpty($values['label_text'])){
			$this->addError('label_text', '必須項目です');
		}
		
		if($this->isEmNumberEnglish($values['label_text'])){
			$this->addError('label_text', '全角英数字は登録できません');
		}

		// if($this->isEmpty($values['f1_0_file'])){
		// 	$this->addError('f1_0_file', '必須項目です');
		// }
		
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

		// //容量
		// if($this->isEmpty($values['capacity_float'])){
		// 	$this->addError('capacity_float', '必須項目です');
		// }else if(!$this->isNumber($values['capacity_float'])){
		// 	$this->addError('capacity_float', '数値を入力してください');
		// }else{
		// 	if($this->isDecimal($values['capacity_float'])){
		// 		if(!$this->isNumWithDecimal($values['capacity_float'], 2)){
		// 			$this->addError('capacity_float', '小数点第二位までを指定してください');
		// 		}
		// 	}
		// }
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
		// //幅
		// if($this->isEmpty($values['width_float'])){
		// 	$this->addError('width_float', '必須項目です');
		// }else if(!$this->isNumber($values['width_float'])){
		// 	$this->addError('width_float', '数値を入力してください');
		// }else{
		// 	if($this->isDecimal($values['width_float'])){
		// 		if(!$this->isNumWithDecimal($values['width_float'], 2)){
		// 			$this->addError('width_float', '小数点第二位までを指定してください');
		// 		}
		// 	}
		// }
		// //直径
		// if(!$this->isEmpty($values['diameter_float'])){
		// 	if(!$this->isNumber($values['diameter_float'])){
		// 		$this->addError('diameter_float', '数値を入力してください');
		// 	}else{
		// 		if($this->isDecimal($values['diameter_float'])){
		// 			if(!$this->isNumWithDecimal($values['diameter_float'], 2)){
		// 				$this->addError('diameter_float', '小数点第二位までを指定してください');
		// 			}
		// 		}
		// 	}
		// }
		// //高さ
		// if($this->isEmpty($values['height_float'])){
		// 	$this->addError('height_float', '必須項目です');
		// }else if(!$this->isNumber($values['height_float'])){
		// 	$this->addError('height_float', '数値を入力してください');
		// }else{
		// 	if($this->isDecimal($values['height_float'])){
		// 		if(!$this->isNumWithDecimal($values['height_float'], 2)){
		// 			$this->addError('height_float', '小数点第二位までを指定してください');
		// 		}
		// 	}
		// }
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
