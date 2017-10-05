<?php
/**
 */
class WOWMemberValidator extends Validator
{
	function validateDoneEdit($values)
	{
	
		//■ メールアドレス
		if($this->isEmpty($values['label_text'])){
			$this->addError('label_text', 'メールアドレスを入力して下さい');
		}else if(! $this->isEmail($values['label_text'])){
			$this->addError('label_text', 'メールアドレスの形式が間違っています');
		}

		/*
		if($this->isEmpty($values['password_password_confirm0']) || $this->isEmpty($values['password_password_confirm1'])){
			$this->addError('password_password', 'パスワードを入力して下さい');
		}else if($this->getMaxCharacter($values['password_password_confirm0']) < 8 || 16 < $this->getMaxCharacter($values['password_password_confirm0'])){
			$this->addError('password_password', 'パスワード確認は8文字以上入力してください');
		}else if($values['password_password_confirm0'] !== $values['password_password_confirm1']){
			$this->addError('password_password', 'パスワードが異なります');
		}else if(!$this->isAlphanumeric($values['password_password_confirm0'])){
			$this->addError('password_password', '半角英数字を指定してください');
		}
		*/
		
		//■ パスワード
		if($this->isEmpty($values['password_password_confirm0'])){
			$this->addError('password_password', "パスワードを入力して下さい");
		}elseif(strlen($values['password_password_confirm0']) < 8){
			$this->addError('password_password', "パスワードは8文字以上入力してください");
		}elseif(!$this->isAlphanumeric($values['password_password_confirm0'])){
			$this->addError('password_password', "パスワードは半角英数字で入力してください");
		}
		
		//■ パスワード確認
		if($this->isEmpty($values['password_password_confirm1'])){
			$this->addError('password_password', "パスワード確認を入力して下さい");
		}elseif(strlen($values['password_password_confirm1']) < 8){
			$this->addError('password_password', "パスワード確認は8文字以上入力してください");
		}elseif(!$this->isAlphanumeric($values['password_password_confirm1'])){
			$this->addError('password_password', "パスワード確認は半角英数字で入力してください");
		}	
		
		
		if(!$this->isEmpty($values['password_password_confirm0']) && !$this->isEmpty($values['password_password_confirm1'])){
			if($values['password_password_confirm0'] != $values['password_password_confirm1']){
				$this->addError('password_password', "パスワードが確認と一致しません");
			}
		}
		
		
		
		//■ 法人名
		if($this->isEmpty($values['corporate_text'])){
			$this->addError('corporate_text', "法人名を入力して下さい");
		}
		
		//■ 法人名フリガナ
		if($this->isEmpty($values['corporatekana_text'])){
			$this->addError('corporatekana_text', "法人名フリガナを入力して下さい");
		}elseif(!$this->isKatakana($values['corporatekana_text'])){
			$this->addError('corporatekana_text', "法人名フリガナの形式が間違っています");
		}
		
		//■ 業種
		if($this->isEmpty($values['business_text'])){
			$this->addError('business_text', "業種を入力して下さい");
		}
		
		//■ お名前
		if($this->isEmpty($values['name_text'])){
			$this->addError('name_text', "氏名を入力して下さい");
		}

		//■ フリガナ
		if($this->isEmpty($values['kana_text'])){
			$this->addError('kana_text', "フリガナを入力して下さい");
		}elseif(!$this->isKatakana($values['kana_text'])){
			$this->addError('kana_text', "フリガナの形式が間違っています");
		}
		
		//■ 郵便番号1
		if($this->isEmpty($values['zip_text'])){
			$this->addError('zip_text', "郵便番号を入力して下さい");
		}elseif(!$this->isNumber($values['zip_text'],7)){
			$this->addError('zip_text', "郵便番号1は7桁の数値で入力して下さい");
		}
		
		
		//■ 都道府県
		if($this->isEmpty($values['prefecture_select'])){
			$this->addError('prefecture_select', '都道府県を入力して下さい');
		}else if($values['prefecture_select'] == 0){
			$this->addError('prefecture_select', '都道府県を入力して下さい');
		}
		
		//■ 住所1
		if($this->isEmpty($values['address_text'])){
			$this->addError('address_text', "住所1を入力して下さい");
		}
		
//		//■ 住所2
//		if($this->isEmpty($values['building_text'])){
//			$this->addError('building_text', "住所2を入力して下さい");
//		}
		
		//■ 電話番号
		if($this->isEmpty($values['tel_text'])){
			$this->addError('tel_text', "電話番号を入力して下さい");
		}elseif(!$this->isTelephone($values['tel_text'])){
			$this->addError('tel_text', "電話番号の形式が間違っています");
		}	
		
		//■ FAX番号
		if(!$this->isEmpty($values['fax_text'])){
			if(!$this->isTelephone($values['fax_text'])){
				$this->addError('fax_text', "FAX番号の形式が間違っています");
			}
		}
		
		
		//■ メールマガジンの配信
		// if($this->isEmpty($values['mailmagazine_radio'])){
		// 	$this->addError('mailmagazine_radio', "メールマガジンの配信を入力して下さい");
		// }
		
		
		/*
		if($this->isEmpty($values['corporate_text'])){
			$this->addError('corporate_text', '必須項目です');
		}else if($this->getMaxCharacter($values['corporate_text']) > 50){
			$this->addError('corporate_text', '50文字以内を指定してください');
		}

		if($this->isEmpty($values['name_text'])){
			$this->addError('name_text', '必須項目です');
		}else if($this->getMaxCharacter($values['name_text']) > 50){
			$this->addError('name_text', '50文字以内を指定してください');
		}

		if($this->isEmpty($values['kana_text'])){
			$this->addError('kana_text', '必須項目です');
		}else if(!$this->isHiragana($values['kana_text'])){
			$this->addError('kana_text', 'かなを指定してください');
		}else if($this->getMaxCharacter($values['kana_text']) > 50){
			$this->addError('kana_text', '50文字以内を指定してください');
		}

		if($this->isEmpty($values['zip_text'])){
			$this->addError('zip_text', '必須項目です');
		}else if(!$this->isNumber($values['zip_text'], 7)){
			$this->addError('zip_text', '7桁の半角数字を指定してください');
		}

		if($this->isEmpty($values['prefecture_select'])){
			$this->addError('prefecture_select', '必須項目です');
		}else if($values['prefecture_select'] == 0){
			$this->addError('prefecture_select', '必須項目です');
		}

		if($this->isEmpty($values['address_text'])){
			$this->addError('address_text', '必須項目です');
		}else if($this->getMaxCharacter($values['address_text']) > 100){
			$this->addError('address_text', '100文字以内を指定してください');
		}

		if(!$this->isEmpty($values['building_text'])){
			if($this->getMaxCharacter($values['building_text']) > 100){
				$this->addError('building_text', '100文字以内を指定してください');
			}
		}

		if(!$this->isEmpty($values['tel_text'])){
			if(!$this->isTelephone($values['tel_text'])){
				$this->addError('tel_text', '入力形式が違います');
			}
		}

		if(!$this->isEmpty($values['mobile_text'])){
			if(!$this->isTelephone($values['mobile_text'])){
				$this->addError('mobile_text', '入力形式が違います');
			}
		}
		*/
	}

	//かなチェック（スペース込）
	function isHiragana($string)
	{
		if(preg_match('/^[ぁ-んー 　]+$/u', $string)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
}
?>
