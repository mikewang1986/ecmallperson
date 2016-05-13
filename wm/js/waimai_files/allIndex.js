$(document).ready(function() {
	//城市切换下拉
	$("#logoSeI_city").mouseover(function(){
		$("#logoSeI_cityAlert").show();
		$("#logoSeI_city").addClass("cur");
	});
	$("#logoSeI_city").mouseout(function(){
		$("#logoSeI_cityAlert").hide();
		$("#logoSeI_city").removeClass("cur");
	});
	$("#logoSeI_cityAlert").mouseover(function(){
		$("#logoSeI_cityAlert").show();
		$("#logoSeI_city").addClass("cur");
	});
	$("#logoSeI_cityAlert").mouseout(function(){
		$("#logoSeI_cityAlert").hide();
		$("#logoSeI_city").removeClass("cur");
	});
	$("#logoSeI_cityAlert").delegate("li a","click",function(){
		var curA=$(this);
		$("#logoSeI_cityAlert").hide();
		$("#logoSeI_city").removeClass("cur");
	});
	
	
	
	//搜索框内部的行业分类
	$("#selectedSelectId").mouseover(function(){
		$(this).find(".selectBody").show();
	});
	$("#selectedSelectId").mouseout(function(){
		$(this).find(".selectBody").hide();
	});
	$("#selectedSelectId .selectBody").delegate("li a","click",function(){
		var curA=$(this);
		var curA_selectid=curA.attr("selectid");
		if(curA_selectid=="1"){
			var curA_txt=curA.html();
			$("#selectedSelectId").find("cite").find("span").html(curA_txt);
			$("#selectedSelectId").find(".selectBody").hide();
		}else{
			myAlert(200,130,"提醒!","敬请期待","jinggao");
		}
		
	});
	
	
	//搜索
//	$("#q").blur(function(){
//		var i=$(this);
//		$("#searchAlert").hide();
//	});
//	$("#q").focus(function(){
//		var i=$(this);
//		var i_val=i.val();
//		if(null!=i_val && i_val!=""){
//			autoQueryBq();
//			sendData_ajax("ajaxSearch_s_index",i_val,"shop");
//			$("#searchAlert").show();
//		}
//	});
//	$("#q").change(function() {
//		autoQueryBq();
//		sendData_ajax("ajaxSearch_s_index",i_val,"shop");
//	});
//	 $("#q").keydown(function(event){  
//	     if(event.keyCode==13){  
//	    	 var value=$(this).val();
//	    	 var form1=$("<form>");
//	    	 form1.attr("method","post");
//	    	 var action=allWeb+"search.do?method=search&forwardPage=sproductList&queryArgs=[{'key':'name','value':'"+encodeURI(encodeURI(value))+"','operators':'like'},{'key':'status','value':'1','filedType':'int'}]&orderBy=[{'field':'scTime','ad':'asc'}]&returnListSize=20&isPage=true&searchStr="+encodeURI(encodeURI(value))+"&entityName=product";
//	    	 form1.attr("action",action);
//	    	 //alert(form1.attr("action"));
//	    	 form1.submit();
//	     }  
//	   });
	
	 //搜索框上面的选择
	 $("#header_search").delegate("ul li.J_SearchTab","click",function(){
		 var curLi=$(this);
		 $("#header_search").find("ul li.J_SearchTab").removeClass("selected");
		 curLi.addClass("selected");
		 //ajax
		 var stxt=$("#q").val();
		 //alert(stxt);
		 if(null!=stxt && stxt!=""){
			 $("#searchAlert").show();
			 var curLi_rel=curLi.attr("rel");
			 if(curLi_rel=="shop"){
				 sendData_ajax("ajaxSearch_s_index",stxt,"shop");
			 }else if(curLi_rel=="pro"){
				 sendData_ajax("ajaxSearch_p_index",stxt,"product");
			 }
		 }
		 
	 });
	 
	 $("#containerOUTER").mouseover(function(){
		 $("#searchAlert").hide();
	 });
	 
	 //搜索大按钮
	 $("#searchButton").click(function(){
		 var stxt=$("#q").val();
		 //alert(stxt);
		 if(null!=stxt && stxt!=""){
			 var form1=$("<form>");
	    	 form1.attr("method","post");
	    	 var action=allWeb+"search.do?method=search&forwardPage=sproductList&queryArgs=[{'key':'name','value':'"+encodeURI(encodeURI(stxt))+"','operators':'like'},{'key':'status','value':'1','filedType':'int'}]&orderBy=[{'field':'scTime','ad':'asc'}]&returnListSize=20&isPage=true&searchStr="+encodeURI(encodeURI(stxt))+"&entityName=product";
	    	 form1.attr("action",action);
	    	 //alert(form1.attr("action"));
	    	 form1.appendTo(document.body).submit();
	    	 
	    	  $("#formSearch").append(form1);
	    	 //form1.submit();
		 }
	 });
	 $("#searchButton").mouseover(function(){
		 $(this).addClass("cur");
	 });
	 $("#searchButton").mouseout(function(){
		 $(this).removeClass("cur");
	 });
});


//自动填充
var auto_name_prev;
var auto_name;
function autoQueryBq(){
	var timer;
	$("#q").bind('keyup',(function(){
		//$("#ts_loading").show();
		auto_name=$(this).val();
		if(auto_name!="" ){
			if(auto_name!=auto_name_prev){
				timer = setTimeout(function() { // 延时执行就是为了判断input的值有无变化 从而来判断是否完成了输入
		            sendData();
		            auto_name_prev=auto_name;
		           // $("#ts_loading").hide();
		            //$("#ts_clear").show();
			    }, 100); 
			}
		}
		
		
	}));
}

function sendData(){
	var canReq=true;
	if(auto_name==undefined || auto_name==""){
		canReq=false;
	}
	if(auto_name==auto_name_prev){
		canReq=false;
	}
	if(canReq){
		var tt=$("#selectedSelectId").find("cite").find("span").html();
		var entityName="shop";
		var forwardPage="ajaxSearch_s_index";
		if(tt=="餐品"){
			entityName="product";
			forwardPage="ajaxSearch_p_index";
		}
		
		var searchTopLi_cur=$("#header_search").find(".ks-switchable-nav").find("li.selected");
		var stli_cur_val=searchTopLi_cur.attr("rel");
		if(stli_cur_val=="shop"){
			
		}else if(stli_cur_val=="pro"){
			entityName="product";
			forwardPage="ajaxSearch_p_index";
		}
		sendData_ajax(forwardPage,auto_name,entityName);
		
	}
}
function sendData_ajax(forwardPage,auto_name,entityName){
	$.ajax( {
		type : "POST",
		url : allWeb+"search.do",
		data : "method=search_simple&forwardPage="+forwardPage+"&searchStr="+encodeURI(encodeURI(auto_name))+"&entityName="+entityName,
		beforeSend:function(){
			$("#tsearch_autocomplete").find(".twidget-loading").show();
			$("#searchData").hide();
		},
		success : function(msg) {
			$("#searchAlert").show();
			//$("#tsearch_autocomplete").find(".twidget-loading").hide();
			$("#searchAlert").show().html(msg);
		}
	});
}

/**
 * add by yangyong 2014520
 * @param name
 */
function findMShop(id){
	 var form1=$("<form>");
	 form1.attr("method","post");
	
//	 var action = allWeb+"search.do?method=searchMShop&forwardPage=mShoplist&queryArgs=[{'key':'name','value':'"+encodeURI(encodeURI(mshopname))+"','operators':'like'},{'key':'status','value':'1','filedType':'int'},{'key':'isMShop','value':'1','filedType':'int'}]&isPage=false&entityName=shop&searchStr="+encodeURI(encodeURI(mshopname));
	 var action = allWeb + "searchMShop-"+id+".html";
	 form1.attr("action",action);
	 
	 form1.appendTo(document.body).submit();
}


//<a href="<%=request.getContextPath()%>/myUser/${sessionScope.myUser.id}/orderShopList_[{'key':'userId','value':'${sessionScope.myUser.id}','filedType':'int'},{'key':'status','value':'5','filedType':'int'}]_[{'field':'id','ad':'desc'}]-pager-1.html">[去点评,点评即送10积分]</a>



















