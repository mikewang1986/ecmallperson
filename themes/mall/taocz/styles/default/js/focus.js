//<![CDATA[
$(function(){
	(function(){
		var curr = 0;
		$(".focus li").each(function(i){
			$(this).click(function(){
				curr = i;
				$(".focus div").eq(i).fadeIn("slow").siblings("div").hide();
				$(this).siblings("li").removeClass("imgSelected").end().addClass("imgSelected");
				return false;
			});
		});
		
		var pg = function(flag){
			//flag:true��ʾǰ���� false��ʾ��
			if (flag) {
				if (curr == 0) {
					todo = 4;
				} else {
					todo = (curr - 1) % 5;
				}
			} else {
				todo = (curr + 1) % 5;
			}
			$(".focus li").eq(todo).click();
		};
		
		//�Զ���
		var timer = setInterval(function(){
			todo = (curr + 1) % 5;
			$(".focus li").eq(todo).click();
		},5000);
		
		//�����ͣ�ڴ�������ʱֹͣ�Զ���
		$(".focus li").hover(function(){
				clearInterval(timer);
			},
			function(){
				timer = setInterval(function(){
				todo = (curr + 1) % 5;
				$(".focus li").eq(todo).click();
				},5000);			
			}
		);
	})();
});


