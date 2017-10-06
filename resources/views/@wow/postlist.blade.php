@extends('layouts.wowmaster')

@section('content')

<td id="main" class="mainColTop"><!-- main start -->
	<form action="{{action('WowUserController@user')}}" method="get">
		 {{ csrf_field() }}
		<div id="contribute">
		<div id="midashi">
			<div id="midashiR">
			<div id="midashiL">
				<h2>記事投稿</h2>
			</div>
			<p><strong>ユーザー</strong></p>
			</div>
		</div>
		<div class="btnBox clr">
			<p><a href="?action=edit&amp;id=0&p=0" class="Button color1">新規追加</a></p>
			<div id="search">
			<div id="searchBox">
				<input name="search" type="text" value="" class="text" />
			</div>
			<input type="image" name="search_button" src="/public/wow/common/img/search_btn.gif" alt="検索" width="32" height="21" class="rollover" />
			</div>
		</div>
		<table class="sortBox sortTop">
			<tr>
			<td class="sortLeft">
				<a id="dropBtn"><img src="/public/wow/common/img/edit_t_btn.gif" alt="一括編集" width="121" height="21" class="rollover" /></a>
				<div id="drop" class="dropEditBox">
				<div class="dropBottom">
					<div class="dropTop">
					<ul>
						 <li><a href="#" onclick="return postAction('delete');">削除</a></li>
						 <li class="line"><a href="#" onclick="return postAction('inactive');">非公開</a></li>
						 <li><a href="#" onclick="return postAction('acknowledge');">公開</a></li>
					</ul>
					</div>
				</div>
				</div></td>
			<td class="sortCenter"><span class="sortRight"><span><a href="?p=0"><img src="/public/wow/common/img/pager_top_btn.gif" alt="最初" width="10" height="9" class="rollover" /></a><a href="?p=0"><img src="/public/wow/common/img/pager_prev_btn.gif" alt="前" width="10" height="9" class="rollover" /></a></span><span id="page-span1" class="this">1 - 1</span><span>/</span><span class="all">1 件</span><span><a href="?p=0"><img src="/public/wow/common/img/pager_next_btn.gif" alt="次" width="10" height="9" class="rollover" /></a><a href="?p=0"><img src="/public/wow/common/img/pager_end_btn.gif" alt="最後" width="10" height="9" class="rollover" /></a></span></span></td>
			</tr>
		</table>
		<table id="list-table" class="base">
			<tr class="head">
			<th scope="col" class="center"><input type="checkbox" id="changeAllHead" onchange="changeAll(this);" title="すべて" /><label class="checklist" for="changeAllHead"></label></th>
				 <th scope="col"><a href="/wow/user.php?sort=id&type=DESC">id</a></th>
				 <th scope="col"><a href="/wow/user.php?sort=label_text&type=DESC">ユーザー名</a></th>
				 <th scope="col"><a href="/wow/user.php?sort=acknowledge&type=DESC">公開</a></th>
			</tr>
			<tr>
				<td class="center"><input type="checkbox" name="id[]" value="1" id="checkbox_1" /><label class="checklist" for="checkbox_1"></label></td>
				<td>00001</td>
				<td class="menu-td"><a href="?action=edit&amp;id=1&p=0">admin</a><div class="hoverEdit"><p class="left"><a href="?action=edit&amp;id=1&p=0">編集</a></p><p><a href="?action=delete&amp;id=1&p=0" onclick="return confirm('『admin』 を削除します。よろしいですか？')">削除</a></p><p><a href="?action=copy&amp;id=1&p=0">コピー</a></p><p><a href="?action=inactive&amp;id=1&p=0#">非公開</a></p></div></td>
				<td>公開</td>
			</tr>
			<tr class="head">
			<th scope="col" class="center"><input type="checkbox" id="changeAllTail" onchange="changeAll(this);" /></th>
				 <th scope="col"><a href="/wow/user.php?sort=id&type=DESC">id</a></th>
				 <th scope="col"><a href="/wow/user.php?sort=label_text&type=DESC">ユーザー名</a></th>
				 <th scope="col"><a href="/wow/user.php?sort=acknowledge&type=DESC">公開</a></th>
			</tr>
		</table>
		<table class="sortBox sortBottom">
			<tr>
			<td class="sortLeft">
			<a id="dropBtn2"><img src="/public/wow/common/img/edit_u_btn.gif" alt="一括編集" width="121" height="21" class="rollover" /></a>
				<div id="drop2" class="dropEditBox">
				<div class="dropBottom">
					<div class="dropTop">
					<ul>
						 <li><a href="#" onclick="return postAction('delete');">削除</a></li>
						 <li class="line"><a href="#" onclick="return postAction('inactive');">非公開</a></li>
						 <li><a href="#" onclick="return postAction('acknowledge');">公開</a></li>

					</ul>
					</div>
				</div>
				</div></td>
			<td class="sortCenter"><span class="sortRight"><span><a href="?p=0"><img src="/public/wow/common/img/pager_top_btn.gif" alt="最初" width="10" height="9" class="rollover" /></a><a href="?p=0"><img src="/public/wow/common/img/pager_prev_btn.gif" alt="前" width="10" height="9" class="rollover" /></a></span><span id="page-span1" class="this">1 - 1</span><span>/</span><span class="all">1 件</span><span><a href="?p=0"><img src="/public/wow/common/img/pager_next_btn.gif" alt="次" width="10" height="9" class="rollover" /></a><a href="?p=0"><img src="/public/wow/common/img/pager_end_btn.gif" alt="最後" width="10" height="9" class="rollover" /></a></span></span></td>
			</tr>
		</table>
		</div>
	</form>
</td>
@endsection