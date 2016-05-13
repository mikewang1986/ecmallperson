
function loadlink(){
	$.ajax( {
		type : "POST",
		url : allWeb+"/b_link.do?method=loadLink",
		async:false,
		success : function(msg) {
			var message = msg.replace("adminSuperLogin","");
			if(""!=message){
				var jsonobj=eval("("+message+")");
				$("#linkpart").html("<li class=\"sfooter-link\"><a href=\"javascript:void(0);\" >友情链接：</a></li>");
				for ( var i = 0; i < jsonobj.length; i++) {
					$("#linkpart").append("<li class=\"sfooter-link\"><a href=\"http://"+jsonobj[i].herf+"\" target=\"_blank\" >"+jsonobj[i].name+"</a></li>");
				}
				$("#linkpart").show();
			}
		}
	});
}