<?php
/**
 */
class WOWFilecsvValidator extends Validator
{
	function validateDoneUpload($values)
	{
		if($this->isEmpty($values['csv']->name)){
			$this->addError('csv', 'CSVを選択してください');
		}
	}
}
?>
