

$(function(){
	
	
	
	$('#get_search_box').click(function(){
	window.location.href = "/?act=wapsoso";
		//$('#keywordBox').focus();
	})


	
	$(".tab li").click(function(){
		$(this).siblings("li").removeClass("on");
		$(this).addClass("on");
		var act = $(this).attr("data-st");
		$('input[name="act"]').val(act);
	});
	
	
});

