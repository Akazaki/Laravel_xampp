<?php

/**
 * WOWView
 *
 */
class WOWView
{
	var $ctrl = NULL;
	var $inputType = NULL;

	var $head = NULL;
	var $body = NULL;
	
	// 表示ＨＴＭＬのフォームエラー
	var $errors = array();

	function WOWView($_ctrl)
	{
		$this->ctrl = $_ctrl;
		$this->ctrl->sort = '';
		$this->ctrl->type = '';
		$this->inputType = $_ctrl->inputType;

		$this->init();
	}

	function init()
	{
		$this->head = array();
		$this->body = array();
	}

	function setHeadContents()
	{
		$word = array();
		$word['time'] = date('H:i:s');

		$this->head[] = <<<_EOS_
<!--css-->
  <link rel="stylesheet" href="common/css/import.css" type="text/css" media="all" />
<!--js-->
  <script type="text/javascript" src="common/js/jquery.js"></script>
  <script type="text/javascript" src="common/js/clipboard.min.js"></script>
  <script type="text/javascript" src="common/js/rollover.js"></script>
  <script type="text/javascript" src="common/js/iepngfix.js"></script>
  <script type="text/javascript" src="common/js/iepngrollover.js"></script>
  <script type="text/javascript" src="common/js/sweetalert.min.js"></script>
  <script>
  // クリップボードコピー用
  $(function () {
      var clipboard = new Clipboard('.clipbtn');
  });
  </script>
  <link rel="stylesheet" type="text/css" href="common/css/sweetalert.css">
_EOS_;
		$this->body[] = <<<_EOS_
  <div id="header">
    <div id="topBox">
      <h1><a href="dashboard.php"><img src="common/img/header_logo.gif" alt="Contents Management Flamework WOW" width="81" height="14" /></a></h1>
      <div id="gpol">
        <p><a href="/" target="_blank">Webサイトへ</a></p>
      </div>
    </div>
    <div id="bottomBox">
      <ul>
_EOS_;
		// if($this->ctrl->accessor->checkView('/wow/user.php')){
		// 	$this->body[] .= '<li><a href="user.php"><img src="common/img/header_icon01.gif" title="ユーザ管理" alt="ユーザ管理" width="30" height="25" border="0" class="rollover" /></a></li>' . "\n";
		// }
		if(FALSE && $this->ctrl->accessor->checkView('/wow/user.php')){
			$this->body[] .= '<li><a href="#"><img src="common/img/header_icon02.gif" title="？" alt="" width="28" height="25" border="0" class="rollover" /></a></li>' . "\n";
		}
		if(FALSE && $this->ctrl->accessor->checkView('/wow/user.php')){
			$this->body[] .= '<li><a href="#"><img src="common/img/header_icon03.gif" title="ログ？" alt="" width="29" height="25" border="0" class="rollover" /></a></li>' . "\n";
		}
		if(FALSE && $this->ctrl->accessor->checkView('/wow/user.php')){
			$this->body[] .= '<li><a href="column_info.php"><img src="common/img/header_icon04.gif" title="設定？" alt="" width="29" height="25" border="0" class="rollover" /></a></li>' . "\n";
		}

		$this->body[] = <<<_EOS_
        <li>&nbsp;</li>
      </ul>
      <div id="time_logout">
        <div id="time"><img src="common/img/time.gif" alt="現在の時刻" width="15" height="15" /><span data-offset="9">{$word['time']}</span></div>
        <div id="account"><img src="common/img/account.gif" alt="アカウント" width="1" height="15" /><span>ログイン名：{$_SESSION['user']['label_text']}</span></div>
        <div id="logout"><a href="./index.php?action=logout"><img src="common/img/logout.gif" alt="ログアウト" width="68" height="25" border="0" class="imgover" /></a></div>
      </div>
    </div>
  </div>
  <!--//header-->

_EOS_;
	}

	function setMenuContents()
	{
		$word = array();

		$this->head[] = "  <script type=\"text/javascript\" src=\"common/js/jquery.accordion.js\"></script>
		<script type=\"text/javascript\" src=\"common/js/common.js\"></script>
		<script type=\"text/javascript\" src=\"common/js/jquery.cookie.js\"></script>
		<script type=\"text/javascript\" src=\"common/js/jquery.tile.min.js\"></script>";

		$tMenu = <<<_EOS_
        <td id="leftSide" class="mainColTop"><!-- leftSide start -->
          <ul>
_EOS_;

		//ダッシュボード
		$menuClass = (strpos($_SERVER['PHP_SELF'], '/wow/dashboard.php') !== FALSE)?" class=\"blue\"":"";
		$current = (strstr($_SERVER['PHP_SELF'], '/wow/dashboard'))?' current':'';
		$tMenu .= '<li'.$menuClass.'><a href="dashboard.php" class="parentNon icon00'.$current.'">ダッシュボード</a></li>' . "\n";
		
		//アコーディオン開閉フラグ
		$_cookie_leftside = isset($_COOKIE['leftside']) ? $_COOKIE['leftside'] : array(2,1);
		
		//投稿管理--------------------------------------------------------
		$tMenu .= '<li><a href="news.php?default=list" class="parentNon icon09 '.$current.'">投稿管理</a></li>';

		//商品管理--------------------------------------------------------
		$menuClass = $this->getAccordionFlg('/wow/product.php', $_cookie_leftside[2]);
		$tMenu .= '<li'.$menuClass.'><span class="parent icon07">商品管理</span>' . "\n" . '<ul'.$menuClass.'>' . "\n";

		if($this->ctrl->accessor->checkView('/wow/product.php')){
			$current = (strstr($_SERVER['PHP_SELF'], '/wow/product.php') && isset($_GET['default']) && $_GET['default'] === 'list')?' class="current"':'';
			$tMenu .= '<li><a href="product.php?default=list"'.$current.'>容器</a></li>' . "\n";
		}

		if($this->ctrl->accessor->checkView('/wow/caps.php')){
			$current = (strstr($_SERVER['PHP_SELF'], '/wow/caps.php'))?' class="current"':'';
			$tMenu .= '<li><a href="caps.php?default=list"'.$current.'>キャップ</a></li>' . "\n";
		}

		if($this->ctrl->accessor->checkView('/wow/accessory.php')){
			$current = (strstr($_SERVER['PHP_SELF'], '/wow/accessory.php') && isset($_GET['default']) && $_GET['default'] === 'list')?' class="current"':'';
			$tMenu .= '<li><a href="accessory.php?default=list"'.$current.'>付属品</a></li>' . "\n";
		}

		if($this->ctrl->accessor->checkView('/wow/other.php')){
			$current = (strstr($_SERVER['PHP_SELF'], '/wow/other.php') && isset($_GET['default']) && $_GET['default'] === 'list')?' class="current"':'';
			$tMenu .= '<li><a href="other.php?default=list"'.$current.'>容器以外の商品</a></li>' . "\n";
		}

		$tMenu .= "</ul>\n</li>\n";

		$tMenu .= '<li><a href="member.php?default=list" class="parentNon icon08'.$current.'">会員管理</a>' . "\n" . "</li>\n";
		
		//画像管理--------------------------------------------------------
		//$menuClass = $this->getAccordionFlg('/wow/product.php', $_cookie_leftside[1]);
		// $menuClass2 = $this->getAccordionFlg('/wow/file.php', $_cookie_leftside[2]);
		// $tMenu .= '            <li'.$menuClass2.'><span class="parent icon12">画像管理</span>' . "\n" . '<ul'.$menuClass2.'>' . "\n";
		
		// if($this->ctrl->accessor->checkView('/wow/file.php')){
		// 	$current = (strstr($_SERVER['PHP_SELF'], '/wow/file'))?' class="current"':'';
		// 	$tMenu .= '              <li><a href="file.php?default=list"'.$current.'>画像情報</a></li>' . "\n";
		// }
		// $tMenu .= "            </ul>\n          </li>\n";
		
		
		$tMenu .= '            <li><img src="common/img/side_naviend.gif" alt="メニューエンド" width="194" height="43" border="0" /></li>' . "\n";
		
		$tMenu .= <<<_EOS_
          </ul>
		  <div style="height:200px; width:10px;">　</div>
        </td>
_EOS_;
		$this->body[] = $tMenu;
	}

	function getAccordionFlg($_script, $_cookie)
	{
		$menuClass = '';
		if(isset($_cookie)){
			if($_cookie){
				$menuClass = " class=\"open blue\"";
			}
		}else{
			$menuClass = " class=\"open blue\"";
		}
		
		return $menuClass;
	}

	function setFooterContents()
	{
		$word = array();

		$this->body[] = <<<_EOS_
  <div id="footer">
    <div id="footLeft"></div>
    <div id="footRight"><!--a href="#"><img src="common/img/footer_navi01.gif" alt="プライバシーポリシー" width="101" height="12" border="0" class="rollover" /></a><a href="#"><img src="common/img/footer_navi02.gif" alt="ヘルプ" width="32" height="12" border="0" class="rollover" /></a--></div>
  </div>

_EOS_;
	}

	function appendHead($string)
	{
		$this->head[] = $string;
	}
	function addTopBody($string)
	{
		array_unshift($this->body, $string);
	}
	function appendBody($string)
	{
		$this->body[] = $string;
	}
	function addSideBody($prestring, $poststring)
	{
		$this->addTopBody($prestring);
		$this->appendBody($poststring);
	}
	function getHead()
	{
		return implode("\n", array_values(array_unique($this->head)));
	}
	function getBody()
	{
		return implode("\n", $this->body);
	}
	function setErrors($_errors)
	{

		$this->errors = $_errors;
	}
}
?>
