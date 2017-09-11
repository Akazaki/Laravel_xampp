$(document).ready(function() {
	$(".close dt").hover(function(){
		$(this).css("cursor","pointer"); 
	},function(){
		$(this).css("cursor","default"); 
		});
	$(".close dd.link").css("display","none");
	$(".close dt").click(function(){
		$(this).next().next().slideToggle("fast");
		});
});
$(document).ready(function() {
	$(".closeOshirase dt").hover(function(){
		$(this).css("cursor","pointer"); 
	},function(){
		$(this).css("cursor","default"); 
		});
	$(".closeOshirase dd.link").css("display","block");
	$(".closeOshirase dt").click(function(){
		$(this).next().slideToggle("fast");
		});
});
