<?php
/**
 */
class WOWNewsValidator extends Validator
{
	function validateDoneEdit($values)
	{
		if($this->isEmpty($values['label_text'])){
			$this->addError('label_text', '必須項目です');
		}else if($this->getMaxCharacter($values['label_text']) > 30){
			$this->addError('label_text', '30文字以内を指定してください');
		}

		$_detailtxt = preg_replace('/<("[^"]*"|\'[^\']*\'|[^\'">])*>/','', $values['detail_richtext']);
		if($this->isEmpty($_detailtxt)){
			$this->addError('detail_richtext', '必須項目です');
		}else if($this->getMaxCharacter($_detailtxt) > 3000){
			$this->addError('detail_richtext', '3000文字以内を指定してください');
		}
		
//		if($this->isEmpty($values['information_radio'])){
//			$this->addError('information_radio', '必須項目です');
//		}
	}
}
?>
