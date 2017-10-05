<?php
require_once dirname(__FILE__) . '/WOWView.php';

/**
 * WOWEditView
 *
 */
class WOWEditView extends WOWView
{
	function WOWEditView($_ctrl)
	{
		WOWView::WOWView($_ctrl);
	}

	function setDashboardContents()
	{
		$word = array();
		$this->body[] = <<<_EOS_
		<td id="main" class="mainColTop">
		  <div id="index">

			<div class="welcome clr">
			  <p class="catch"><img src="common/img/top_catch.gif" alt="さあ、WOWであなたのWebサイトを管理しましょう。" width="432" height="19" /></p>
			  <p>WOWの機能はとってもシンプルです。<br />
			  以下のボタンをクリックしてあなたのWebサイトを管理しましょう。</p>
			</div>

			<div class="listBox two clr">
				<p>
					<strong style="color:#3987DF">投稿管理</strong>
					<img src="common/img/side_navi2_09.png" alt="投稿管理" width="80" height="80" />
				</p>
				
				<div class="btnListBox">
					<dl class="border clr">
						<dt>投稿情報</dt>
						<dd style="/*padding: 38px 0px 30px 0;*/">
							<ul>
								<li><a href="./news.php">一覧</a></li>
							</ul>
						</dd>
					</dl>
				</div>
			</div>

			<div class="listBox two clr">
				<p>
					<strong style="color:#3987DF">商品管理</strong>
					<img src="common/img/side_navi2_07.png" alt="商品管理" width="80" height="80" />
				</p>
				
				<div class="btnListBox">
					<dl class="border clr">
						<dt>容器</dt>
						<dd style="/*padding: 38px 0px 30px 0;*/">
							<ul>
								<li><a href="./product.php">一覧</a></li>
							</ul>
						</dd>
					</dl>
				</div>

				<div class="btnListBox">
					<dl class="border clr">
						<dt>キャップ</dt>
						<dd style="/*padding: 38px 0px 30px 0;*/">
							<ul>
								<li><a href="./caps.php">一覧</a></li>
							</ul>
						</dd>
					</dl>
				</div>

				<div class="btnListBox">
					<dl class="border clr">
						<dt>付属品</dt>
						<dd style="/*padding: 38px 0px 30px 0;*/">
							<ul>
								<li><a href="./accessory.php">一覧</a></li>
							</ul>
						</dd>
					</dl>
				</div>

				<div class="btnListBox">
					<dl class="border clr">
						<dt>容器以外の商品</dt>
						<dd style="/*padding: 38px 0px 30px 0;*/">
							<ul>
								<li><a href="./other.php">一覧</a></li>
							</ul>
						</dd>
					</dl>
				</div>
			</div>

			<div class="listBox two clr">
				<p>
					<strong style="color:#3987DF">会員管理</strong>
					<img src="common/img/side_navi2_08.png" alt="会員管理" width="80" height="80" />
				</p>
				
				<div class="btnListBox">
					<dl class="border clr">
						<dt>会員情報</dt>
						<dd style="/*padding: 38px 0px 30px 0;*/">
							<ul>
								<li><a href="./member.php">一覧</a></li>
							</ul>
						</dd>
					</dl>
				</div>
			</div>
			
			<!--div class="listBox two clr">
				<p>
					<strong style="color:#3987DF">画像管理</strong>
					<img src="common/img/side_navi2_12.png" alt="画像管理" width="80" height="80" />
				</p>
				
				<div class="btnListBox">
					<dl class="border clr">
						<dt>画像情報</dt>
						<dd style="/*padding: 38px 0px 30px 0;*/">
							<ul>
								<li><a href="./file.php">一覧</a></li>
							</ul>
						</dd>
					</dl>
				</div>
			</div-->

		  </div>
		</td>

_EOS_;

		// 右カラム
		// 後にループで処理するように修正すること！

		$word['rightSide'] = '';
		$word['suspendAll'] = 0;
		$word['suspendNews'] = 0;

		// チーム情報
		$rows = $this->ctrl->model->getData('news', array('id'), 'WHERE delete_datetime IS NULL AND acknowledge = 2');
		$word['suspendNews'] = count($rows);
		$word['suspendAll'] += $word['suspendNews'];

		if($word['suspendAll'] > 0){
			$word['rightSide'] .= <<<_EOS_
		  <dl>
			<dt><span class="title">未承認記事</span></dt>
			<dd class="midoku bLine">現在承認待ちの記事が<span>{$word['suspendAll']}</span>件あります。</dd>
			<dd class="link bLine">
			<ul>
_EOS_;

			$tOdd = TRUE;
			if($word['suspendNews'] > 0){
//				$word['rightSide'] .= "              <li class=\"clr" . (($tOdd) ? '' : ' line') . "\"><span class=\"category\"><a href=\"suspendNews.php\">新着情報</a></span><span class=\"number\">({$word['suspendNews']})</span></li>\n";
//				$tOdd = ! $tOdd;
			}
//				<li class="clr"><span class="category"><a href="#">test1</a></span><span class="number">(100)</span></li>
//				<li class="clr line"><span class="category"><a href="#">test2</a></span><span class="number">(1)</span></li>
//				<li class="clr"><span class="category"><a href="#">test3</a></span><span class="number">(1)</span></li>

			$word['rightSide'] .= <<<_EOS_
			</ul>
			</dd>
		  </dl>
_EOS_;
		}

		$this->body[] = <<<_EOS_
		<td id="rightSide" class="mainColTop">
{$word['rightSide']}
		</td>
_EOS_;
	}
	function setPreContents()
	{
		$word = array();

		$this->body[] = <<<_EOS_
  <div id="wrapper">
	<table border="0" cellpadding="0" cellspacing="0" id="liquid">
	  <tr>

_EOS_;
	}
	function setPostContents()
	{
		$word = array();

		$this->body[] = <<<_EOS_
	  </tr>
	</table>
	<!--//wrapper-->
  </div>

_EOS_;
	}

	function setListContents($table, $columns, $rows)
	{
		$this->setListContentsHead($table);
		$this->setListContentsPreBody($table);
		$this->setListContentsSort();
		$this->setListContentsPostBody($table, $columns, $rows);
	}
	function setFileListContents($table, $columns, $rows)
	{
		$this->setListContentsHead($table);
		$this->setListContentsPreBody($table);
		$this->setListContentsFile();
		$this->setListContentsPostBody($table, $columns, $rows);
	}
	function setListContentsHead($table)
	{
		$info = $this->ctrl->model->getInformation($table);

		$word = array();
		$word['table'] = $info['table']['labeljp'];

		$this->head[] = "  <title>{$word['table']}｜ＷＯＷ</title>";
		$this->head[] = "  <script type=\"text/javascript\" src=\"common/js/jkoutlinemenu.js\"></script>";
		$this->head[] = "  <script type=\"text/javascript\" src=\"common/js/wow.list.js\"></script>";
		$this->head[] = "  <link type=\"text/css\" media=\"screen\" rel=\"stylesheet\" href=\"common/css/colorbox02.css\" />";
		$this->head[] = "  <script type=\"text/javascript\" src=\"common/js/jquery.colorbox-min.js\"></script>";
		$this->head[] = <<<_EOS_
  <script type="text/javascript">
	jkoutlinemenu.definemenu('dropBtn', 'drop', 'mouseover');
	jkoutlinemenu.definemenu('dropBtn2', 'drop2', 'mouseover');
	$(function(){
	  $('td.menu-td div.hoverEdit').css('visibility', 'hidden');
	  $('td.menu-td').hover(
		function(){jQuery(this).children('div.hoverEdit').css('visibility', 'visible')},
		function(){jQuery(this).children('div.hoverEdit').css('visibility', 'hidden')}
	  );
	  jkoutlinemenu.render($);
		$('a.cboxaction').colorbox({
			photo:true,
			closeButton:false,
			opacity:0.5,
			maxWidth:"50%",
			maxHeight:'50%'
		});
	});
  </script>
_EOS_;
	}
	function setListContentsPreBody($table)
	{
		$info = $this->ctrl->model->getInformation($table);

		$word = array();
		$word['getstr_p'] = '';
		$word['self'] = basename($_SERVER['PHP_SELF']);
		$word['table'] = $info['table']['labeljp'];

		foreach($_GET as $k => $v){
			if($k != 'p'){
				$word['getstr_p'] .= '&' . urlencode($k) . '=' . urlencode($v);
			}
		}

		if($word['getstr_p'] == ''){
			$word['getstr_p'] = '?p=';
		}else{
			$word['getstr_p'] = '?' . substr($word['getstr_p'], 1) . '&p=';
		}

		//一覧ページのキャッシュリンク
		$list_cache = $word['getstr_p'].$this->ctrl->accessor->ctrl->p;
		$list_cache = str_replace("?","",$word['getstr_p'].$this->ctrl->accessor->ctrl->p);
		$list_cache = str_replace("action=list&","",$list_cache);

		$this->body[] = <<<_EOS_
		<td id="main" class="mainColTop"><!-- main start -->
		  <form action="{$word['self']}" method="post" enctype="multipart/form-data">
		  <input type="hidden" name="hiddenaction" value="doneNone" />
		  <div id="contribute">
			<div id="midashi">
			  <div id="midashiR">
				<div id="midashiL">
				  <h2>記事投稿</h2>
				</div>
				<p><strong>{$word['table']}</strong></p>
			  </div>
			</div>
			<div class="btnBox clr">
			  <p><a href="?action=edit&amp;id=0&{$list_cache}" class="Button color1">新規追加</a></p>
_EOS_;
	}
	function setListContentsPostBody($table, $columns, $rows)
	{

		//ソートのタイプが「DESC」の場合
		if(mb_ereg('DESC', $this->ctrl->_dataSort, $matches)){
			$type = "ASC";
		}else{
			$type = "DESC";
		}

		$info = $this->ctrl->model->getInformation($table);

		$word = array();
		$word['table'] = $info['table']['labeljp'];
		$word['tableHead'] = '';
		foreach($columns as $c){
			$word['tableHead'] .= ' 			   <th scope="col"><a href="'.$_SERVER['SCRIPT_NAME'].'?sort='.$c.'&type='.$type.'">' . ((isset($info[$c]['labeljp'])) ? $info[$c]['labeljp'] : $c) . "</a></th>\n";
		}
		$word['rowsCount'] = ifset($this->ctrl->_rowsCount, count($rows));
		$isOdd = FALSE;
		$word['groupMenu'] = '';

		// ページネーション用変数
		$word['prev'] = max(0, $this->ctrl->p - $this->ctrl->_listMax);
		$word['next'] = ($this->ctrl->p + $this->ctrl->_listMax > $word['rowsCount']) ? $this->ctrl->p : $this->ctrl->p + $this->ctrl->_listMax;
		$word['tail'] = max(0, $word['rowsCount'] - $this->ctrl->_listMax);
		$word['pagination'] = ($this->ctrl->p + 1) . ' - ' . min($this->ctrl->p + $this->ctrl->_listMax, $word['rowsCount']);

		$word['getstr_p'] = '';
		foreach($_GET as $k => $v){
			if($k != 'p'){
				$word['getstr_p'] .= '&' . urlencode($k) . '=' . urlencode($v);
			}
		}
		if($word['getstr_p'] == ''){
			$word['getstr_p'] = '?p=';
		}else{
			$word['getstr_p'] = '?' . substr($word['getstr_p'], 1) . '&p=';
		}
		if(TRUE){
			$word['groupMenu'] .= ' 						 <li' . (($isOdd) ? ' class="line"' : '') . '><a href="#" onclick="return postAction(\'delete\');">削除</a></li>' . "\n";
			$isOdd ^= TRUE;
		}

		// 認証が必要かフラグ
		$needAcknowledge = $this->ctrl->accessor->checkNeedAcknowledge($this->ctrl->SCRIPT_FROM_DOCUMENT_ROOT);

		if($needAcknowledge){
			$word['groupMenu'] .= ' 						 <li' . (($isOdd) ? ' class="line"' : '') . '><a href="#" onclick="return postAction(\'inactive\');">下書き</a></li>' . "\n";
			$isOdd ^= TRUE;
			$word['groupMenu'] .= ' 						 <li' . (($isOdd) ? ' class="line"' : '') . '><a href="#" onclick="return postAction(\'suspend\');">承認要請</a></li>' . "\n";
			$isOdd ^= TRUE;
			$word['groupMenu'] .= ' 						 <li' . (($isOdd) ? ' class="line"' : '') . '><a href="#" onclick="return postAction(\'acknowledge\');">承認</a></li>' . "\n";
			$isOdd ^= TRUE;
		}else{
			$word['groupMenu'] .= ' 						 <li' . (($isOdd) ? ' class="line"' : '') . '><a href="#" onclick="return postAction(\'inactive\');">非公開</a></li>' . "\n";
			$isOdd ^= TRUE;
			$word['groupMenu'] .= ' 						 <li' . (($isOdd) ? ' class="line"' : '') . '><a href="#" onclick="return postAction(\'acknowledge\');">公開</a></li>' . "\n";
			$isOdd ^= TRUE;
		}

		//一覧ページのキャッシュリンク
		$list_cache = $word['getstr_p'].$this->ctrl->accessor->ctrl->p;
		$list_cache = str_replace("?","",$word['getstr_p'].$this->ctrl->accessor->ctrl->p);
		$list_cache = str_replace("action=list","",$list_cache);

		$this->body[] = <<<_EOS_
			</div>
			<table class="sortBox sortTop">
			  <tr>
				<td class="sortLeft">
				  <a id="dropBtn"><img src="common/img/edit_t_btn.gif" alt="一括編集" width="121" height="21" class="rollover" /></a>
				  <div id="drop" class="dropEditBox">
					<div class="dropBottom">
					  <div class="dropTop">
						<ul>
{$word['groupMenu']}
						</ul>
					  </div>
					</div>
				  </div></td>
				<td class="sortCenter"><span class="sortRight"><span><a href="{$word['getstr_p']}0"><img src="common/img/pager_top_btn.gif" alt="最初" width="10" height="9" class="rollover" /></a><a href="{$word['getstr_p']}{$word['prev']}"><img src="common/img/pager_prev_btn.gif" alt="前" width="10" height="9" class="rollover" /></a></span><span id="page-span1" class="this">{$word['pagination']}</span><span>/</span><span class="all">{$word['rowsCount']} 件</span><span><a href="{$word['getstr_p']}{$word['next']}"><img src="common/img/pager_next_btn.gif" alt="次" width="10" height="9" class="rollover" /></a><a href="{$word['getstr_p']}{$word['tail']}"><img src="common/img/pager_end_btn.gif" alt="最後" width="10" height="9" class="rollover" /></a></span></span></td>
			  </tr>
			</table>
			<table id="list-table" class="base">
			  <tr class="head">
				<th scope="col" class="center"><input type="checkbox" id="changeAllHead" onchange="changeAll(this);" title="すべて" /><label class="checklist" for="changeAllHead"></label></th>
{$word['tableHead']}
			  </tr>
_EOS_;
		$isOdd = FALSE;
		foreach($rows as $row){
			if(! $this->ctrl->accessor->checkItemReadable($this->ctrl->SCRIPT_FROM_DOCUMENT_ROOT, $row)){
				continue;
			}
			if($isOdd ^= TRUE){
				$this->body[] = '<tr>';
			}else{
				$this->body[] = '<tr class="line">';
			}
			$this->body[] = '<td class="center"><input type="checkbox" name="id[]" value="' . $row['id'] . '" id="checkbox_'.$row['id'].'" /><label class="checklist" for="checkbox_'. $row['id'] .'"></label></td>';
			foreach($columns as $c){
				if($c == 'label_text'){
					$tBody = '<td class="menu-td"><a href="?action=edit&amp;id=' . $row['id'] . '&' . $list_cache . '">' . $this->inputType->getViewItem($c, $row) . '</a>';
					$tBody .= '<div class="hoverEdit">';

					if($this->ctrl->accessor->checkItemWritable($this->ctrl->SCRIPT_FROM_DOCUMENT_ROOT, $row)){
						$tBody .= '<p class="left"><a href="?action=edit&amp;id=' . $row['id'] . '&' . $list_cache . '">編集</a></p>';
						$tBody .= '<p><a href="?action=delete&amp;id=' . $row['id'] . '&' . $list_cache . '" onclick="return confirm(\'『' . mb_ereg_replace('&#039;', '', $this->inputType->getViewItem($c, $row)) . '』 を削除します。よろしいですか？\')">削除</a></p>';
					}else{
						$tBody .= '<p class="left"><a href="?action=edit&amp;id=' . $row['id'] . '&' . $list_cache . '">表示</a></p>';
					}

					if(strpos($_SERVER['PHP_SELF'], '/wow/file.php') === FALSE){
						$tBody .= '<p><a href="?action=copy&amp;id=' . $row['id'] . '&' . $list_cache . '">コピー</a></p>';
					}
					if($row['acknowledge'] != '1'){
						if($needAcknowledge){
							$tBody .= '<p><a href="?action=inactive&amp;id=' . $row['id'] . '&' . $list_cache . '#">下書き</a></p>';
						}else{
							$tBody .= '<p><a href="?action=inactive&amp;id=' . $row['id'] . '&' . $list_cache . '#">非公開</a></p>';
						}
					}
					if($row['acknowledge'] != '2' && $needAcknowledge){
							$tBody .= '<p><a href="?action=suspend&amp;id=' . $row['id'] . '&' . $list_cache . '#">承認要請</a></p>';
					}
					if($row['acknowledge'] != '3' && $this->ctrl->accessor->checkItemAcknowledgable($this->ctrl->SCRIPT_FROM_DOCUMENT_ROOT, $row)){
						if($needAcknowledge){
							$tBody .= '<p><a href="?action=acknowledge&amp;id=' . $row['id'] . '&' . $list_cache . '#">承認</a></p>';
						}else{
							$tBody .= '<p><a href="?action=acknowledge&amp;id=' . $row['id'] . '&' . $list_cache . '#">公開</a></p>';
						}
					}

					$tBody .= '</div></td>';
					$this->body[] = $tBody;
				}else{
					$this->body[] = '<td>' . $this->inputType->getViewItem($c, $row) . '</td>';
				}
			}
			$this->body[] = '</tr>';
		}
		$this->body[] = <<<_EOS_
			  <tr class="head">
				<th scope="col" class="center"><input type="checkbox" id="changeAllTail" onchange="changeAll(this);" /></th>
{$word['tableHead']}
			  </tr>
			</table>
			<table class="sortBox sortBottom">
			  <tr>
				<td class="sortLeft">
				<a id="dropBtn2"><img src="common/img/edit_u_btn.gif" alt="一括編集" width="121" height="21" class="rollover" /></a>
				  <div id="drop2" class="dropEditBox">
					<div class="dropBottom">
					  <div class="dropTop">
						<ul>
{$word['groupMenu']}
						</ul>
					  </div>
					</div>
				  </div></td>
				<td class="sortCenter"><span class="sortRight"><span><a href="{$word['getstr_p']}0"><img src="common/img/pager_top_btn.gif" alt="最初" width="10" height="9" class="rollover" /></a><a href="{$word['getstr_p']}{$word['prev']}"><img src="common/img/pager_prev_btn.gif" alt="前" width="10" height="9" class="rollover" /></a></span><span id="page-span1" class="this">{$word['pagination']}</span><span>/</span><span class="all">{$word['rowsCount']} 件</span><span><a href="{$word['getstr_p']}{$word['next']}"><img src="common/img/pager_next_btn.gif" alt="次" width="10" height="9" class="rollover" /></a><a href="{$word['getstr_p']}{$word['tail']}"><img src="common/img/pager_end_btn.gif" alt="最後" width="10" height="9" class="rollover" /></a></span></span></td>
			  </tr>
			</table>
		  </div></form></td>

_EOS_;
	}
	function setListContentsSort()
	{
//		//■
//		if(strpos($_SERVER['PHP_SELF'], '/wow/member.php') !== FALSE){
//			return ;
//		}

		$word = array();
		$word['searchword'] = (isset($_SESSION[$this->ctrl->_tableName]["search"])) ? $_SESSION[$this->ctrl->_tableName]["search"] : '';

		$this->body[] = <<<_EOS_
			  <div id="search">
				<div id="searchBox">
				  <input name="search" type="text" value="{$word['searchword']}" class="text" />
				</div>
				<input type="image" name="search_button" src="common/img/search_btn.gif" alt="検索" width="32" height="21" class="rollover" />
			  </div>
_EOS_;
	}
	function setListContentsFile()
	{
		$word = array();
		$word['self'] = basename($_SERVER['PHP_SELF']);
		$folderMaster = $this->ctrl->model->getMaster('folder');
		$showFolderGroup = wowConst('ACCESS_FOLDER');
		$word['select'] = '';
		foreach($folderMaster as $key => $val){
			if(isset($showFolderGroup[$key]) && ! ($showFolderGroup[$key] & $_SESSION['user']['group_check'])){
			}else if($key == $this->ctrl->folder){
				$word['select'] .= "                    <option value=\"{$key}\" selected=\"selected\">{$val}</option>\n";
			}else{
				$word['select'] .= "                    <option value=\"{$key}\">{$val}</option>\n";
			}
		}
		$this->body[] = <<<_EOS_
			  <div id="search">
				<div id="searchBox">
				  <select name="sort" id="sort" onchange="location.href = '{$word['self']}?folder=' + $('select#sort').val();">
{$word['select']}
				  </select>
				</div>
			  </div>
_EOS_;
	}
	function setEditContents($table, $columns, $rows)
	{

		$row = $rows[0];
		$info = $this->ctrl->model->getInformation($table);

		$word = array();

		$word['self'] = basename($_SERVER['PHP_SELF']);
		$word['table'] = $info['table']['labeljp'];
		$word['id'] = substr($word['self'], 0, strpos($word['self'], '.'));
		$word['confirmssid'] = session_id();

		$word['tableHead'] = '';
		foreach($columns as $c){
			$word['tableHead'] .= ' 			   <th scope="col">' . ((isset($info[$c]['labeljp'])) ? $info[$c]['labeljp'] : $c) . "</th>\n";
		}

		$word['fileupload'] = '';
		if($word['self'] == 'file.php' || $word['self'] == 'afile.php'){
			$word['fileupload'] = <<<_EOS_
	  new AjaxUpload('data_bin_b', {action: 'fileuploader.php', onComplete: function(file, response){
		if(response == 'error:type'){
		  $('#data_bin-div div.error').html('<img height="21" width="21" alt="" src="common/img/error.gif" /><span class="red">WOWのアップロード対応ファイルは、JPG,GIF,PNG,PDF,XLS,DOCです</span>');
		}else if(response == 'error:size'){
		  $('#data_bin-div div.error').html('<img height="21" width="21" alt="" src="common/img/error.gif" /><span class="red">ファイルサイズが大きすぎます</span>');
		}else if(response === 'error'){
		  $('#data_bin-div div.error').html('<img height="21" width="21" alt="" src="common/img/error.gif" /><span class="red">サーバにアップできる容量を超えている可能性があります</span>');
		}else{
		  var info = response.split(',');
		  if(info[1] == 'pdf' || info[1] == 'doc' || info[1] == 'xls'){
			$('#data_bin-div div.error').html('');
			$('#data_bin_i').attr('src', 'img/extension/file-' + info[1] + '.gif').attr('width', '120').attr('height', '120');
			$('#data_bin_d').attr('href', 'uploadfiles/' + info[0]);
			$('#data_bin').val(info[0]);
			$('#name_text').val(file);
			$('#type_view').val(info[1]);
		  }else{
			$('#data_bin-div div.error').html('');
			$('#data_bin_i').attr('src', 'uploadfiles/' + info[0]).attr('width', info[2]).attr('height', info[3]);
			$('#data_bin_d').attr('href', 'uploadfiles/' + info[0]);
			$('#data_bin').val(info[0]);
			$('#name_text').val(file);
			$('#type_view').val(info[1]);
		  }
		}
	  }});
_EOS_;
		}

		$word['saveBtn'] = '';

		if($this->ctrl->accessor->checkItemWritable($this->ctrl->SCRIPT_FROM_DOCUMENT_ROOT, $row)){
			$word['saveBtn'] = '<input type="image" name="btnDoneEdit" src="common/img/save_btn.gif" alt="保存" onmouseover="this.src=\'common/img/save_btn_o.gif\'" onmouseout="this.src=\'common/img/save_btn.gif\'" />';
		}

		$this->head[] = "  <title>編集｜{$word['table']}｜ＷＯＷ</title>";
		$this->head[] = "  <link type=\"text/css\" href=\"common/css/jquery-ui.custom.css\" rel=\"stylesheet\" />";
		$this->head[] = "  <link type=\"text/css\" href=\"common/css/jquery-ui.css\" rel=\"stylesheet\" />";
		$this->head[] = "  <link type=\"text/css\" media=\"screen\" rel=\"stylesheet\" href=\"common/css/colorbox.css\" />";
		$this->head[] = "  <link type=\"text/css\" media=\"screen\" rel=\"stylesheet\" href=\"common/js/easyui/themes/metro/easyui.css\" />";

		// $this->head[] = "  <script type=\"text/javascript\" src=\"common/js/tinymce/tinymce.min.js\"></script>";
		$this->head[] = "  <script type=\"text/javascript\" src=\"common/js/ckeditor/ckeditor.js\"></script>";
		$this->head[] = "  <script type=\"text/javascript\" src=\"common/js/ckeditor/config.js\"></script>";
		$this->head[] = "  <script type=\"text/javascript\" src=\"common/js/wow.list.js\"></script>";
		$this->head[] = "  <script type=\"text/javascript\" src=\"common/js/jquery.ui.core.js\"></script>";
		$this->head[] = "  <script type=\"text/javascript\" src=\"common/js/jquery-ui.js\"></script>";
		$this->head[] = "  <script type=\"text/javascript\" src=\"common/js/jquery.ui.datepicker.js\"></script>";
		$this->head[] = "  <script type=\"text/javascript\" src=\"common/js/ui.datepicker-ja.min.js\"></script>";
		$this->head[] = "  <script type=\"text/javascript\" src=\"common/js/ajaxupload.js\"></script>";
		$this->head[] = "  <script type=\"text/javascript\" src=\"common/js/jquery.colorbox-min.js\"></script>";
		$this->head[] = "  <!--script type=\"text/javascript\" src=\"common/js/easyui/jquery.easyui.min.js\"></script-->";
				$this->head[] = "  <link type=\"text/css\" href=\"common/css/jquery-ui.custom.css\" rel=\"stylesheet\" />";
		$this->head[] = $this->ctrl->_editHead;
		$this->head[] = <<<_EOS_
  <script type="text/javascript">
	$(function(){

	  $('.dateScript').datepicker({dateFormat: 'yy-mm-dd', showAnim: 'fadeIn', showOn: 'button', buttonImage: 'common/img/calender_btn.gif', buttonImageOnly: true});
	  {$word['fileupload']}
	  $('div.file-upload a').colorbox({width:"700px", height:"550px", iframe:true, opacity:0.5});

		// 商品登録表の更新
		function itemlist_load(){
			$('#item_list').empty();

			var item = $('#capsselect_text').val();
			var category = 'caps';

			$.ajax({
				url: 'API/viewitemdata.php',
				type:'GET',
				dataType: 'html',
				data: {
					item: item,
					category : category
				},
				timeout:10000,
				success: function(d, dataType) {

					data = JSON.parse(d);

					$('#item_list').html(data.html);

					// 削除済み商品あるか判定
					len = data.deleted.length;
					if(len > 0){
						for (i=0; i < len; i++) {
							// 削除商品ID文字列
							var id = ","+parseInt(data.deleted[i])+",";
							
							var item = $('#capsselect_text').val();
							
							//カンマの有無
							if(item.indexOf(",")!=-1){
								// 削除
								item = item.replace(id, ',');
								//データ更新
								$('#capsselect_text').val(item);
							} else {
								$('#capsselect_text').val("");
							}
						}
					}

				},error: function(d, dataType) {

				}
			});

			return false;
		}
_EOS_;

if($word['self'] == "caps.php"){
$this->head[] = <<<_EOS_
		// 付属品の更新
		function accessorylist_load(){
			$('#accessory_list').empty();

			var accessory = $('#accessoryselect_text').val();
			var category = 'accessory';

			$.ajax({
				url: 'API/viewitemdata.php',
				type:'GET',
				dataType: 'html',
				data: {
					item: accessory,
					category : category
				},
				timeout:10000,
				success: function(d, dataType) {

					data = JSON.parse(d);

					$('#accessory_list').html(data.html);

					// 削除済み商品あるか判定
					len = data.deleted.length;
					if(len > 0){
						for (i=0; i < len; i++) {
							// 削除商品ID文字列
							var id = ","+parseInt(data.deleted[i])+",";
							
							var item = $('#accessoryselect_text').val();
							
							//カンマの有無
							if(item.indexOf(",")!=-1){
								// 削除
								item = item.replace(id, ',');
								//データ更新
								$('#accessoryselect_text').val(item);
							} else {
								$('#accessoryselect_text').val("");
							}
						}
					}

				},error: function(d, dataType) {

				}
			});

			return false;
		}
_EOS_;
}

$this->head[] = <<<_EOS_
		// 子ウインドウからの呼び出し用
		$.parentFunc = function(){
_EOS_;

if($word['self'] == "product.php" || $word['self'] == "other.php"){
$this->head[] = <<<_EOS_
		itemlist_load();
_EOS_;
}

$this->head[] = <<<_EOS_
			$('#item_text_dele').show();
		}
_EOS_;

if($word['self'] == "caps.php"){
$this->head[] = <<<_EOS_
		// 子ウインドウからの呼び出し用
		$.parentFunc2 = function(){
			accessorylist_load();
			$('#accessory_text_dele').show();
		}
_EOS_;
}

$this->head[] = <<<_EOS_
		// ページ読み込み
		$(window).on('load',function(){
_EOS_;

if($word['self'] == "product.php" || $word['self'] == "other.php"){
$this->head[] = <<<_EOS_
			itemlist_load();
_EOS_;
}

$this->head[] = <<<_EOS_
			itembutton_toggle();
_EOS_;

if($word['self'] == "caps.php"){
$this->head[] = <<<_EOS_
			accessorybutton_toggle();

			accessorylist_load();
_EOS_;
}

$this->head[] = <<<_EOS_
		});
	});

	function itembutton_toggle() {
		var itemLen = $('#capsselect_text').val();

		//選択商品ある
		if(itemLen && itemLen != ','){
			$('#item_text_dele').show();
		}else{
			$('#item_text_dele').hide();
		}
	}

	function accessorybutton_toggle() {
		var accessoryLen = $('#accessoryselect_text').val();

		//選択商品ある
		if(accessoryLen && accessoryLen != ','){
			$('#accessory_text_dele').show();
		}else{
			$('#accessory_text_dele').hide();
		}
	}

	function cancelImage(id)
	{
	  $('input#' + id).val('');
	  $('div#' + id + '-div div.file-upload').show();
	  $('div#' + id + '-div div.file-cancel').hide();
	  return false;
	}

	// 商品選択リストのデータ削除
	$(document).on('click', '#item_list .deleted', function(e){

		// データが無い場合
		if($('#capsselect_text').val() == "," || $('#capsselect_text').val() == "" || $('#capsselect_text').val() == ",,"){
			$('#item_text_dele').hide('');
		}else{
			// 削除商品ID文字列
			var id = e.currentTarget.id;
			// 既存類似商品ID文字列取得
			var item = $('#capsselect_text').val();
			var itemlistArray = item.split(",");
			var additem = '';
			var resultitem = '';

			// 削除
			itemlistArray.filter(function (v, i, s) {
				if (v == id) itemlistArray.splice(i,1);
			});

			resultitem = itemlistArray.join(',');

			if(resultitem.slice(0, 1) == ','){
				resultitem = resultitem.slice(1);
			}
			if(resultitem.slice(-1) == ','){
				resultitem = resultitem.slice( 0, -1 );
			}

			$('#capsselect_text').val(resultitem);

			// //カンマの有無
			// if(item.indexOf(",")!=-1){
			// 	// 削除
			// 	item = item.replace(id, ',');
			// 	//データ更新
			// 	$('#capsselect_text').val(item);
			// } else {
			// 	$('#capsselect_text').val("");
			// }

			// 子要素の数を取得
			//var n = $(this).closest('.file-list').children().length;
			//var n = $(this).closest('.file-cancel').children().length;

			// 削除
			$(this).closest('.file-cancel').remove();
		}
	});

	// 商品選択リストのデータ削除
	$(document).on('click', '#accessory_list .deleted', function(e){

		// データが無い場合
		if($('#accessoryselect_text').val() == "," || $('#accessoryselect_text').val() == "" || $('#accessoryselect_text').val() == ",,"){
			$('#accessory_text_dele').hide('');
		}else{
			// 削除商品ID文字列
			var id = e.currentTarget.id;
			// 既存類似商品ID文字列取得
			var item = $('#accessoryselect_text').val();
			var itemlistArray = item.split(",");
			var additem = '';
			var resultitem = '';

			// 削除
			itemlistArray.filter(function (v, i, s) {
				if (v == id) itemlistArray.splice(i,1);
			});

			resultitem = itemlistArray.join(',');

			if(resultitem.slice(0, 1) == ','){
				resultitem = resultitem.slice(1);
			}
			if(resultitem.slice(-1) == ','){
				resultitem = resultitem.slice( 0, -1 );
			}

			$('#accessoryselect_text').val(resultitem);

			// //カンマの有無
			// if(item.indexOf(",")!=-1){
			// 	// 削除
			// 	item = item.replace(id, ',');
			// 	//データ更新
			// 	$('#accessoryselect_text').val(item);
			// } else {
			// 	$('#accessoryselect_text').val("");
			// }

			// 子要素の数を取得
			//var n = $(this).closest('.file-list').children().length;
			//var n = $(this).closest('.file-cancel').children().length;

			// 削除
			$(this).closest('.file-cancel').remove();
		}
	});

	// 商品データ全削除
	$(document).on('click', '#item_text_dele', function(e){
		swal({
			title: '関連商品の削除',
			text: 'すべて削除してもよろしいですか？？',
			showCancelButton: true,
			confirmButtonColor: "#3987df",
			confirmButtonText: "OK",
			closeOnConfirm: true
		},
		function(){
			$('#item_list').empty();
			$('#capsselect_text').val('');
			$('#item_text_dele').hide('');
			return false;
		});
	});

	// 商品データ全削除
	$(document).on('click', '#accessory_text_dele', function(e){
		swal({
			title: '関連付属品の削除',
			text: 'すべて削除してもよろしいですか？？',
			showCancelButton: true,
			confirmButtonColor: "#3987df",
			confirmButtonText: "OK",
			closeOnConfirm: true
		},
		function(){
			$('#accessory_list').empty();
			$('#accessoryselect_text').val('');
			$('#accessory_text_dele').hide('');
			return false;
		});
	});
  </script>
_EOS_;

$_sort = isset($this->ctrl->sort) ? $this->ctrl->sort : "";
$_type = isset($this->ctrl->type) ? $this->ctrl->type : "";

		$this->body[] = <<<_EOS_
		<td id="main" class="mainColTop {$word['id']}"><!-- main start -->
		<form action="{$word['self']}" method="post" id="edit" enctype="multipart/form-data">
		  <input type="hidden" name="hiddenaction" value="doneEdit" />
		  <input type="hidden" name="id" value="{$this->ctrl->id}" />
          <input type="hidden" name="sort" value="{$_sort}" />
		  <input type="hidden" name="type" value="{$_type}" />
		  <input type="hidden" name="p" value="{$this->ctrl->p}" />
		  <input type="hidden" name="confirmssid" value="{$word['confirmssid']}" />

		  <div id="contribute">
			<div id="midashi">
			  <div id="midashiR">
				<div id="midashiL">
				  <h2>記事投稿</h2>
				</div>
				<div id="midashiL2">
				  <h3>{$word['table']}</h3>
				</div>
				<p class="arrow"><strong>編集</strong></p>
			  </div>
			</div>
_EOS_;
		if(count($this->errors)){
			$this->body[] = <<<_EOS_
			<div id="attention">
			  <ul>
				<li>記入方法に問題があるか、間違いがある可能性があります。</li>
			  </ul>
			</div>
_EOS_;
		}
		$this->body[] = <<<_EOS_
			<div id="inputBox">
			  <div class="btnBox02">
				<input type="image" name="btnCancelEdit" src="common/img/cancel_btn.gif" alt="キャンセル" onmouseover="this.src='common/img/cancel_btn_o.gif'" onmouseout="this.src='common/img/cancel_btn.gif'" />{$word['saveBtn']}
			  </div>
			  <div id="inputInner">
				<div class="necessary clr">
				  <p class="check"><img src="common/img/necessary.gif" alt="必須項目" /><span>印は入力必須項目です。</span></p>
_EOS_;
		if($this->ctrl->_previewScript){
			$this->body[] = '				   <p class="right"><a href="#" onclick="return postDraft(\'' . $this->ctrl->_previewScript . '\');"><img src="common/img/preview_btn.gif" alt="プレビュー" width="68" height="21" border="0" class="rollover" /></a></p>';
		}
		$this->body[] = <<<_EOS_
				</div>
				<div id="mainFormBox" class="clr">
_EOS_;

		foreach($columns as $c){
			$disnone = "";
			$word['tableHead'] = '<strong>' . ((isset($info[$c]['labeljp'])) ? $info[$c]['labeljp'] : $c) . '</strong>';
			$word['tableRemarks'] = (isset($info[$c]['remark'])) ? $info[$c]['remark'] : '';
			if($word['tableRemarks'] == ''){
			}else if(substr($word['tableRemarks'], 0, 1) == '*'){
				$word['tableRemarks'] = '<img src="common/img/necessary.gif" alt="必須項目" /><span>' . substr($word['tableRemarks'], 1) . '&nbsp;</span>';
			}else{
				$word['tableRemarks'] = '<span>' . $word['tableRemarks'] . '</span>';
			}
			if(isset($this->errors[$c])){
				$word['tableError'] = '<img src="common/img/error.gif" alt="" width="21" height="21" /><span class="red">' . $this->errors[$c] . '</span>';
			}else{
				$word['tableError'] = '';
			}
			$word['tableEdit'] = $this->inputType->getEditItem($c, $row);
			if($word['tableEdit'] === FALSE){
				continue;
			}

			// if($c=="itemcategory_radio"){
			// 	$disnone = ' style="display:none;"';
			// }

			if($c=="capsselect_text" || $c=="accessoryselect_text"){
				if(isset($word['self']) && ($word['self'] == "product.php" || $word['self'] == "other.php" || $word['self'] == "caps.php")){
				$disnone = ' style="display:none;"';

				if($c=="capsselect_text"){
					$itemname = 'item';
				}elseif($c=="accessoryselect_text"){
					$itemname = 'accessory';
				}

				$this->body[] = <<<_EOS_
				<div id="{$c}-div" class="clr {$itemname}-div">
					<div class="midashi">{$word['tableHead']}</div>
					<div class="check">{$word['tableRemarks']}</div>
					<div class="error">{$word['tableError']}</div>
					<div class="inputBox clear"><a href="javascript:void(0);" onclick="window.open('search_product.php?action={$c}','searchWindow','width=750,height=760,menubar=yes,status=yes,scrollbars=yes');return false;" id="{$itemname}_text_add" class="Button color1">選択</a><a href="javascript:void(0);" id="{$itemname}_text_dele" class="Button color1 ml20">すべて削除</a></div>
				</div>
_EOS_;

				$this->body[] = <<<_EOS_
					<div id="{$itemname}_list" class="{$itemname}-div item_listbox"></div>
_EOS_;
				}
			}

			$this->body[] = <<<_EOS_
				  <div id="{$c}-div" class="clr item-div" {$disnone}>
					<div class="midashi">{$word['tableHead']}</div>
					<div class="check">{$word['tableRemarks']}</div>
					<div class="error">{$word['tableError']}</div>
					<div class="inputBox clear">{$word['tableEdit']}</div>
				  </div>
_EOS_;
		}

		
		$this->body[] = <<<_EOS_
				</div>
				<div class="necessary clr">
_EOS_;
		if($this->ctrl->_previewScript){
			$this->body[] = '				   <p class="right"><a href="#" onclick="return postDraft(\'' . $this->ctrl->_previewScript . '\');"><img src="common/img/preview_btn.gif" alt="プレビュー" width="68" height="21" border="0" class="rollover" /></a></p>';
		}
		$this->body[] = <<<_EOS_
				</div>
			  </div>
			  <div class="btnBox02">
				<input type="image" name="btnCancelEdit" src="common/img/cancel_btn.gif" alt="キャンセル" onmouseover="this.src='common/img/cancel_btn_o.gif'" onmouseout="this.src='common/img/cancel_btn.gif'" />{$word['saveBtn']}
			  </div>
			</div>
		  </div>
		</form>
		</td>
_EOS_;
	}
}
?>
