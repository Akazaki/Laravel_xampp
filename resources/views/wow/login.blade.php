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
<link rel="stylesheet" href="/public/wow/common/css/import.css" type="text/css" media="all">
<link rel="stylesheet" href="/public/wow/common/css/style.css" type="text/css" media="all">
<!--js-->
<script type="text/javascript" src="/public/wow/common/js/jquery.js"></script>
<script type="text/javascript" src="/public/wow/common/js/page-scroller.js"></script>
<script type="text/javascript" src="/public/wow/common/js/iepngfix.js"></script>
<script type="text/javascript" src="/public/wow/common/js/iepngrollover.js"></script>
<script type="text/javascript" src="/public/wow/common/js/form_txt.js"></script>
<script type="text/javascript" src="/public/wow/common/js/jquery.montage.min.js"></script>
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
			<h1><img src="/public/wow/img/header_logo.gif" alt="ようこそ Contents Management Flamework WOW" width="251" height="12"></h1>
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
		<p class="wowLogo"><img src="/public/wow/img/logo_wow.png" alt="WOW" width="84" height="84"></p>
		<h3><img src="/public/wow/img/logo.png" alt="ロゴ" width="171" height="79" class="png"></h3>
			
			<form action="{{action('WowController@signin')}}" method="post">

				{{ csrf_field() }}

				<div class="form clr">
					<div class="idPass">
						<p><img src="/public/wow/img/id_img.png" alt="" width="21" height="20" class="icon png">
						<input name="email_text" type="text" value="ユーザーID" onFocus="cText(this)" onBlur="sText(this)"></p>
						<p><img src="/public/wow/img/pass_img.png" alt="" width="21" height="20" class="icon png">
						<input type="text" value="パスワード" id="password-dummy" onfocus="dummyFocus('password')" />
						<input type="password" value="" id="password" name="password" onblur="passwordBlur('password')" style="display: none;" /></p>
					</div>
				<input type="image" src="/public/wow/img/login_btn.png" name="doneConfirmLogin" class="tremble" style="width:187px; height:61px;" onmouseover="this.src='/public/wow/img/login_btn_o.png'" onmouseout="this.src='/public/wow/img/login_btn.png'" />
			</div>

			@if ($errors->any())
				<p class="err"><span>
					@foreach ($errors->all() as $error)
						{{ $error }}<br >
					@endforeach
				</span></p>
			@endif

			<div class="check">
				</div>
				<!--p><a href="#">パスワードを忘れた場合はこちら</a></p-->
				</form>
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
