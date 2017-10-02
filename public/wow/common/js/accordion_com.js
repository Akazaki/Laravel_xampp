//サイドアコーディオン
$(document).ready(function(){
//BEFORE
/*
	$('#leftSide ul li img').click(function() {
		
		// 表示中のメニューでない場合
		if(!$(this).hasClass("open")){
			
			// 表示中のメニューを閉じる
			$('#leftSide ul li img.open').next('ul').toggle('swing');
			$('#leftSide ul li img.open').removeClass('open');
			
			// クリックされたメニューを開く
			$(this).next('ul').toggle('swing');
			$(this).addClass('open');
		}
	});
	
	// 全て閉じる
	$('#leftSide ul li img').next('ul').hide();
	
	// OPENクラスのimgタグ配下のみ表示
	if($('#leftSide ul li img').hasClass("open")){
		$('#leftSide ul li img.open').next().slideDown(350,'swing');
	}
*/
	$('#leftSide ul li span').click(function() {
		if($(this).parent("li").hasClass("open")){
			$('#leftSide ul li').not(this).removeClass("open");
			$(this).next("ul").toggle("normal");
			$(this).parent("li").removeClass("open");
		} else {
			$('#leftSide ul li ul').not($(this).next("ul")).hide("normal");
			$('#leftSide ul li').not(this).removeClass("open");
			$(this).parent("li").addClass("open")
			$(this).next("ul").toggle('normal');
		}
	});
});
