/**
 * テーブルスクロールをおこなう
 */

/**
 * 初期化処理
 * 
 * @param string id : テーブルのＩＤ
 * @param object obj : 設定変数オブジェクト
 *                     init : 最初に先頭にきている行番号
 *                     range : 1ページに表示する行数
 *                     pages : 現在の行番号を表示するＩＤ
 */
function initMovingTable(id, obj){
	if(typeof obj == 'undefined'){
		obj = {'init':1, 'range':10};
	}
	if(typeof obj.init == 'undefined'){
		obj.init = 1;
	}
	if(typeof obj.range == 'undefined'){
		obj.range = 10;
	}

	var rows = $('table#' + id + ' tr');
	for(i=1; i<rows.length-1; i++){
		if(i < obj.init || obj.init + obj.range - 1 < i){
			$(rows[i]).hide();
		}
	}
	maxHead = rows.length - obj.range - 1;
	if(maxHead < 1) maxHead = 1;

	$('table#' + id).attr('range', obj.range).attr('maxHead', maxHead).attr('targetHead', obj.init).attr('currentHead', obj.init).attr('pages', obj.pages);

	var pageMax = rows.length - 2;
	if(obj.init + obj.range < pageMax){
		pageMax = obj.init + obj.range - 1;
	}
	$('#' + $('table#' + id).attr('pages') + '1').html(obj.init + ' - ' + pageMax);
	$('#' + $('table#' + id).attr('pages') + '2').html(obj.init + ' - ' + pageMax)
}
/**
 * ページをスクロールする
 * 
 * @param string id : テーブルのＩＤ
 * @param integer value : スクロールする行数
 */
function setHead(id, value){
	targetHead = parseInt($('table#' + id).attr('targetHead')) + value;
	maxHead = parseInt($('table#' + id).attr('maxHead'));

	if(targetHead < 1){
		targetHead = 1;
	}else if(targetHead > maxHead){
		targetHead = maxHead;
	}
	$('table#' + id).attr('targetHead', targetHead);

	rollTable(id);

	return false;
}
/**
 * ページのスクロールと行数の表示処理
 * 
 * @param string id : テーブルのＩＤ
 */
function rollTable(id){
	targetHead = parseInt($('table#' + id).attr('targetHead'));
	currentHead = parseInt($('table#' + id).attr('currentHead'));
	maxHead = parseInt($('table#' + id).attr('maxHead'));
	range = parseInt($('table#' + id).attr('range'));

	if(currentHead == targetHead){
		return true;
	}else if(currentHead > targetHead){
		var rows = $('table#' + id + ' tr');
		$(rows[currentHead+range-1]).hide();
		$(rows[currentHead-1]).show();
		setTimeout(function(){rollTable(id);}, 1 + Math.floor(200 / (currentHead - targetHead)));
		currentHead--;
	}else{
		var rows = $('table#' + id + ' tr');
		$(rows[currentHead]).hide();
		$(rows[currentHead+range]).show();
		setTimeout(function(){rollTable(id);}, 1 + Math.floor(200 / (targetHead - currentHead)));
		currentHead++;
	}
	$('table#' + id).attr('currentHead', currentHead);

	var pageMax = rows.length - 2;
	if(currentHead + range - 1 < pageMax){
		pageMax = currentHead + range - 1;
	}
	$('#' + $('table#' + id).attr('pages') + '1').html(currentHead + ' - ' + pageMax);
	$('#' + $('table#' + id).attr('pages') + '2').html(currentHead + ' - ' + pageMax)
}

/**
 * @param String actionValue : write value in input(name="action")
 * @param String submitName : create submitName form
 * @param String formExpr : form expression
 */
function postAction(actionValue, submitName, formExpr)
{
	$('input[name="hiddenaction"]').val(actionValue);
	if(typeof formExpr == 'undefined') formExpr = 'form';
	if(typeof submitName != 'undefined'){
		$(formExpr).append('<input type="hidden" name="' + submitName + '" value="SUBMIT" />');
	}
	$(formExpr).submit();
	return false;
}
function changeAll(check)
{
	checkFlg = $(check).prop('checked');
	
	$('input[name="id[]"]').prop('checked', checkFlg);
	$('input#changeAllHead').prop('checked', checkFlg);
	$('input#changeAllTail').prop('checked', checkFlg);
}
function postDraft(script)
{

	oScript = $('form').attr('action');
	$('form').attr('action', script + '?action=draft');
	$('form').attr('target', '_blank');
	$('form').submit();
	$('form').attr('target', '');
	$('form').attr('action', oScript);

	return false;
}
