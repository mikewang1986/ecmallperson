

/**
 *    修改人      修改时间       版本号           修改原因
 *  jacktong  20140225     20140225001    提交订单不发送商家短信提醒
 * 
 */













function searchAllData(){
	var form=$("#J_TSearchForm");
	var action;
	var searchData=$("#searchDataInput").val();
	var hangyeInputId=$("#hangyeInputId").val();
	var searchStr=$("#searchStrInput").val();
	var addressId=$("#search_addressId").val();
	if(hangyeInputId==null || hangyeInputId=="" || hangyeInputId=="0"){
		alert("请先选择行业");
	}else{

		if(searchData=="1"){
			//检索宝贝
			if(addressId!="" && addressId!="0"){
				action=allWeb+"products_[{'key':'address.id|address_id','value':'"+addressId+"','filedType':'varchar','operators':'address'},{'key':'name','value':'"+searchStr+"','operators':'like'},{'key':'status','value':'1','filedType':'int'},{'key':'proTypeROOTId','value':'"+hangyeInputId+"','filedType':'int'}]_[{'field':'avgScore','ad':'desc'}]-pager-1.html";
			}else{
				action=allWeb+"products_[{'key':'name','value':'"+searchStr+"','operators':'like'},{'key':'status','value':'1','filedType':'int'},{'key':'proTypeROOTId','value':'"+hangyeInputId+"'}]_[{'field':'avgScore','ad':'desc'}]-pager-1.html";
			}
		}else if(searchData=="3"){
			action=allWeb+"fnews/newsList_[{'key':'title','value':'"+searchStr+"','operators':'like'},{'key':'status','value':'1','filedType':'int'}]_[{'field':'id','ad':'desc'}]-pager-1.html";
		}else if(searchData=="2"){
			if(addressId!="" && addressId!="0"){
				action=allWeb+"shopSearch_[{'key':'address.id|address_id','value':'"+addressId+"','filedType':'varchar','operators':'address'},{'key':'name','value':'"+searchStr+"','operators':'like'},{'key':'status','value':'1','filedType':'int'},{'key':'typeIds','value':'"+hangyeInputId+"','filedType':'like'}]_[{'field':'id','ad':'desc'}]-pager-1.html";
			}else{
				action=allWeb+"shopSearch_[{'key':'name','value':'"+searchStr+"','operators':'like'},{'key':'status','value':'1','filedType':'int'},{'key':'typeIds','value':'"+hangyeInputId+"','operators':'like'}]_[{'field':'id','ad':'desc'}]-pager-1.html";
			}
		}
		
		if(action!=""){
			$.ajax( {
				type : "POST",
				url : allWeb+"abstractAction.do?method=saveArgs&argsForm=[{'key':'searchData','value':'"+searchData+"'},{'key':'cur_name','value':'"+searchStr+"'}]",
				success : function(msg) {
					
				}
			})
			form.attr("action",action);
			form.submit();
		}
		/*if(searchStr==null || searchStr=="" || searchStr=="null"){
			alert("请输入搜索字符串");
		}else{
		}*/
	}
	
}








//初始化tab菜单。
//tab:jquery对象，tab菜单最外层的div对象
//curSelected：选中的时候的class
//EG：initMyTab($("#myTabDiv_1"),"tab_li_selected");
function initMyTab(tab,curSelected,eventType){
	if(eventType==undefined || eventType==""){
		eventType="mouseover";
	}
	tab.css("width",tab.attr("width")).css("height",tab.attr("height"));
	tab.find(".myTab_bot").css("width",tab.attr("width"));
	tab.delegate(".tab_ul li",eventType,function(){
		var curLi=$(this);
		tab.find(".tab_ul li").removeClass(curSelected);
		curLi.addClass(curSelected);
		tab.find(".myTab_con").hide();
		
		var cUrl=curLi.attr("contentUrl");
		var curContentDiv=$("#"+curLi.attr("contentDiv"));
		curContentDiv.show();
		if(cUrl==undefined || cUrl==""){
		}else{
			$.ajax( {
				type : "POST",
				url : allWeb+cUrl,
				success : function(msg) {
					curContentDiv.html(msg);
				}
			})
		}
	});
	
	
	//如果初始化默认当前数据也为动态的话
	var initCur=tab.find(".tab_ul").find("."+curSelected);
	var initCur_action=initCur.attr("contentUrl");
	var initCur_contentdiv=$("#"+initCur.attr("contentdiv"));
	if(initCur_action==undefined || initCur_action==""){
		
	}else{
		$.ajax( {
			type : "POST",
			url : allWeb+initCur_action,
			success : function(msg) {
				alert(msg);
				initCur_contentdiv.html(msg);
			}
		})
	}

}










//左右滑动效果
//divId：最外层的id
//moveTime：滑动的速度时间
//intervalTime：每隔多少毫秒自动滑动
//liwidth：每个li的宽度
//position：左右两个箭头的定位
//initLeftRight("leftRight_3",500,5000,310,"absolute");
function initLeftRight(divid,moveTime,intervalTime,liwidth,position){
	var div=$("#"+divid);
	var ul=$("#"+divid+"_ul");
	var l=$("#"+divid+"_left");
	var r=$("#"+divid+"_right");
	
	var divHeight=div.attr("outerHeight");
	var divWidth=div.attr("outerWidth");
	
	ul.find("li").css("width",liwidth).css("height",divHeight);
	ul.parent(".ul_content").css("height",divHeight).css("width",divWidth);
	div.css("height",divHeight+"px");
	if(position=="absolute" || position=="relative"){
		if(position=="absolute"){
			div.css("position","relative");
			ul.parent(".ul_content").css("width",divWidth+"px");
			l.css("position",position).css("left","5px").css("top",(divHeight-10)/2+"px");
			r.css("position",position).css("right","5px").css("top",(divHeight-10)/2+"px");
		}else{
			ul.parent(".ul_content").css("width",(divWidth-25)+"px");
			l.css("position",position).css("left","0px").css("top",(divHeight-10)/2+"px");
			r.css("position",position).css("right","0px").css("top",(divHeight-10)/2+"px");
		}
	}
	
	
	var lisize=ul.find("li").length;
	
	var curLi=0;
	
	
	setInterval(function(){
		if(curLi==(lisize-1)){
			curLi=0;
			ul.animate({
			    left: '0'
			  }, moveTime, function() {
			  });
		}else{
			ul.animate({
			    left: '-='+liwidth
			  }, moveTime, function() {
			  });
			//ul.css("left","-"+(curLi+1)*liwidth+"px");
		}
		curLi++;
	},intervalTime);
	
	r.click(function(){
		if(curLi==(lisize-1)){
			curLi=0;
			ul.animate({
			    left: '0'
			  }, moveTime, function() {
			  });
		}else{
			ul.animate({
			    left: '-='+liwidth
			  }, moveTime, function() {
			  });
			//ul.css("left","-"+(curLi+1)*liwidth+"px");
		}
		curLi++;
	});
	l.click(function(){
		if(curLi==0){
			curLi=lisize;
			ul.animate({
			    left: '-'+(lisize-1)*liwidth
			  }, moveTime, function() {
			  });
		}else{
			ul.animate({
			    left: '-'+(curLi-1)*liwidth
			  }, moveTime, function() {
			  });
		}
		curLi--;
	});
}


//新轮播图
function initLunbotu_new(focus,sWidth,sHeight){
	focus.css("width",sWidth+"px");
	focus.find(".play-box").css("width",sWidth+"px");
	var yiban=parseInt(sHeight/2-10);
	
	var prev=focus.find(".prev");
	var next=focus.find(".next");
	var playNo=focus.find(".playNo");
	
	prev.css("top","-"+yiban+"px");
	next.css("top","-"+yiban+"px");
	
	var focusCJ=focus.find(".fxplay");
	focusCJ.fxuiPlay({
		qq:9169775,          //作者QQ号
		prev:prev,     //上一张
		next:next,     //下一张
		no:playNo,     //是否开启数字
		auto:true,           //是否自动播放
		autotime:5000,       //自动播放间隔
		effect:2,            //特效类型 0：渐变；1：变小 ;2:左右; 3:上下;
		efftime:400,         //渐变时间
		ismobi:false,         //如果手机端请传ture,会开启划动的操作。
		evt:'click'          //click(默认)和hover/mouserover
	});
}





//轮播图
//focus:jquery对象
//EG:
function initLunbotu(focus,sWidth,sHeight){
	//var sWidth = focus.width(); //获取焦点图的宽度（显示面积）
	focus.css("width",sWidth).css("height",sHeight);
	focus.find("ul").css("height",sHeight+"px");
	focus.find("ul li").css("height",sHeight+"px").css("width",sWidth);
	focus.find("ul li img").css("width",sWidth).css("height",sHeight);
	
	var len = focus.find(" ul li").length; //获取焦点图个数
	var index = 0;
	var picTimer;
	
	//以下代码添加数字按钮和按钮后的半透明条，还有上一页、下一页两个按钮
	var btn = "<div class='btnBg'></div><div class='btn'>";
	for(var i=0; i < len; i++) {
		btn += "<span></span>";
	}
	btn += "</div><div class='preNext pre'></div><div class='preNext next'></div>";
	focus.append(btn);
	focus.find(".btnBg").css("-moz-opacity",0.5).css("opacity",0.5).css("filter","alpha(opacity=50)");

	//为小按钮添加鼠标滑入事件，以显示相应的内容
	focus.find(" .btn span").css("opacity",0.5).mouseenter(function() {
		index = focus.find(".btn span").index(this);
		showPics(index);
	}).eq(0).trigger("mouseenter");

	//上一页、下一页按钮透明度处理
	focus.find(".preNext").css("opacity",0.2).hover(function() {
		$(this).stop(true,false).animate({"opacity":"0.5"},300);
	},function() {
		$(this).stop(true,false).animate({"opacity":"0.5"},300);
	});

	//上一页按钮
	focus.find(".pre").click(function() {
		index -= 1;
		if(index == -1) {index = len - 1;}
		showPics(index);
	});

	//下一页按钮
	focus.find(".next").click(function() {
		index += 1;
		if(index == len) {index = 0;}
		showPics(index);
	});

	//本例为左右滚动，即所有li元素都是在同一排向左浮动，所以这里需要计算出外围ul元素的宽度
	focus.find("ul").css("width",sWidth * (len));
	
	
	
	
	//鼠标滑上焦点图时停止自动播放，滑出时开始自动播放
	focus.hover(function() {
		clearInterval(picTimer);
	},function() {
		picTimer = setInterval(function() {
			showPics(index);
			index++;
			if(index == len) {index = 0;}
		},4000); //此4000代表自动播放的间隔，单位：毫秒
	}).trigger("mouseleave");
	
	//显示图片函数，根据接收的index值显示相应的内容
	function showPics(index) { //普通切换
		var nowLeft = -index*sWidth; //根据index值计算ul元素的left值
		focus.find("ul").stop(true,false).animate({"left":nowLeft},300); //通过animate()调整ul元素滚动到计算出的position
		//$("#focus .btn span").removeClass("on").eq(index).addClass("on"); //为当前的按钮切换到选中的效果
		focus.find(".btn span").stop(true,false).animate({"opacity":"0.5"},300).eq(index).stop(true,false).animate({"opacity":"1"},300); //为当前的按钮切换到选中的效果
	}
	
	focus.find(".pre").css("top",(sHeight-100)/2+"px");
	focus.find(".next").css("top",(sHeight-100)/2+"px");
	focus.find(".btnBg").css("width",sWidth+"px");
}


//上下循环滑动
//initTopBot("User_com_con","everyComm",1000,6000);
function initTopBot(outerId,innerClass,moveTime,intervalTime){
	var isStop=0;
	$("#"+outerId).mouseover(function(){
		isStop=1;
	});
	$("#"+outerId).mouseout(function(){
		isStop=0;
	});
	setInterval(function () {
		if(isStop==0){
			$('#'+outerId+" ."+innerClass+":last").hide().insertBefore($("#"+outerId+" ."+innerClass+":first")).slideDown(moveTime);
		}
	}, intervalTime);
}


function initEveryDiv(){
	var divs=$(".everyDiv");
	var size=divs.length;
	for(var i=0;i<size;i++){
		var div=$(divs[i]);
		var titleBgColor=div.attr("titleBgColor");
		var titleBotBorder=div.attr("titleBotBorder");
		var conBorder=div.attr("conBorder");
		var width=div.width();
		var height=div.height();
		var titleDiv=div.find(".everyDiv_title");
		var conDiv=div.find(".everyDiv_content");
		
		/*if(titleBgColor!="" && titleBgColor!=undefined){
			titleDiv.css("backgroundColor",titleBgColor);
		}*/
		if(titleBotBorder!="" && titleBotBorder!=undefined){
			titleDiv.css("borderBottom",titleBotBorder);
		}
		if(conBorder!="" && conBorder!=undefined){
			conDiv.css("border",conBorder);
		}
		
		var t_height=titleDiv.height();
		
		//div.find(".everyDiv_content").css("width",(width)+"px").css("height",(height-t_height-10)+"px");
	}
	
}


function initProductList(plDiv){
	plDiv.delegate(".everyProductInner","mouseover",function(){
		var curP=$(this);
		curP.addClass("current_everyProduct");
	});
	plDiv.delegate(".everyProductInner","mouseout",function(){
		var curP=$(this);
		curP.removeClass("current_everyProduct");
	});
}



function initFixed(rollStart,rollSet){
	//侧栏随动
	rollStart.before('<div class="da_rollbox" style="position:fixed;background-color:#fff;width:inherit;z-index:1000000000"></div>');
	var offset = rollStart.offset(),objWindow = $(window),rollBox = rollStart.prev();
	objWindow.scroll(function() {
		if (objWindow.scrollTop() > offset.top){
			if(rollBox.html(null)){
				rollSet.clone(true).prependTo('.da_rollbox');
			}
			rollBox.show().stop().animate({top:0,paddingTop:0},400);
		} else {
			rollBox.hide().stop().animate({top:0},400);
		}
	});
	
}



function initTmailLeftNav(options){
	$('#Z_TypeList').Z_TMAIL_SIDER(options);
}




//处理产品型为瀑布布局
function initMasonry(){
	/*jQuery.getScript("http://localhost:8080/peixun/js/masonry.pkgd.min.js", function(){
		
	});*/
	var $container = $('#productListOuter');
	// initialize
	$container.masonry({
	  columnWidth: 0,
	  itemSelector: '.everyProduct'
	});
}





//处理导航current效果
function mainNav(){
	var whichPage=$("#main").attr("pageName");
	$("#header_menu").find(".menu-special").find("li").removeClass("selected");
	
	var curLi=$("#"+whichPage);
	var curA=curLi.find("a");
	var text=curA.text();
	
	$("<span>").html(text).appendTo($("#"+whichPage));
	curA.remove();
	$("#"+whichPage).addClass("selected");
}




function chanageQuery(c){
	var curS=$(c);
	var action=curS.attr("action");
	var fieldName=curS.attr("fieldName");
	
	var value=curS.find("option:selected").val();
	action=action+"&"+fieldName+"="+value;
	$.ajax( {
		type : "POST",
		url : allWeb+action,
		success : function(msg) {
			curS.nextAll("select").remove();
			curS.after(msg);
			curS.removeAttr("name");
			curS.removeAttr("title");
			curS.removeAttr("must");
			curS.removeAttr("error");
			curS.removeAttr("errorMessage");
		}
	})
}

function changeQueryLast(c){
	var curS=$(c);
	var value=curS.find("option:selected").val();
	if(value!="0"){
		curS.removeAttr("error");
		curS.removeAttr("errorMessage");
	}
}
















function DrawImage(ImgD,FitWidth,FitHeight){
    var image=new Image();
    image.src=ImgD.src;
    if(image.width>0 && image.height>0){
        if(image.width/image.height>= FitWidth/FitHeight){
            if(image.width>FitWidth){
                ImgD.width=FitWidth;
                ImgD.height=(image.height*FitWidth)/image.width;
            }else{
                ImgD.width=image.width; 
               ImgD.height=image.height;
            }
        } else{
            if(image.height>FitHeight){
                ImgD.height=FitHeight;
                ImgD.width=(image.width*FitHeight)/image.height;
            }else{
                ImgD.width=image.width; 
               ImgD.height=image.height;
            } 
       }
    }
}


//处理everyDiv的宽度
function everyDiv(){
	$(".everyDiv").each(function(){
		var curDiv=$(this);
		var curDivW=curDiv.width();
		var curDivH=curDiv.height();
		
		var curDivCon=curDiv.find(".everyDiv_content");
		var curDivTi=curDiv.find(".everyDiv_title");
		
		var widthHeight=curDiv.attr("widthHeight");
		var curTiheight=curDivTi.height();
		var conPad=curDivCon.css("padding");
		conPad=conPad.replace("px");
		var conPadNum=parseInt(conPad);
		var newH=curDivH-(2*conPadNum+curTiheight);
		curDivCon.height(newH);
		
		var bl=curDivCon.css("borderLeftWidth");
		var br=curDivCon.css("borderRightWidth");
		bl=bl.replace("px");
		br=br.replace("px");
		var blInt=parseInt(bl);
		var brInt=parseInt(br);
		var newW=curDivW-(blInt+brInt+2*conPadNum);
		curDivCon.width(newW);
		
		//宽度都一样设置,只做heightType
		//有以下4种：1）100%满外层父亲(undefined)。2）高度随着里面内容的高度决定(auto)。3）固定的如100px
		//4)和2一样,但是没有margin
		var heightType=curDiv.attr("heightType");
		if(heightType=="auto"){
			curDiv.css("height","auto");
			curDivCon.css("height","auto");
			curDiv.css("marginBottom","10px");
		}else if(heightType=="autoNOMargin"){
			curDiv.css("height","auto");
			curDivCon.css("height","auto");
		}
		curDiv=null;
	});
	
}

//处理everyDiv的宽度
function everyDiv111(){
	$(".everyDiv").each(function(){
		var curDiv=$(this);
		var curDivW=curDiv.width();
		var curDivH=curDiv.height();
		
		var curDivCon=curDiv.find(".everyDiv_content");
		//处理curDivCon宽度
		var bl=curDivCon.css("borderLeftWidth");
		var br=curDivCon.css("borderRightWidth");
		bl=bl.replace("px");
		br=br.replace("px");
		var blInt=parseInt(bl);
		var brInt=parseInt(br);
		
		var conW=curDivCon.width();
		var conPad=curDivCon.css("padding");
		conPad=conPad.replace("px");
		var conPadNum=parseInt(conPad);
		
		var newConW=conW-(blInt+brInt+2*conPadNum);
		curDivCon.width(newConW);
		
		//处理curDivCon高度
		var curDivTi=curDiv.find(".everyDiv_title");
		var curTiheight=curDivTi.height();
		var curConheight=curDivCon.height();
		var newH=curDivH-curTiheight;
		curDivCon.height(newH-2*conPadNum);
	});
	
}

function mouseShopList(){
	$("#main").delegate(".everyShop","mouseover",function(){
		var curShop=$(this);
		curShop.addClass("everyShop_cur");
	});
	$("#main").delegate(".everyShop","mouseout",function(){
		var curShop=$(this);
		curShop.removeClass("everyShop_cur");
	});
}



function ifLogin(){
	var topHeader=$("#topbar");
	var userId=topHeader.attr("userId");
	if(userId==null || userId==""){
		myAlert(200,130,"错误!","请您先登录","error");
		window.location.href=allWeb+"userLogin.html";
		return false;
	}else{
		return true;
	}
}

//收藏餐品
function nowShoucangPro(b){
	var pId=$(b).attr("productId");
	var loginFalse=ifLogin();
	if(loginFalse){
		if(null!=pId && pId!=""){
			$.ajax( {
				type : "POST",
				url : allWeb+"uf_shoucang.do?method=shoucang&scEntity=myFrame.product.entity.Product&scTable=product&scEntityId="+pId,
				success : function(msg) {
					var con="";
					if(msg=="ok"){
						con="您收藏餐品成功，可到自己的用户中心中看到收藏到的餐品";
					}else{
						con="该餐品您已经收藏过了，可到用户中心去查看";
					}
					var scProSucAlert=art.dialog({
						id: 'scProSucAlert',
				    	title: "收藏餐品",
				    	lock: true,
				    	content:con
					});
					
				}
			})
		}
	}
}
//收藏餐厅
function nowShoucangShop(b){
	var sId=$(b).attr("shopId");
	var addOrDel=$(b).attr("addOrDel");
	if(addOrDel==undefined || addOrDel==null){
		addOrDel="add";
	}
	
	var loginFalse=ifLogin();
	if(loginFalse){
		if(null!=sId && sId!=""){
			if(addOrDel=="add"){
				$.ajax( {
					type : "POST",
					url : allWeb+"uf_shoucang.do?method=shoucang&scEntity=myFrame.shop.entity.Shop&scTable=shop&scEntityId="+sId,
					success : function(msg) {
						var con="";
						if(msg=="ok"){
							con="您收藏餐厅成功，可到自己的用户中心中看到收藏到的餐厅";
						}else{
							con="该餐厅您已经收藏过了，可到用户中心去查看";
						}
						var scShopSucAlert=art.dialog({
							id: 'scShopSucAlert',
					    	title: "收藏餐厅",
					    	lock: true,
					    	content:con
						});
					}
				})
			}else if(addOrDel=="del"){
				$.ajax( {
					type : "POST",
					url : allWeb+"uf_shoucang.do?method=remove&scTable=shop&scEntityId="+sId,
					success : function(msg) {
						var scShopSucAlert_=art.dialog({
							id: 'scShopSucAlert_',
					    	title: "取消收藏餐厅",
					    	lock: true,
					    	content:"取消收藏该餐厅成功"
						});
					}
				})
			}
		}
	}
	
}


















/**
 * #drag{width:400px;height:300px;background:url(http://upload.yxgz.cn/uploadfile/2009/0513/20090513052611873.jpg);cursor:move;position:absolute;top:100px;left:100px;border:solid 1px #ccc;}
 <div id="drag">
    	<h2>来拖动我啊</h2>
    </div>
 */
function drag(jobject){
	var dragging = false;
    var iX, iY;
    jobject.mousedown(function(e) {
        dragging = true;
        iX = e.clientX - this.offsetLeft;
        iY = e.clientY - this.offsetTop;
        this.setCapture && this.setCapture();
        return false;
    });
    document.onmousemove = function(e) {
        if (dragging) {
        var e = e || window.event;
        var oX = e.clientX - iX;
        var oY = e.clientY - iY;
        $("#drag").css({"left":oX + "px", "top":oY + "px"});
        return false;
        }
    };
    $(document).mouseup(function(e) {
        dragging = false;
        $("#drag")[0].releaseCapture();
        e.cancelBubble = true;
    })
}


function startWith(s,substring,count){
	if(s.substring(0,count) == substring) {
		return true;
	} else {
		return false;
	}
}









//=================================================================

function loginUser_ajax(){
	var name=$("#login_username").val();
	var pwd=$("#login_password").val();
	var rm=$("#rememberMeInput");
	var rmv;
	if(rm.attr("checked")){
		rmv=1;
	}else{
		rmv=0;
	}
	if(name!="" && pwd!=""){
		$.ajax( {
			type : "POST",
			url : allWeb+"f_user.do?method=login&name="+encodeURI(encodeURI(name))+"&password="+pwd+"&rememberMe="+rmv+"&forwardPage=ajaxOrder", //modify by jacktong 2014-03-14 中文用户名转码
			success : function(msg) {
				if(msg=="ok"){
					//alert("登录成功");
					window.location.href=allWeb+"uf_user.do?method=login_index";
					loadCoupons();//add by jacktong 2014-03-22 登陆成功后，查询优惠券信息
				}else if(msg=="ok-order"){
					window.location.href=allWeb+"toOrder.html";
				}else{
					myAlert(200,130,"错误!",msg,"error");
				}
			}
		})
	}else{
		myAlert(200,130,"错误!","请填写账号名和密码","error");
	}
}



//发送短信公共js
function sendSMS(telPhone,sdkMtType){
	if(null!=telPhone && telPhone!=""){
		$.ajax( {
			type : "POST",
			url : allWeb+"sdk.do?method=send&sdkMtType="+sdkMtType+"&telPhone="+telPhone,
			success : function(msg) {
				if(msg=="发送成功" || msg=="null" || msg==null){
					
				}else{
					myAlert(200,130,"错误!",msg,"error");
				}
			}
		});
	}
}
//发送短信公共js
function sendSMS_(sdkMtType,osoiId){
	if(null!=sdkMtType && sdkMtType!=""){
		$.ajax( {
			type : "POST",
			url : allWeb+"sdk.do?method=send&sdkMtType="+sdkMtType+"&isMustPhone=0&osoiId="+osoiId,
			async:false, //modify by jacktong 2014-02-25  发送短信异步请求
			success : function(msg) {
				if(msg=="发送成功" || msg=="null" || msg==null){
					
				}else{
					myAlert(200,130,"错误!",msg,"error");
				}
			}
		});
	}
}




function myAlert(width,height,title,data,infoType,footButOkFun){
	$("#myAlert").remove();
	
	var divI_w=parseInt(width)-6;
	var divI_h=parseInt(height)-6;
	
	var divI_con_w=parseInt(divI_w-20);
	var divI_con_h=parseInt(divI_h-20-25-35);
	
	
	
	var div=$("<div>").attr("id","myAlert");
		var divI=$("<div>").attr("class","myAlertI");
		divI.appendTo(div);
			var divI_t=$("<div>").attr("class","title");
			divI_t.appendTo(divI);
			var divI_t_span=$("<span>");
			divI_t_span.appendTo(divI_t);
			var divI_c=$("<div>").attr("class","content");
			divI_c.appendTo(divI);
				var divI_c_tipImg=$("<div>").addClass("macTipImg").addClass(infoType);
				divI_c_tipImg.css("top",(divI_con_h/2-20)+"px");
				divI_c_tipImg.appendTo(divI_c);
				var divI_c_Data=$("<div>").addClass("contentData");
				divI_c_Data.appendTo(divI_c);
			var divI_f=$("<div>").attr("class","foot");
			divI_f.appendTo(divI);
				var divI_f_butClose=$("<a>").attr("href","javascript:void(0)").addClass("footBut").addClass("footButClose").attr("footButType","close");
				divI_f_butClose.html("关闭");
				divI_f_butClose.appendTo(divI_f);
				divI_f_butClose.click(function(){
					//关闭
					div.hide();
				});
				if(footButOkFun!=null && footButOkFun!=undefined){
					var divI_f_butOk=$("<a>").attr("href","javascript:void(0)").addClass("footBut").addClass("footButOk").attr("footButType","ok");
					divI_f_butOk.html("确定");
					divI_f_butOk.appendTo(divI_f);
					divI_f_butOk.click(function(){
						//确定
						if(typeof footButOkFun =="function"){
							footButOkFun(div);
						 }
						div.hide();
					});
				}
				
			
		var top = ($(window).height() - height)/2; 
		var left = ($(window).width() - width)/2; 
		var scrollTop = $(document).scrollTop(); 
		var scrollLeft = $(document).scrollLeft(); 
		div.css( { 'top' : top + scrollTop, left : left + scrollLeft } ).show();
		div.css("width",width+"px").css("height",height+"px");
		/*var windowWidth = document.documentElement.clientWidth;
		var windowHeight = document.documentElement.clientHeight;
		div.css({
		   "width":width,
		   "height":height,
		   "top": windowHeight/2-height/2,
		   "left": windowWidth/2-width/2
		});*/
		
		divI.css("width",divI_w+"px").css("height",divI_h+"px");
		divI_t.css("width",divI_w+"px");
		divI_t.find("span").html(title);
		
		divI_c.css("width",divI_con_w+"px").css("height",divI_con_h+"px");
		divI_c_Data.css("width",(divI_con_w-50)+"px");
		var divIcData_h=divI_c_Data.height();
		divIcData_h=parseInt(divIcData_h);
		divI_c_Data.css("top",((divI_con_h-divIcData_h)/2-10)+"px");
		divI_c_Data.html(data);
		
		divI_f.css("width",divI_w+"px");
		
		
	$("body:last").append(div);
	div.show();
}


