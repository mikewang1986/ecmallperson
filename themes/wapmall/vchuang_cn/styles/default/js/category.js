(function($) {
	// ////////////////
	var btn_up = new Image(), btn_down = new Image();
	btn_up.src = "/themes/wapmall/vchuang_cn/styles/default/images/fenlei_shang.png";
	btn_down.src = "/themes/wapmall/vchuang_cn/styles/default/images/fenlei_xia.png";
	var Menu = {
		// 初始化事件
		initEvent : function() {
			$().ready(
					function() {
						$("div.clist").click(function(e) {
							Menu.router(e);
						});
						$("#allClass").click(function(e) {
							Menu.showMenu1();
						});
						$(window).on(
								"hashchange",
								function(e) {
									var name = decodeURIComponent(location.hash
											.replace(/^#/, ""));
									if (name != "") {
										Menu.showMenu3(name);
									}else{
										Menu.showMenu1();
									}
								});
					});
		},
		// 事件分发路油
		router : function(_event) {
			var target = $(_event.target || _event.srcElement);
			var _tar = target.closest(".level1");

			// 显示二级菜单
			if (_tar.length > 0) {
				Menu.showMenu2(_tar);
				/*var _gp = target.closest(".crow_row");// 点击事件对应此行的祖父级节点
				var _top = _gp.offset().top;
				setTimeout(function(){
					if (_top > 100) {
						window.scroll(0, _gp.offset().top);
					} else {
						window.scroll(0, _gp.offset().top - 50);
					}					
				},15)*/
				return;
			}
			_tar = target.closest(".level2");
			// 显示三级菜单
			if (_tar.length > 0) {
				Menu.showMenu3(_tar.html().trim());
				setTimeout(function(){
					window.scroll(0, 0);
				},10);
				
				return;
			}
			_tar = target.closest(".level3");
			// 显示三级菜单
			if (_tar.length > 0) {
				Menu.go(_tar.attr("_url"));
				return;
			}
		},
		// 显示一级菜单
		showMenu1 : function() {
			$("#contentsub").hide();
			$("#content").show();
		},
		// 显示二级菜单
		showMenu2 : function($curMenuDom) {
			var next = $curMenuDom.next("ul");
			if (next.css("display") == "none") {
				//$("ul.clist_sub").hide();
				//$("div.crow_arrow").each(function(i, dom) {
				//	$(dom).html(btn_down.cloneNode(true));
				//});
				next.css("opacity", "0").show().animate({
					opacity : 1
				}, 500);
				//next.show();
				$("div.crow_arrow", $curMenuDom).html(btn_up.cloneNode(true));
			} else {
				next.hide();
				$("div.crow_arrow", $curMenuDom).html(btn_down.cloneNode(true));
			}
		},
		// 显示三级菜单
		showMenu3 : function(name) {
			$("#contentsub").show();
			$("#content").hide();
			Menu._initMenu3(name, CDATE || {});
			location.hash = encodeURIComponent(name);
		},
		_initMenu3 : function(itemName, data) {
			var html = [ '<ul>' ];
			var level3 = data.level3;
			var defData = level3[itemName];
			var search_url = data.search_url;
			if (level3 && defData) {
				for ( var i = 0; i < defData.length; i++) {
					var item = defData[i];
					html.push('<li class="crow level3" _url="'+search_url +"&amp;"+ item.p +'"><div class="crow_row">');
					html.push('<div class="crow_title crow_sub_title">');
					html.push('' + item.n+ '');
					html.push('</div>');
					html.push('<div>&nbsp;</div>');
					html.push('</div></li>');
				}
			}
			html.push('</ul>');
			$("#level3").html(html.join(""))
		},
		go:function(url){
			window.location.href=url;
		}
	}
	window.Menu = Menu;
	Menu.initEvent();// 初始化事件
})($);