<?php
/**
 * ブログ検証用ヴァリデータ。
 */
class WOWUserValidator extends Validator
{
	function WOWUserValidator()
	{
	}

	/**
	 * 確認アクションでの検証。
	 *
	 * @access public
	 * @param array $values
	 */
	function validateDoneEdit($values)
	{
		if($this->isEmpty($values['label_text'])){
			$this->addError('label_text', '必須項目です');
		}
		if($this->isEmpty($values['ip_text'])){
			$this->addError('ip_text', '必須項目です');
		}
	}
}
?>
