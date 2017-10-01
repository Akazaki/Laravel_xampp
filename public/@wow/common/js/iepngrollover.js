var overImg = '_o';
var ua = navigator.userAgent;
if(ua.indexOf("MSIE") != -1 && ua.indexOf("6.0") != -1) {
	var ie6 = true;
}
$(function(){
	$('.png').each(function(){
		var classes = $(this).attr("class");
		if(classes.indexOf("rollover") != -1) {
			var imgout = $(this).attr("src");
			var imgovr = imgout.replace('.png', overImg+'.png');
			if(ie6 && IEPNGFIX) {
				IEPNGFIX.hover(this, imgovr);
			}else{
				$(this).hover(
					function(){ $(this).attr("src", imgovr); },
					function(){ $(this).attr("src", imgout); }
				);
			}
		} else {
			IEPNGFIX.fix(this);
		}
	});
	$('.rollover').each(function(){
		var classes = $(this).attr("class");
		if(classes.indexOf("png") == -1) {
			var imgout = $(this).attr("src");
			var imgovr = imgout.replace('.gif', overImg+'.gif').replace('.jpg', overImg+'.jpg').replace('.png', overImg+'.png');
			$(this).hover(
				function(){ $(this).attr("src", imgovr); },
				function(){ $(this).attr("src", imgout); }
			);
		}
	});
});
