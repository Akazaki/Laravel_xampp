<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="content-language" content="ja">
<meta http-equiv="content-style-type" content="text/css">
<meta http-equiv="content-script-type" content="text/javascript">
<meta name="robots" content="noindex,nofollow">
<title>WoW</title>
<!--css-->
<link rel="stylesheet" href="common/css/import.css" type="text/css" media="all">
<link rel="stylesheet" href="common/css/style.css" type="text/css" media="all">
<!--js-->
<script type="text/javascript" src="common/js/jquery.js"></script>
<script type="text/javascript" src="common/js/page-scroller.js"></script>
<script type="text/javascript" src="common/js/iepngfix.js"></script>
<script type="text/javascript" src="common/js/iepngrollover.js"></script>
<script type="text/javascript" src="common/js/form_txt.js"></script>
<script type="text/javascript" src="common/js/jquery.montage.min.js"></script>
<!-- 背景画像「bg_login.jpg 1440x1440px」を動かす場合 -->
<!--script>
$(document).ready(function () {
	var scrollSpeed = 0.01;
	var imgWidth = 1100;
	var posY = 0;
	
	// エラー以外
	if(!$('.err').length){
		$('.scroll').animate({backgroundPositionY: "-520px"}, 25000, 'linear');
	}
});
</script-->
</head>
<body id="login">
<div class="scroll"></div>
<table>
	<tr>
	<td id="cellHeader"><div id="header">
		<div id="topBox">
			<h1><img src="img/header_logo.gif" alt="ようこそ Contents Management Flamework WOW" width="251" height="12"></h1>
				<div id="gpol">
					<p><!--a href="https://www.gpol.co.jp/">ジーピーオンラインのWebサイトへ</a--></p>
				</div>
			</div>
		</div>
		<!--//header--></td>
		</tr>
	<tr>
	<td id="wrapper">
		<div id="loginInner" class="loginWidth">
		
		<div class="alice clr">
		<p class="wowLogo"><img src="img/logo_wow.png" alt="WOW" width="84" height="84"></p>
		<h3><img src="img/logo.png" alt="ロゴ" width="171" height="79" class="png"></h3>
			
			<form action="index.php" method="post">
				<input type="hidden" name="action" value="confirmLogin" />
				<div class="form clr">
					<div class="idPass">
						<p><img src="img/id_img.png" alt="" width="21" height="20" class="icon png">
						<input name="wowname" type="text" value="ユーザーID" onFocus="cText(this)" onBlur="sText(this)"></p>
						<p><img src="img/pass_img.png" alt="" width="21" height="20" class="icon png">
						<input type="text" value="パスワード" id="password-dummy" onfocus="dummyFocus('password')" />
						<input type="password" value="" id="password" name="password" onblur="passwordBlur('password')" style="display: none;" /></p>
					</div>
				<input type="image" src="img/login_btn.png" name="doneConfirmLogin" class="tremble" style="width:187px; height:61px;" onmouseover="this.src='img/login_btn_o.png'" onmouseout="this.src='img/login_btn.png'" />
			</div>
			<!-- {{if $errors}}
			<p class="err"><span>
			{{foreach from=$errors item=error}}
				{{$error|escape}}<br >
			{{/foreach}}
			</span></p>
			{{/if}} -->
			<div class="check">
<!--
                <input name="" type="checkbox" value="">
                <span>2週間ログインし続ける</span>
-->
				</div>
				<!--p><a href="#">パスワードを忘れた場合はこちら</a></p-->
				</form>
			</div>
		</div></td>
	</tr>
	<tr>
	<td id="cellFooter"><div id="footer">
		<div id="footLeft"><a href="http://www.gpol.co.jp/" target="_blank"><img src="common/img/footer_logo.png" alt="GP-ONLINE" width="28" height="19" border="0" class="png rollover"></a><img src="common/img/copyright.png" alt="Copyright (c) GP-ONLINE All Rights Reserved." width="206" height="11" class="png"></div>
		<div id="footRight"><!--a href="#"><img src="common/img/footer_navi01.png" alt="プライバシーポリシー" width="99" height="10" border="0" class="png rollover"></a><a href="#"><img src="common/img/footer_navi02.png" alt="ヘルプ" width="30" height="10" border="0" class="png rollover"></a--></div>
		</div></td>
	</tr>
	<script type="text/javascript">
		$(function() {
			// initialize the plugin
			var $container 	= $('#am-container'),
				$imgs		= $container.find('img').hide(),
				totalImgs	= $imgs.length,
				cnt			= 0;
			
			$imgs.each(function(i) {
				var $img	= $(this);
				$('<img/>').load(function() {
					++cnt;
					if( cnt === totalImgs ) {
						$imgs.show();
						$container.montage({
							minsize	: true,
							margin 	: 8
						});
					}
				}).attr('src',$img.attr('src'));
			});
		});
	</script>
</table>
</body>
</html>
