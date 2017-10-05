<?php
/**
 */
class WOWFileValidator extends Validator
{
	function validateDoneEdit($values)
	{
		if($values['id'] == 0 && $this->isEmpty($values['data_bin'])){
			$this->addError('data_bin', '必須項目です');
		}else if($this->isEmpty($values['type_view']) && $this->isEmpty($values['data_bin'])){
			$this->addError('data_bin', '必須項目です');
		}else if(! mb_eregi('^.*(jpe?g|png|gif)$', $values['type_view'])){
			$this->addError('data_bin', 'ファイルはJPEG, GIF, PNGから選択してください。');
		}
		if($this->isEmpty($values['label_text'])){
			$this->addError('label_text', '必須項目です');
		}
		
		
		if($this->isEmpty($values['folder_select'])){
			$this->addError('folder_select', 'フォルダを入力して下さい');
		}else if($values['folder_select'] == 0){
			$this->addError('folder_select', 'フォルダを入力して下さい');
		}
	}
}
?>
