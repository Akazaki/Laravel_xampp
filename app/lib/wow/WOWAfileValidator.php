<?php
/**
 */
class WOWAfileValidator extends Validator
{
	function validateDoneEdit($values)
	{
		if($values['id'] == 0 && $this->isEmpty($values['data_bin'])){
			$this->addError('data_bin', '必須項目です');
		}else if($this->isEmpty($values['type_view']) && $this->isEmpty($values['data_bin'])){
			$this->addError('data_bin', '必須項目です');
		}else if(! mb_eregi('^.*(pdf)$', $values['type_view'])){
			$this->addError('data_bin', 'ファイルはPDFを指定してください');
		}
		if($this->isEmpty($values['label_text'])){
			$this->addError('label_text', '必須項目です');
		}
	}
}
?>
