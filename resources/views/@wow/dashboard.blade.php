@extends('layouts.wowmaster')

@section('content')
	<td id="main" class="mainColTop">
		<div id="index">

		<div class="welcome clr">
			<p class="catch"><img src="/public/wow/common/img/top_catch.gif" alt="さあ、WOWであなたのWebサイトを管理しましょう。" width="432" height="19" /></p>
			<p>WOWの機能はとってもシンプルです。<br />
			以下のボタンをクリックしてあなたのWebサイトを管理しましょう。</p>
		</div>
		<div class="listBox clr">
			<p>
			<strong><img src="/public/wow/common/img/title01.gif" alt="記事管理" width="56" height="15" /></strong>
			<img src="/public/wow/common/img/icon02.jpg" alt="記事管理" width="127" height="98" />
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
			<strong><img src="/public/wow/common/img/title02.gif" alt="画像・ファイル管理" width="127" height="15" /></strong>
			<img src="/public/wow/common/img/icon03.jpg" alt="画像・ファイル管理" width="127" height="98" />
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
@endsection
