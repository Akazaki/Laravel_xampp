<?php

/**
 * WOWView
 *
 */
class WOWEditWindowView
{
	var $ctrl = NULL;
	var $inputType = NULL;

	var $head = NULL;
	var $body = NULL;

	// 表示ＨＴＭＬのフォームエラー
	var $errors = array();

	function WOWEditWindowView($_ctrl)
	{
		$this->ctrl = $_ctrl;
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
  <link rel="stylesheet" href="common/css/imgmainte.css" type="text/css" media="all" />
<!--js-->
  <script type="text/javascript" src="common/js/jquery.js"></script>
  <script type="text/javascript" src="common/js/iepngrollover.js"></script>
_EOS_;
	}
	function setPreContents()
	{
		$word = array();
		$word['self'] = basename($_SERVER['PHP_SELF']);

		$this->body[] = <<<_EOS_
<div id="imgmainte">
  <div id="upperCol">
	<ul id="tab">
_EOS_;


		if($this->ctrl->_gw_action == 'edit' || $this->ctrl->_gw_action == 'doneEdit'){
			$this->body[] = <<<_EOS_
	  <li class="selected"><a href="#">アップロード</a></li>
	  <li><a href="{$word['self']}?action=list&amp;dir={$this->ctrl->dir}">ライブラリーから選択</a></li>
	</ul>
_EOS_;
		}else{
			$this->body[] = <<<_EOS_
	  <li><a href="{$word['self']}?action=edit&amp;dir={$this->ctrl->dir}">アップロード</a></li>
	  <li class="selected"><a href="#">ライブラリーから選択</a></li>
	</ul>
_EOS_;
		}
	}
	function setPostContents()
	{
		$word = array();

		if($this->ctrl->_gw_action == 'list'){
			$this->body[] = <<<_EOS_
  </div>
  <div id="underCol">
	<a href="#" onclick="return selectImage();"><img src="common/img/btn_imgmainte02.gif" width="69" height="21" alt="画像を挿入" class="rollover"	/></a>
  </div>
</div>
_EOS_;
		}else{
			$this->body[] = <<<_EOS_
  </div>
  <div id="underCol">
	<a href="#" onclick="$('form').submit();"><img src="common/img/btn_imgmainte01.gif" width="69" height="21" alt="画像を追加" class="rollover"  /></a>
  </div>
</div>
_EOS_;
		}
	}

	function setListContents($table, $columns, $rows)
	{
		$info = $this->ctrl->model->getInformation($table);

		// 認証が必要かフラグ
		$needAcknowledge = $this->ctrl->accessor->checkNeedAcknowledge($this->ctrl->SCRIPT_FROM_DOCUMENT_ROOT);

		$word = array();
		$word['self'] = basename($_SERVER['PHP_SELF']);
		$word['table'] = $info['table']['labeljp'];
		$word['tableHead'] = '';
		foreach($columns as $c){
			$word['tableHead'] .= ' 			   <th scope="col">' . ((isset($info[$c]['labeljp'])) ? $info[$c]['labeljp'] : $c) . "</th>\n";
		}
		$word['rowsCount'] = ifset($this->ctrl->_rowsCount, count($rows));
		if(basename($_SERVER['SCRIPT_NAME']) == 'filewindow.php'){
			$word['view'] = '../f.php?mode=icon&id=';
		}else{
			$word['view'] = '../a.php?mode=icon&id=';
		}

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

		$folderMaster = $this->ctrl->model->getMaster('folder');
		$showFolderGroup = wowConst('ACCESS_FOLDER');
		$word['option'] = '';
		foreach($folderMaster as $k => $f){
			if(isset($showFolderGroup[$k]) && ! ($showFolderGroup[$k] & $_SESSION['user']['group_check'])){
			}else if($k == $this->ctrl->f || (! $this->ctrl->f && strpos($this->ctrl->dir, 'f'. $k . '_') !== FALSE)){
				$word['option'] .= "<option value=\"{$k}\" selected=\"selected\">{$f}</option>";
			}else{
				$word['option'] .= "<option value=\"{$k}\">{$f}</option>";
			}
		}

		$this->head[] = "  <script type=\"text/javascript\" src=\"common/js/wow.list.js\"></script>";
		$this->head[] = "  <link type=\"text/css\" media=\"screen\" rel=\"stylesheet\" href=\"common/css/colorbox02.css\" />";
		$this->head[] = "  <script type=\"text/javascript\" src=\"common/js/jquery.colorbox-min.js\"></script>";
		$this->head[] = <<<_EOS_
  <script type="text/javascript">
	$(function(){
		// push image action, select radio
		$('a.cboxaction').each(function(i){
			jQuery(this).click(function(){
				href = jQuery(this).attr('href');
				jQuery('input[value="' + href.substring(12) + '"]').attr('checked', 'checked');
				return false;
			});
		});
	});
	function selectImage()
	{
		var dir = $('input[name="dir"]').val();
		$('input#' + dir, parent.document.body).val($('input[name="imageselect"]:checked').val());
		var pBody = parent.document.body;
		$('div#' + dir + '-div div.file-upload', pBody).show();
		$('div#' + dir + '-div div.file-upload', pBody).hide();
		$('div#' + dir + '-div div.file-cancel div', pBody).html('<span>' + $('input[name="imageselect"]:checked').attr('title') + '</span>');
		$('div#' + dir + '-div div.file-cancel img.file-icon', pBody).attr('src', '{$word['view']}' + $('input[name="imageselect"]:checked').val());
		$('div#' + dir + '-div div.file-cancel', pBody).show();
		parent.$.fn.colorbox.close();
		return false;
	}
	function changeFolder()
	{
		location.href = '{$word['self']}?dir=' + $('input[name="dir"]').val() + '&f=' + $('select').val();
	}
  </script>
_EOS_;

		$this->body[] = <<<_EOS_
	<input type="hidden" name="dir" value="{$this->ctrl->dir}" />
	<div id="mainteLibrary" class="clr">
	  <div class="libraryControl">
		<div class="libraryControl-left">
		  <p class="midashi"><strong>ライブラリー</strong></p>
		  <label>
		  <select name="select" id="select" onchange="changeFolder();">
			{$word['option']}
		  </select>
		  </label>
		</div>
		<div class="sortRight">
		  <span><a href="{$word['getstr_p']}0"><img src="common/img/pager_top_btn.gif" alt="最初" width="10" height="9" class="rollover" /></a><a href="{$word['getstr_p']}{$word['prev']}"><img src="common/img/pager_prev_btn.gif" alt="前" width="10" height="9" class="rollover" /></a></span><span id="page-span1" class="this">{$word['pagination']}</span><span>/</span><span class="all">{$word['rowsCount']} 件</span><span><a href="{$word['getstr_p']}{$word['next']}"><img src="common/img/pager_next_btn.gif" alt="次" width="10" height="9" class="rollover" /></a><a href="{$word['getstr_p']}{$word['tail']}"><img src="common/img/pager_end_btn.gif" alt="最後" width="10" height="9" class="rollover" /></a></span>
		</div>
	  </div>
	  <div id="inner">
_EOS_;

		$cnt = 0;
		$word['iconList'] = '';
		foreach($rows as & $row){
			if(! $this->ctrl->accessor->checkItemReadable($this->ctrl->SCRIPT_FROM_DOCUMENT_ROOT, $row)){
				continue;
			}

			if($cnt % 4 == 0){
				$word['iconList'] .= "        <div class=\"innerCol\">\n";
			}
			if($cnt % 4 == 3){
				$word['iconList'] .= "          <div class=\"listBox last\">\n";
			}else{
				$word['iconList'] .= "          <div class=\"listBox\">\n";
			}

			$word['iconList'] .= <<<_EOS_
			<div class="thumbnail">
			  <!--[if gte IE 6]><span></span><![endif]-->
_EOS_;
			$word['iconList'] .= '				<p>' . $this->inputType->getViewItem('data_bin', $row) . "</p>\n              </div>\n";
			$word['iconList'] .= '				<p class="title">' . $this->inputType->getViewItem('label_text', $row) . "</p>\n";

			$word['iconList'] .= <<<_EOS_
			<input name="imageselect" type="radio" value="{$row['id']}" title="{$row['label_text']}"/>

_EOS_;

			if($cnt % 4 == 3){
				$word['iconList'] .= "          </div>\n        </div>\n";
			}else{
				$word['iconList'] .= "          </div>\n";
			}

			$cnt++;
		}
		if($cnt % 4 != 0){
			$word['iconList'] .= "        </div>\n";
		}

		$this->body[] = $word['iconList'];
/*
		$isOdd = FALSE;
		foreach($rows as & $row){
			if(! $this->ctrl->accessor->checkItemReadable($this->ctrl->SCRIPT_FROM_DOCUMENT_ROOT, $row)){
				continue;
			}
			if($isOdd ^= TRUE){
				$this->body[] = '<tr>';
			}else{
				$this->body[] = '<tr class="line">';
			}
			$this->body[] = '<td class="center"><input type="checkbox" name="id[]" value="' . $row['id'] . '" /></td>';
			foreach($columns as $c){
				if($c == 'label_text'){
					$tBody = '<td class="menu-td"><a href="#" onclick="return false;">' . $this->inputType->getViewItem($c, $row) . '</a>';
					$tBody .= '<div class="hoverEdit">';

					if($this->ctrl->accessor->checkItemWritable($this->ctrl->SCRIPT_FROM_DOCUMENT_ROOT, $row)){
						$tBody .= '<p class="left"><a href="?action=edit&amp;id=' . $row['id'] . '">編集</a></p>';
						$tBody .= '<p><a href="?action=delete&amp;id=' . $row['id'] . '" onclick="return confirm(\'『' . $this->inputType->getViewItem($c, $row) . '』 を削除します。よろしいですか？\')">削除</a></p>';
					}else{
						$tBody .= '<p class="left"><a href="?action=edit&amp;id=' . $row['id'] . '">表示</a></p>';
					}

					$tBody .= '<p><a href="?action=copy&amp;id=' . $row['id'] . '">コピー</a></p>';
					if($row['acknowledge'] != '1'){
						if($needAcknowledge){
							$tBody .= '<p><a href="?action=inactive&amp;id=' . $row['id'] . '#">下書き</a></p>';
						}else{
							$tBody .= '<p><a href="?action=inactive&amp;id=' . $row['id'] . '#">不使用</a></p>';
						}
					}
					if($row['acknowledge'] != '2' && $needAcknowledge){
							$tBody .= '<p><a href="?action=suspend&amp;id=' . $row['id'] . '#">承認要請</a></p>';
					}
					if($row['acknowledge'] != '3' && $this->ctrl->accessor->checkItemAcknowledgable($this->ctrl->SCRIPT_FROM_DOCUMENT_ROOT, $row)){
						if($needAcknowledge){
							$tBody .= '<p><a href="?action=acknowledge&amp;id=' . $row['id'] . '#">承認</a></p>';
						}else{
							$tBody .= '<p><a href="?action=acknowledge&amp;id=' . $row['id'] . '#">使用</a></p>';
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
*/
		$this->body[] = <<<_EOS_
	  </div>

	  <div class="libraryControl">
		<span class="sortRight"><span><a href="{$word['getstr_p']}0"><img src="common/img/pager_top_btn.gif" alt="最初" width="10" height="9" class="rollover" /></a><a href="{$word['getstr_p']}{$word['prev']}"><img src="common/img/pager_prev_btn.gif" alt="前" width="10" height="9" class="rollover" /></a></span><span class="this">{$word['pagination']}</span><span>/</span><span class="all">{$word['rowsCount']} 件</span><span><a href="{$word['getstr_p']}{$word['next']}"><img src="common/img/pager_next_btn.gif" alt="次" width="10" height="9" class="rollover" /></a><a href="{$word['getstr_p']}{$word['tail']}"><img src="common/img/pager_end_btn.gif" alt="最後" width="10" height="9" class="rollover" /></span></span>
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
		$word['tableHead'] = '';
		foreach($columns as $c){
			$word['tableHead'] .= ' 			   <th scope="col">' . ((isset($info[$c]['labeljp'])) ? $info[$c]['labeljp'] : $c) . "</th>\n";
		}

		$this->head[] = "  <script type=\"text/javascript\" src=\"common/js/ajaxupload.js\"></script>";
		$this->head[] = <<<_EOS_
  <script type="text/javascript">
	$(function(){
	  new AjaxUpload('data_bin_b', {action: 'fileuploader.php', onComplete: function(file, response){

		var info = response.split(',');

		if(response == 'error:type'){
		  $('#data_bin-div p.error').html('<img height="21" width="21" alt="" src="common/img/error.gif" /><span class="red">WOWのアップロード対応ファイルは、JPG,GIF,PNG,PDF,XLS,DOCです</span>');
		}else if(response == 'error:size'){
		  $('#data_bin-div p.error').html('<img height="21" width="21" alt="" src="common/img/error.gif" /><span class="red">ファイルサイズが大きすぎます</span>');
		}else if(response === 'error'){
		  $('#data_bin-div p.error').html('<img height="21" width="21" alt="" src="common/img/error.gif" /><span class="red">サーバにアップできる容量を超えている可能性があります</span>');
		}else if(info[1] == 'pdf' || info[1] == 'doc' || info[1] == 'xls'){
		  $('#data_bin_i').attr('src', 'img/extension/file-' + info[1] + '.gif').attr('width', '120').attr('height', '120');
		  $('#data_bin').val(info[0]);
		  $('#name_text').val(file);
		  $('#type_view').val(info[1]);
		}else{
		  $('#data_bin_i').attr('src', 'uploadfiles/' + info[0]).attr('width', info[2]).attr('height', info[3]);
		  $('#data_bin').val(info[0]);
		  $('#name_text').val(file);
		  $('#type_view').val(info[1]);
		}
	  }});
	});
  </script>
_EOS_;
		$this->body[] = <<<_EOS_
	<div id="mainteUp">
	  <div class="necessary clr">
		<p class="check"><img src="common/img/necessary.gif" alt="必須項目" /><span>印は入力必須項目です。</span></p>
	  </div>
	  <form action="{$word['self']}" method="post">
		<input type="hidden" name="action" value="doneEdit" />
		<input type="hidden" name="dir" value="{$this->ctrl->dir}" />
_EOS_;

		foreach($columns as $c){
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

			$this->body[] = <<<_EOS_
				  <div id="{$c}-div" class="clr item-div">
					<p class="midashi">{$word['tableHead']}</p>
					<p class="check">{$word['tableRemarks']}</p>
					<p class="error">{$word['tableError']}</p>
					<p class="inputBox clear">{$word['tableEdit']}</p>
				  </div>
_EOS_;
		}

		$this->body[] = <<<_EOS_
	</form>
	</div>
_EOS_;
	}

	function setCloseContents($id, $title, $dir)
	{
		$word = array();
		$word['id'] = $id;
		$word['dir'] = $dir;
		if(basename($_SERVER['SCRIPT_NAME']) == 'filewindow.php'){
			$word['view'] = '../f.php?mode=icon&id=' . $word['id'];
		}else{
			$word['view'] = '../a.php?mode=icon&id=' . $word['id'];
		}
		$this->head[] = <<<_EOS_
  <script type="text/javascript" src="common/js/jquery.js"></script>
  <script type="text/javascript">
	$(function(){
	  var dir = '{$word['dir']}';
	  $('input#' + dir, parent.document.body).val({$word['id']});
	  $('div#' + dir + '-div div.file-upload', parent.document.body).show();
	  $('div#' + dir + '-div div.file-upload', parent.document.body).hide();
	  $('div#' + dir + '-div div.file-cancel div', parent.document.body).html('<span>{$title}</span>');
	  $('div#' + dir + '-div div.file-cancel img.file-icon', parent.document.body).attr('src', '{$word['view']}');
	  $('div#' + dir + '-div div.file-cancel', parent.document.body).show();
	  parent.$.fn.colorbox.close();
	  return false;
	});
  </script>
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
