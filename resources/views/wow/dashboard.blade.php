@extends('layouts.wowmaster')

@section('content')
	<div id="header">
	<div id="topBox">
		<h1><a href="dashboard.php"><img src="common/img/header_logo.gif" alt="Contents Management Flamework WOW" width="81" height="14" /></a></h1>
		<div id="gpol">
		<p><a href="../" target="_blank">株式会社 斎藤容器のWebサイトへ</a></p>
		</div>
	</div>
	<div id="bottomBox">
		<ul>
		<li><a href="user.php"><img src="common/img/header_icon01.gif" title="ユーザ管理" alt="ユーザ管理" width="30" height="25" border="0" class="rollover" /></a></li>

		<li>&nbsp;</li>
		</ul>
		<div id="time_logout">
		<div id="time"><img src="common/img/time.gif" alt="現在の時刻" width="15" height="15" /><span>23:46:13</span></div>
		<div id="account"><img src="common/img/account.gif" alt="アカウント" width="1" height="15" /><span>ログイン名：admin</span></div>
		<div id="logout"><a href="./index.php?action=logout"><img src="common/img/logout.gif" alt="ログアウト" width="68" height="25" border="0" class="imgover" /></a></div>
		</div>
	</div>
	</div>
	<!--//header-->

	<div id="wrapper">
	<table border="0" cellpadding="0" cellspacing="0" id="liquid">
		<tr>

		<td id="leftSide" class="mainColTop"><!-- leftSide start -->
			<ul>
 			 <li><img src="common/img/side_navi01_o.gif" alt="ダッシュボード" width="194" height="43" border="0" /></li>
 			 <li><img src="common/img/side_navi02.gif" alt="記事投稿" width="194" height="43" />
				<ul class="open">
 			 <li><a href="news.php?default=list">新着情報</a></li>
 			 <li><a href="product.php?default=list">商品情報</a></li>
 			 <li><a href="member.php?default=list">会員情報</a></li>
						</ul>
					</li>
 			 <li><a href="file.php"><img src="common/img/side_navi03.gif" alt="画像管理" width="194" height="43" border="0" class="imgover" /></a></li>
 			 <li><img src="common/img/side_naviend.gif" alt="メニューエンド" width="194" height="43" border="0" /></li>
			</ul>
			<div style="height:200px; width:10px;">　</div>
		</td>
		<td id="main" class="mainColTop">
			<div id="index">

			<div class="welcome clr">
				<p class="catch"><img src="common/img/top_catch.gif" alt="さあ、WOWであなたのWebサイトを管理しましょう。" width="432" height="19" /></p>
				<p>WOWの機能はとってもシンプルです。<br />
				以下のボタンをクリックしてあなたのWebサイトを管理しましょう。</p>
			</div>
			<div class="listBox clr">
				<p>
				<strong><img src="common/img/title01.gif" alt="記事管理" width="56" height="15" /></strong>
				<img src="common/img/icon02.jpg" alt="記事管理" width="127" height="98" />
				</p>
				<div class="btnListBox">
				<dl class="border clr">
					<dt>新着情報</dt>
					<dd>
					<ul>
						<li><a href="./news.php?action=edit&amp;id=0">新規投稿</a></li>
						<li><a href="./news.php?default=list">編集・削除</a></li>
					</ul>
					</dd>
				</dl>
				<dl class="border clr">
					<dt>商品情報</dt>
					<dd>
					<ul>
						<li><a href="./product.php?action=edit&amp;id=0">新規投稿</a></li>
						<li><a href="./product.php">編集・削除</a></li>
					</ul>
					</dd>
				</dl>
				<dl class="border clr">
					<dt>会員情報</dt>
					<dd>
					<ul>
						<li><a href="./member.php?action=edit&amp;id=0">新規投稿</a></li>
						<li><a href="./member.php">編集・削除</a></li>
					</ul>
					</dd>
				</dl>
				</div>
			</div>
			<div class="listBox clr">
				<p>
				<strong><img src="common/img/title02.gif" alt="画像・ファイル管理" width="127" height="15" /></strong>
				<img src="common/img/icon03.jpg" alt="画像・ファイル管理" width="127" height="98" />
				</p>
				<div class="btnListBox">
				<dl class="border clr">
					<dt>画像</dt>
					<dd>
					<ul>
						<li><a href="./file.php?action=edit&amp;id=0">新規投稿</a></li>
						<li><a href="./file.php">編集・削除</a></li>
					</ul>
					</dd>
				</dl>
				<!--
				<dl class="border clr">
					<dt>ファイル</dt>
					<dd>
					<ul>
						<li><a href="./afile.php?action=edit&amp;id=0">新規投稿</a></li>
						<li><a href="./afile.php">編集・削除</a></li>
					</ul>
					</dd>
				</dl>
				-->
				</div>
			</div>
			</div>
		</td>

		<td id="rightSide" class="mainColTop">

		</td>
		</tr>
	</table>
	<!--//wrapper-->
	</div>

	<div id="footer">
	</div>
@endsection
