<?php
/**
 */
class WOWBaseValidator extends Validator
{
	var $controller = '';
	
//	function WOWBaseValidator($controller)
//	{
//		$this->controller = $controller;
//	}

	function validateConfirmLogin($values)
	{

		if($this->isEmpty($values['wowname']) || $values['wowname'] == 'ユーザーID'){
			$this->addError('wowname', '『ユーザー名』が入力されていません');
		}
		if($this->isEmpty($values['password'])){
			$this->addError('password', '『パスワード』が入力されていません');
		}
		if(! $this->isEmpty($values['wowname']) && ! $this->isEmpty($values['password'])){
			$db = $this->_useDb();
			if(wowConst('WOW_DATABASE_TYPE') == 'pgsql'){
				$result =& $db->query('SELECT * FROM "user" WHERE delete_datetime IS NULL AND label_text = ' . $db->quote($values['wowname']) . ' AND password_password = ' . $db->quote(sha1($values['password'])));
			}else{
				$result =& $db->query('SELECT * FROM `user` WHERE delete_datetime IS NULL AND label_text = ' . $db->quote($values['wowname']) . ' AND password_password = ' . $db->quote(sha1($values['password'])));
			}

			$row =& $result->fetchRow(MDB2_FETCHMODE_ASSOC);
			if(count($row) === 0){
				$this->addError('password', '『ユーザー名』または『パスワード』が間違っています');
			}else if(! $this->checkAddress($row['ip_text'])){
				$this->addError('password', '接続先のＩＰアドレスが許可されていません');
			}else if($row['acknowledge'] != 3){
				$this->addError('password', 'このユーザーは承認されていません');
			}else{
				$_SESSION['user'] = $row;
			}
		}
	}

	function validateLogout()
	{
		unset($_SESSION['user']);
	}


	/**
	 * ＤＢを使用する準備
	 *
	 * @return DB object
	 */
	function _useDb(){
		require_once dirname(__FILE__) . '/../../lib/Guesswork/DB.php';
		$db = new DB();
		return $db->connect();
	}

	/**
	 * ＩＰアドレスが許可ネットワークに入っているかチェックする
	 *
	 * @param string $allowNetwork : xxx.xxx.xxx.xxx/nn
	 * @return boolean
	 */
	function checkAddress($allowNetwork)
	{
		$pos = strpos($allowNetwork, '/');
		$allowAddress = ($pos === FALSE) ? $allowNetwork : substr($allowNetwork, 0, $pos);
		$allowMask = ($pos === FALSE) ? 32 : intval(substr($allowNetwork, $pos+1));

		if($allowMask === 0){
			return TRUE;
		}else{
			return (ip2long($_SERVER['REMOTE_ADDR']) >> (32 - $allowMask) === ip2long($allowAddress) >> (32 - $allowMask));
		}
	}
}
?>
