$(function(){
	
	$('#gotop').click(function(){
		$('html,body').animate({scrollTop: '0px'}, 500);
	});
   
	$(window).scroll(function(){
		if($(window).scrollTop()>320){
			$("#gotop").fadeIn();
		}else{
			$("#gotop").fadeOut();
		}
		if($(window).scrollTop()>75){
			$("#ju-nav").addClass("fixed");
			$("#ju-nav .menu-cate").fadeIn();
		}else{
			$("#ju-nav").removeClass("fixed");
			$("#ju-nav .menu-cate").hide();
		}
	});
	$('.mall-nav .allcategory').hover(function(){
	   $(this).find('.allcategory-list').show();
   },function(){
	   $(this).find('.allcategory-list').hide();
   });
   
		
   $(".top-search li").click(function(){
	   $(".top-search li").each(function(){
		   $(this).removeClass("current");
	   });
	   $(this).addClass("current");
	   $(".top-search-box input[name='act']").val(this.id);
	   
	   if($.trim($(".top-search-box input[name='keyword']").val())==""){
		   $(".top-search-box input[name='keyword']").attr("class","");
		   $(".top-search-box input[name='keyword']").addClass(this.id+"_bj kw_bj keyword");
	   }
   }); 
   
   $(".top-search-box input[name='keyword']").focus(function(){
	   $(this).attr("class","keyword");
   }).blur(function(){
	   if($.trim($(this).val())=="") {
		   $(this).attr("class",$(this).parent().find("input[name='act']").val()+"_bj kw_bj keyword");
	   }
   });
   
   $('.login-register .form .input').focus(function(){
		$(this).removeClass('hover');
		$(this).addClass('focus');
	});
	$('.login-register .form .input').hover(function(){
		$(this).removeClass('hover');
		$(this).addClass('hover');
	},function(){
		$(this).removeClass('hover');
	});
	$('.login-register .form .input').blur(function(){
		$(this).removeClass('hover');
		$(this).removeClass('focus');
	});	
	
	$('#divQQbox').hover(function(){
		$('#divOnline').show();
		$('#divMenu').css('z-index','0');
	},
	function(){
		$('#divOnline').hide();
		$('#divMenu').css('z-index','100');
	});	
	
	$('.h_nav').click(function(){
		$(this).children('ul').toggle();	
	});	
	$(window).scroll(function(){
		var a=$(document).scrollTop()+a;
		$('#divQQbox').attr('style','top:'+a+'px');
	});
	
	$('.header_cart').hover(function(){
		$(this).addClass('active');
	},function(){
		$(this).removeClass('active');
	})
	
	$('.channel .ju-ele-nav').hover(function(){
		$('.channel .ju-ele-nav .ct').fadeIn();
		$('.channel .ju-ele-nav .bt').addClass('cbt');
	},function(){
		$('.channel .ju-ele-nav .ct').hide();
		$('.channel .ju-ele-nav .bt').removeClass('cbt');
	});
	
})

function poshytip_message(obj,className,showOn,alignTo,alignX,offsetX,offsetY)
{
	if(obj==undefined) return;
	if(className==undefined) className = 'tip-yellowsimple';
	if(showOn==undefined) showOn = 'focus';
	if(alignTo==undefined) alignTo = 'target';
	if(alignX==undefined) alignX = 'inner-left';
	if(offsetX==undefined) offsetX = 0;
	if(offsetY==undefined) offsetY = 5;
		
	obj.poshytip({
		className: className,
		showOn: showOn,
		alignTo: alignTo,
		alignX: alignX,
		offsetX: offsetX,
		offsetY: offsetY
	});
}

function countdown(theDaysBox, theHoursBox, theMinsBox, theSecsBox)
{
	var refreshId = setInterval(function() {
	var currentSeconds = theSecsBox.text();
	var currentMins    = theMinsBox.text();
	var currentHours   = theHoursBox.text();
	var currentDays    = theDaysBox.text();
	  
	  		// hide day
	  		//if(currentDays == 0) {
	  			//theDaysBox.next('em').hide();
	  			//theDaysBox.hide();
	 		//}
	  
	  		if(currentSeconds == 0 && currentMins == 0 && currentHours == 0 && currentDays == 0) {
	  			// if everything rusn out our timer is done!!
	  			// do some exciting code in here when your countdown timer finishes
	  	
	  		} else if(currentSeconds == 0 && currentMins == 0 && currentHours == 0) {
	  			// if the seconds and minutes and hours run out we subtract 1 day
				if(currentDays-1<10) { 
					html = '0' + (currentDays-1); 
				} else{ 
					html = currentDays-1;
				}
	  			theDaysBox.html(html);
	  			theHoursBox.html("23");
	  			theMinsBox.html("59");
	  			theSecsBox.html("59");
	  		} else if(currentSeconds == 0 && currentMins == 0) {
	  			// if the seconds and minutes run out we need to subtract 1 hour
				if(currentHours-1<10) { 
					html = '0' + (currentHours-1); 
				} else{ 
					html = currentHours-1;
				}
	  			theHoursBox.html(html);
	  			theMinsBox.html("59");
	  			theSecsBox.html("59");
	  		} else if(currentSeconds == 0) {
	  			// if the seconds run out we need to subtract 1 minute
				if(currentMins-1<10) { 
					html = '0' + (currentMins-1); 
				} else{ 
					html = currentMins-1;
				}
	  			theMinsBox.html(html);
	  			theSecsBox.html("59");
	  		} else {
				if(currentSeconds-1<10) { 
					html = '0' + (currentSeconds-1); 
				} else{ 
					html = currentSeconds-1;
				}
      			theSecsBox.html(html);
      		}
		}, 1000);
}

 //首页大幅幻灯图片
$(function() {
	var len = $("#J_Slide ul.slide-list li").length; //获取焦点图个数
	var index = 0;
	var picTimer;

	//为小按钮添加鼠标滑入事件，以显示相应的内容
	$(".slide-nav .dot").mouseenter(function() {
		index = $(".slide-nav .dot").index(this);
		showPics(index);
	}).eq(0).trigger("mouseenter");
	//鼠标滑上焦点图时停止自动播放，滑出时开始自动播放
	$("#J_Slide").hover(function() {
		clearInterval(picTimer);
	},function() {
		picTimer = setInterval(function() {
			showPics(index);
			index++;
			if(index == len) {index = 0;}
		},5000); //此4000代表自动播放的间隔，单位：毫秒
	}).trigger("mouseleave");
	
	//显示图片函数，根据接收的index值显示相应的内容
	function showPics(index) { //普通切换
		$(".slide-nav .dot").removeClass("selected").eq(index).addClass("selected"); //为当前的按钮切换到选中的效果
		if($("#J_Slide ul.slide-list li").eq(index).is(":animated")){
		$("#J_Slide ul.slide-list li").eq(index).stop();
		$("#J_Slide ul.slide-list li").eq(index).css({'opacity':'1','z-index':'9'});
		}
		else{
			$("#J_Slide ul.slide-list li").eq(index).css({'opacity':'1','z-index':'9'});
		}
		$("#J_Slide ul.slide-list li").eq(index).siblings().css('z-index','1').stop().animate({opacity:"0"},1000);	
		var s = $("#J_Slide ul.slide-list li").eq(index).find('div.modelLayer a img').attr('src');
		$('div.mallBack1').css('background', 'url('+ s +') repeat-x center top');
	}
});


//首页楼层框架切换的js
function myfocus(config){
	var sWidth = $(config.wrapper).width(); //获取焦点图的宽度（显示面积）
	var len = $(config.wrapper+' '+config.element).length; //获取焦点图个数
	var index = config.startindex;
	var picTimer;
	var selecter_span = config.wrapper+' '+config.index;
	$(selecter_span).mouseover(function() {
		index = $(selecter_span).index(this);
		showPics(index,sWidth,config);
	}).eq(0).trigger("mouseover");

	$(config.wrapper+" ul.element").css("width",sWidth * (len));
}
function showPics(index,sWidth,config) { //普通切换
	var nowLeft = -index*sWidth; //根据index值计算ul元素的left值
	$(config.wrapper+" ul.element").stop(true,false).animate({"left":nowLeft},config.time); 
	var selecter = config.wrapper+' '+config.index;
	$(selecter).removeClass(config.tmclass).eq(index).addClass(config.tmclass); //为当前的按钮切换到选中的
}

