/*
ex)
  <ul>
    <li class="accordion">
      <img src="side01.gif" alt="" />
      <ul style="display: none;">
        <li><a href="#">1-1</a></li>
        <li><a href="#">1-2</a></li>
      </ul>
    </li>
    <li class="accordion">
      <img src="side01.gif" alt="" />
      <ul style="">
        <li><a href="#">2-1</a></li>
        <li><a href="#">2-2</a></li>
      </ul>
    </li>
  </ul>
 */
$(function(){
	var aPreLoad = new Array();
	$('li.accordion').each(function(i){
		imgObj = $(this).children('img');

		var src = imgObj.attr('src');
		var ftype = src.substring(src.lastIndexOf('.'), src.length);
		var hsrc = src.replace(ftype, '_o'+ftype);

		imgObj.css('cursor', 'pointer');
		imgObj.attr('hsrc', hsrc);
		aPreLoad[i] = new Image();
		aPreLoad[i].src = hsrc;
		
/*
		imgObj.click(function(){
			liObj = $(this).next();
			if(liObj.css('display') == 'none'){
				$(this).attr('src', $(this).attr('hsrc'));
				liObj.slideDown();
			}else{
				liObj.slideUp();
			}
		});
*/

		if($(this).hasClass('accordionOpen')){
			imgObj.attr('src', imgObj.attr('hsrc'));
			$(this).addClass('blue');
		}else{
//			$(this).find('ul').hide();
			$(this).hover(function(){
				$(this).find('img').attr('src', $(this).find('img').attr('hsrc'));
				$(this).addClass('blue');
			}, function(){
				$(this).find('img').attr('src', $(this).find('img').attr('src').replace('_o'+ftype, ftype));
				$(this).removeClass('blue');
			});
		}
	});
});
