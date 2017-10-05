<?php
/**
 */
class WOWAccessor
{
	var $ctrl = NULL;

	function WOWAccessor($_ctrl)
	{
		$this->ctrl = $_ctrl;
	}

	/**
	 * ACCESS_PERMISSIONとSESSIONユーザ情報をみて項目が表示できるかどうかのチェック
	 *
	 * @param string $script : スクリプト名
	 * @return boolean :
	 */
	function checkView($script='')
	{
		if(! isset($_SESSION['user'])){
			return FALSE;
		}

		foreach(wowConst('ACCESS_PERMISSION') as $acc){
			if(strpos($script, $acc['script']) === 0){
				if(isset($acc['group']) && ((1 << ($acc['group']-1)) & $_SESSION['user']['group_check']) !== 0){
					return TRUE;
				}else if(isset($acc['acknowledge']) && ((1 << ($acc['acknowledge']-1)) & $_SESSION['user']['group_check']) !== 0){
					return TRUE;
				}else{
					return FALSE;
				}
			}
		}
		return TRUE;
	}

	/**
	 * ACCESS_PERMISSIONとSESSIONユーザ情報をみて項目が承認を必要としているかどうかのチェック
	 *
	 * @param string $script : スクリプト名
	 * @return boolean :
	 */
	function checkNeedAcknowledge($script='')
	{
		foreach(wowConst('ACCESS_PERMISSION') as $acc){
			if(strpos($script, $acc['script']) === 0 && $acc['acknowledge'] !== FALSE){
				return TRUE;
			}
		}
		return FALSE;
	}

	/**
	 * ACCESS_PERMISSIONとSESSIONユーザ情報、記事パーミッションをみて項目が表示できるかどうかのチェック
	 *
	 * @param string $script : スクリプト名
	 * @param string $itemPerm : 記事データ
	 * @return boolean :
	 */
	function checkItemReadable($script, $data=NULL)
	{
		return $this->_subCheckItem($script, array(0400, 040, 4), $data);
	}
	/**
	 * ACCESS_PERMISSIONとSESSIONユーザ情報、記事パーミッションをみて項目が編集できるかどうかのチェック
	 */
	function checkItemWritable($script, $data=NULL)
	{
		return $this->_subCheckItem($script, array(0200, 020, 2), $data);
	}
	/**
	 * ACCESS_PERMISSIONとSESSIONユーザ情報、記事パーミッションをみて項目が承認できるかどうかのチェック
	 */
	function checkItemAcknowledgable($script, $data=NULL)
	{
		return $this->_subCheckItem($script, array(0100, 010, 1), $data);
	}
	/**
	 * checkItemRead, checkItemWrite, checkItemAccknowledge の内部関数
	 *
	 * @return boolean :
	 */
	function _subCheckItem($script, $perms, $data=NULL)
	{
		if(! isset($_SESSION['user'])) return FALSE;

		$accPerm = NULL;
		foreach(wowConst('ACCESS_PERMISSION') as $acc){
			if(strpos($script, $acc['script']) === 0){
				$accPerm = $acc;
				break;
			}
		}
		if(is_null($accPerm)) return FALSE;

		if(is_null($data) || !isset($data['user_select'])){
			$data = array();
			$data['user_select'] = $_SESSION['user']['id'];
			$data['permission'] = $accPerm['permission'];
		}

		if($perms[0] == 0100 && $accPerm['acknowledge'] === FALSE){
			// 承認不要記事の承認
			return TRUE;
		}else if($data['user_select'] == $_SESSION['user']['id'] && $data['permission'] & $perms[0]){
			return TRUE;
		}else if((1 << ($accPerm['group']-1) & $_SESSION['user']['group_check']) && $data['permission'] & $perms[1]){
			return TRUE;
		}else if((1 << ($accPerm['acknowledge']-1) & $_SESSION['user']['group_check']) && $data['permission'] & $perms[2]){
			return TRUE;
		}else{
			return FALSE;
		}
	}
}
?>
