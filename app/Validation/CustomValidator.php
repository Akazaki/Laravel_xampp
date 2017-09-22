<?php 	

namespace Validation;

class CustomValidator extends \Illuminate\Validation\Validator
{
	/**
	* ふりがなのバリデーション
	*
	* @param $attribute
	* @param $value
	* @param $parameters
	* @return bool
	*/
	public function validateKana($attribute, $value, $parameters)
	{
		if (mb_strlen($value) > 100) {
			return false;
		}	

		if (preg_match('/[^ぁ-んー]/u', $value) !== 0) {
			return false;
		}

		return false;
	}

    // 電話番号
    public function validateJapantel($attribute, $value, $parameters)
    {
        if (preg_match("/^[0-9]{2,4}-[0-9]{2,4}-[0-9]{3,4}$/", $value) ||
            preg_match("/^[0-9]{2,4}[0-9]{2,4}[0-9]{3,4}$/", $value)) {
            return true;
        }
    }

    // 郵便番号
	public function validateZip($attribute, $value, $parameters)
    {
        if (preg_match('/^[0-9]{3}-[0-9]{4}\z/', $value) || 
            preg_match('/^[0-9]{7}\z/', $value)) {
                return true;
        }
    }
}
