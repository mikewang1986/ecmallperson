$(document).ready(function(){
	var totWidth=0;
	var positions = new Array();
	$('#slides .slidea').each(function(i){
		positions[i]= totWidth;
		totWidth += $(this).width();
		if(!$(this).width())
		{
			alert("Please, fill in width & height for all your images!");
			return false;
		}
	});
	$('#slides').width(totWidth);
	$('#dots ul li a').mouseover(function(e,keepScroll){
			$('li.menuItem').removeClass('act').addClass('inact');
			$(this).parent().addClass('act');
			
			var pos = $(this).parent().prevAll('.menuItem').length;
			
			$('#slides').stop().animate({marginLeft:-positions[pos]+'px'},380);
			e.preventDefault();
			if(!keepScroll) clearInterval(itvl);
	});
	$('#dots ul li.menuItem:first').addClass('act').siblings().addClass('inact');
	var current=1;
	function autoAdvance()
	{
		if(current==-1) return false;
		$('#dots ul li a').eq(current%$('#dots ul li a').length).trigger('mouseover',[true]);
		current++;
	}
	var changeEvery = 5;
	var itvl = setInterval(function(){autoAdvance()},changeEvery*600);//设置自动播放时间，越大越慢
});
