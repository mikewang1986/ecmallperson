<?php echo $this->fetch('member.header.html'); ?>
<div class="content">
    <?php echo $this->fetch('member.menu.html'); ?>
    <div id="right">
    	
    	<?php echo $this->fetch('member.submenu.html'); ?>
        <div class="wrap">
            <div class="public_index table1">
              <style>
			    /* jquery.treeTable.collapsible
				 * ------------------------------------------------------------------------- */
				.treeTable tr td .expander {background-position: left center; background-repeat: no-repeat; cursor: pointer; padding: 0; zoom: 1;}
				.treeTable tr.collapsed td .expander {background-image: url(static/images/bgimg/tv-expandable.gif);}
				.treeTable tr.expanded td .expander {background-image: url(static/images/bgimg/tv-collapsable.gif);}
				
				/*列表表格*/
				.table_list{border:1px solid #d5dfe8; margin-bottom: 40px;}
				.table_list td,.table_list th{padding:0 4px;}
				.table_list thead th{height:30px; background:#eaf0f7; font-weight:normal; font-weight:700;}
				.table_list tbody td{border-top:1px solid #d5dfe8; padding:4px 4px; line-height:24px;}
				.table_list tr:hover,.table_list table tbody tr:hover{background:#ffffe1}
				.table_list .input-text-c{padding:0; height:18px}
				.input-text-c{border:1px solid #A7A6AA; height:18px; padding:2px 0 0; text-align:center}
				.table_list tr.on,.table_list tr.on td,.table_list tr.on th,.table_list td.on,.table_list th.on{background:#fdf9e5;}
				
				/*表单表格*/
				.table_form{}
				.table_form input{}
				.table_form td{padding-left:12px}
				.table_form td label{vertical-align:middle}
				.table_form td,.table_form th{padding:8px 0 8px 8px}
				.table_form thead {}
				.table_form thead th {color:#777;padding:5px 0 5px 8px;background:#eaf0f7; font-weight:normal; font-weight:700; border-bottom:1px solid #eee;}
				.table_form tbody td,.table_form tbody th{border-bottom:1px solid #eee;}
				.colorpanel tbody td,.colorpanel tbody th{padding:0;border-bottom: none;}
				.table_form tbody th{font-weight:normal; text-align:right;padding-right:10px; color:#777;}
				
				.table-other{border:1px solid #d5dfe8;}
				.table-other td,.table-other th{padding:0 10px;border:1px solid #d5dfe8;padding:5px 10px;}
				
				/*按钮*/
				.btn{color:#333;background:#f1f0f0;border:1px solid #c4c4c4;border-radius:2px;text-shadow:0 1px 1px rgba(255, 255, 255, 0.75);padding:4px 15px;display:inline-block;
				cursor:pointer;text-decoration:none;overflow:visible;text-align:center;zoom:1;white-space:nowrap;margin-right:10px;font-family:inherit;position:relative;}
				.btn:hover{background:#e9e7e7;}
				
				.btn_submit{color:#FFFFFF; background:#318dd0; text-shadow:0 -1px 0 rgba(0, 0, 0, 0.25); border-color:#106BAB #106BAB #0D68A9;}
				.btn_submit:hover{background:#3486c1;}
				
				.input-text,.measure-input,textarea,input.date,input.endDate,.input-focus{border:1px solid #A7A6AA;height:18px;padding:2px 0 2px 5px;border: 1px solid #d0d0d0;background: #FFF url(bgimg/input.png) repeat-x; font-family: Verdana, Geneva, sans-serif,"宋体";font-size:12px;}
				/*ajax加载*/
				.ajax_loading{color:#FFF; padding:2px 5px 2px 25px; background:url(static/images/bgimg/ajax_loading.gif) #FF5151 no-repeat 3px 2px; position:absolute; right:0; top:0; display:none;}
				
				.subnav{padding:10px;}
				
				/*内容菜单*/
				.content_menu{padding:0 0 6px;}
				.content_menu a:hover{text-decoration: none;}
				.content_menu a em{display:inline-block;display:-moz-inline-stack;zoom:1;*display:inline;}
				.content_menu a.add,.content_menu a.add em,
				.content_menu a.on,.content_menu a.on em{background:url(static/images/bgimg/bnt_bg.png) no-repeat;height:28px;line-height:28px;*line-height:28px}
				.content_menu span{color:#ddd;padding:0 8px}
				.content_menu a{cursor:pointer;}
				.content_menu a.add{padding:0 0 0 5px;}
				.content_menu a.add em{padding:0 10px 0 5px;color:#fff;background-position: right top;background-position:right -1px;}
				.content_menu a.on{background-position:left -40px;*background-position:left -41px;_background-position:left -39px;color:#fff;padding:0 0 0 5px;}
				.content_menu a.add,.content_menu a.add em,
				.content_menu a.on em{background-position:right -40px;background-position:right -41px;*background-position:right -41px;_background-position:right -39px;padding:0 10px 0 5px}
				.fb {font-weight:bold;}
				.ib, .ib_li li, .ib_a a, .ib-span span,.common_form ul li span.text,.fixed_bottom .fixed_but .btn,.arrowhead,.arrowhead-b,shortcut a,.shortcut a span,.picBut a,.tab_use{display:inline-block;display:-moz-inline-stack;zoom:1;*display:inline;}
				.blue,.blue a{color:#004499}
				.line_x{border-bottom:1px solid #eee;}
				
				/*dialog*/
				body {_margin:0; _height:100%;}/*IE6 BUG*/
				.d-outer {text-align:left;}
				.d-border, .d-dialog {border:0 none; margin:0; border-collapse:collapse; width:auto;}
				.d-nw, .d-n, .d-ne, .d-w, .d-c, .d-e, .d-sw, .d-s, .d-se, .d-header, .d-main, .d-footer {padding:0;}
				.d-header, .d-button {font: 12px/1.11 'Microsoft Yahei', Tahoma, Arial, Helvetica, STHeiti; _font-family:Tahoma,Arial,Helvetica,STHeiti; -o-font-family: Tahoma, Arial;}
				.d-title {overflow:hidden; text-overflow: ellipsis; cursor:default;}
				.d-state-noTitle .d-title {display:none;}
				.d-close {display:block; position:absolute; text-decoration:none; outline:none; _cursor:pointer;}
				.d-close:hover {text-decoration:none;}
				.d-main {text-align:center; vertical-align:top; min-width:9em;}
				.d-content {display:inline-block; display:block /*IE8 BUG*/; display:inline-block9 ; *zoom:1; *display:inline; text-align:left; border:0 none; width:100%;}
				.d-content.d-state-full {display:block; width:100%; margin:0; padding:0!important; height:100%;}
				.d-loading {height:32px; text-indent:-999em; overflow:hidden; background:url(static/images/bgimg/dialog/loading.gif) no-repeat center center;}
				.d-buttons {padding:5px 8px; text-align:right; white-space:nowrap;}
				.d-button {margin-left:15px; padding: 0 8px; cursor: pointer; display: inline-block; min-height:2.1em; text-align: center; *padding:4px 10px; *height:2em; letter-spacing:2px; font-family: Tahoma, Arial/9!important; width:auto; overflow:visible; *width:1; color: #333; border: 1px solid #999; border-radius: 5px; background: #DDD; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#FFFFFF', endColorstr='#DDDDDD'); background: linear-gradient(top, #FFF, #DDD); background: -moz-linear-gradient(top, #FFF, #DDD); background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#FFF), to(#DDD)); text-shadow: 0px 1px 1px rgba(255, 255, 255, 1); box-shadow: 0 1px 0 rgba(255, 255, 255, .7),  0 -1px 0 rgba(0, 0, 0, .09); -moz-transition:-moz-box-shadow linear .2s; -webkit-transition: -webkit-box-shadow linear .2s; transition: box-shadow linear .2s;}
				.d-button::-moz-focus-inner, .d-button::-moz-focus-outer {border:0 none; padding:0; margin:0;}
				.d-button:focus {outline:none 0; border-color:#426DC9; box-shadow:0 0 8px rgba(66, 109, 201, .9);}
				.d-button:hover {color:#000; border-color:#666;}
				.d-button:active {border-color:#666; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#DDDDDD', endColorstr='#FFFFFF'); background: linear-gradient(top, #DDD, #FFF); background: -moz-linear-gradient(top, #DDD, #FFF); background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#DDD), to(#FFF)); box-shadow:inset 0 1px 5px rgba(66, 109, 201, .9), inset 0 1px 1em rgba(0, 0, 0, .3);}
				.d-button[disabled] {cursor:default; color:#666; background:#DDD; border: 1px solid #999; filter:alpha(opacity=50); opacity:.5; box-shadow:none;}
				.d-state-highlight {color: #FFF; border: 1px solid #1c6a9e; background: #2288cc; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#33bbee', endColorstr='#2288cc'); background: linear-gradient(top, #33bbee, #2288cc); background: -moz-linear-gradient(top, #33bbee, #2288cc); background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#33bbee), to(#2288cc)); text-shadow: -1px -1px 1px #1c6a9e;}
				.d-state-highlight:hover {color:#FFF; border-color:#0F3A56;}
				.d-state-highlight:active {border-color:#1c6a9e; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#33bbee', endColorstr='#2288cc'); background: linear-gradient(top, #33bbee, #2288cc); background: -moz-linear-gradient(top, #33bbee, #2288cc); background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#33bbee), to(#2288cc));}
				.d-mask {background:#FFF; filter:alpha(opacity=30); opacity:.3;}
				
				.d-inner {background:#FFF; border:1px solid #999;}
				.d-nw, .d-ne, .d-sw, .d-se {width:6px; height:6px;}
				.d-nw, .d-n, .d-ne, .d-w, .d-e, .d-sw, .d-s, .d-se {background:rgba(0, 0, 0, .2); background:#0009!important; filter:alpha(opacity=20);}
				.d-state-lock .d-nw, .d-state-lock .d-n, .d-state-lock .d-ne, .d-state-lock .d-w, .d-state-lock .d-e, .d-state-lock .d-sw, .d-state-lock .d-s, .d-state-lock .d-se {background:rgba(0, 0, 0, .2); background:#0009!important; filter:alpha(opacity=20);}
				.d-titleBar {position:relative; height:100%;}
				.d-title {height:30px; line-height:30px; padding:0 48px 0 10px; background-color:#edf5f8; font-weight:bold; font-size:14px; color:#999; background-color:#f2f2f3; border-bottom:1px solid #c7ced8;}
				.d-state-focus .d-title {color:#4c5a5f;}
				.d-state-drag .d-title {cursor:move;}
				.d-close {padding:0; top:0; right:8px; width:28px; height:18px; background-image:url(static/images/bgimg/dialog/close.gif); background-repeat:no-repeat; text-indent:-9em; overflow:hidden;}
				.d-close:hover {background-position:0 -18px;}
				.d-close:active {background-position:0 -18px;}
				.d-content {color:#666;}
				.d-state-focus .d-content {color:#000;}.d-buttons {background-color:#F6F6F6; border-top: 1px solid #DADEE5;}
				.d-state-noTitle .d-close {top:0; right:0; width:18px; height:18px; line-height:18px; text-align:center; text-indent:0; font-size:18px; text-decoration:none; color:#214FA3; background:none; filter:!important;}
				.d-state-noTitle .d-close:hover, .d-state-noTitle .d-close:active {text-decoration:none; color:#900;}
				
				@media screen and (min-width:0) {/* css3 */
					.d-state-focus .d-dialog {box-shadow: 0 0 3px rgba(0, 0, 0, .2);}
					.d-state-drag, .d-state-focus:active  {box-shadow:none;}
					.d-state-focus {box-shadow:0 3px 8px rgba(0, 0, 0, .3);}
					.d-outer {-webkit-transform: scale(0); transform: scale(0); -webkit-transition: -webkit-box-shadow .2s ease-in-out, -webkit-transform .2s ease-in-out; transition: box-shadow .2s ease-in-out, transform .2s ease-in-out;}
					.d-state-visible {-webkit-transform: scale(1); transform: scale(1);}
				}
				
				.color_picker_btn{display:inline-block;position:relative;}
				
				/* 提示信息 */
				.tipbox{height:54px; line-height:54px; position:absolute; display:none;}
				.tipbox .tip-l{float:left; width:45px; height:54px; background-image:url(static/images/bgimg/tip_layer.png); background-repeat:no-repeat; background-position:-5px 0;}
				.tipbox .tip-c{float:left; height:54px; line-height:52px; padding:0 10px 0 5px; background-image:url(static/images/bgimg/tip_layer.png); background-repeat:repeat-x; background-position:0 -161px;}
				.tipbox .tip-r{float:left; width:5px; height:54px; background-image:url(static/images/bgimg/tip_layer.png); background-repeat:no-repeat; background-position:0 0;}
				.tip-success .tip-l{background-position:-6px 0;}
				.tip-alert .tip-l{background-position:-6px -54px;}
				.tip-error .tip-l{background-position:-6px -108px;}
				
				
				/* 附件tip */
				.attachment_icon{margin-left:8px; position:relative;}
				.attachment_tip{border:1px #CCC solid; position:absolute; left:16px; top:16px; display:none; padding:1px; z-index:9;}
				</style>
				<script>
				var lang = new Object();
					lang.connecting_please_wait = "请稍后...";lang.confirm_title = "提示消息";lang.move = "移动";lang.dialog_title = "消息";lang.dialog_ok = "确定";lang.dialog_cancel = "取消";lang.please_input = "请输入";lang.please_select = "请选择";lang.not_select = "不选择";lang.all = "所有";lang.input_right = "输入正确";lang.plsease_select_rows = "请选择要操作的项目！";lang.upload = "上传";lang.uploading = "上传中";lang.upload_type_error = "不允许上传的文件类型！";lang.upload_size_error = "文件大小不能超过{sizeLimit}！";lang.upload_minsize_error = "文件大小不能小于{minSizeLimit}！";lang.upload_empty_error = "文件为空，请重新选择！";lang.upload_nofile_error = "没有选择要上传的文件！";lang.upload_onLeave = "正在上传文件，离开此页将取消上传！";
				</script>
              
              <table width="100%"  class="table_form" cellspacing="0">
                <form id="info_form" action="" method="post" enctype="multipart/form-data">
                 <tr>
                        <th width="150">1.</th>
                        <td>先填写微信AppId和微信AppSecret（这个2个值需要到微信公众平台获取）</td>
                    </tr>
                     <tr>
                        <th width="150">2.</th>
                        <td>按钮数最多只能创建3个，子按钮数最多创建5个，否则创建失败!</td>
                    </tr>
                     <tr>
                        <th width="150">3.</th>
                        <td>关键词需于《关键词自动回复》里的关键词对应,KEY值用字母或数字组成</td>
                    </tr>
                    
                    <tr>
                        <th width="150">4.</th>
                        <td>功能表 输入【cxbd】绑定会员,输入【quit】退出绑定,输入【member】会员中心,输入【ddcx】查询订单,输入【kdcx】快递查询,输入【cxye】查询积分、余额,输入【222】推荐二维码</td>
                    </tr>
                     <tr>
                        <th width="150">微信AppId：</th>
                        <td><input type="text" name="weixin_appid" class="input-text" size="50" value="<?php echo $this->_var['wxconfig']['appid']; ?>"></td>
                    </tr>
                    <tr>
                        <th>微信AppSecret：</th>
                        <td><input type="text" name="weixin_appsecret" class="input-text" size="50" value="<?php echo $this->_var['wxconfig']['appsecret']; ?>"></td>
                    </tr>
                 <tr>
                        <th></th>
                        <td><input type="submit" class="btn btn_submit" value="提交"/></td>
                    </tr>
                    </form>
                </table>
                <div id="J_ajax_loading" class="ajax_loading">提交请求中，请稍候...</div>
                <div class="subnav">
                     <div class="content_menu ib_a blue line_x">
                          <a class="add fb J_showdialog" href="javascript:void(0);" data-uri="index.php?app=my_wxmenu&act=add" data-title="添加菜单" data-id="add" data-width="520" data-height="360"><em>添加菜单</em></a>
                     </div>
                </div>
                
                <div class="pad_lr_10">
                    <div class="J_tablelist table_list" data-acturi="index.php?app=my_wxmenu&act=ajax_col">
                    <table width="100%" cellspacing="0" id="J_cate_tree">
                        <thead>
                            <tr>
                                <th width="30"><input type="checkbox" name="checkall" class="J_checkall"></th>
                                <th width="30"><span data-tdtype="order_by" data-field="id">ID</span></th>
                                <th>菜单名称</th>
                               <th width="30%" >key值</th>
                                <th>关键词</th>
                             <!--   <th width="80">{:L('item_cate_type')}</th>-->
                                <th width="60"><span data-tdtype="order_by" data-field="ordid">排序</span></th>
                               
                                <th width="60"><span data-tdtype="order_by" data-field="status">状态</span></th>
                                <th width="180">管理操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php echo $this->_var['list']; ?>
                        </tbody>
                        <tr>
                        <td colspan="8"><a  onclick="creat()" ><input type="button" class="btn btn_submit" value="生成菜单"/></a></td>
                        </tr>
                    </table>
                    </div>
                </div>
                
            </div>
            <iframe name="pop_warning" style="display:none;"></iframe>
            <div class="wrap_bottom"></div>
        </div>
    </div>
    <div class="clear"></div>
</div>

<script> 
 function creat()
  {
	  if(confirm('是否创建自定义菜单'))
	  {
		  location.href="index.php?app=my_wxmenu&act=create_weixin_menu";
	  }
  }
</script>
<script charset="utf-8" type="text/javascript" src="static/js/admin.js" charset="utf-8"></script>
<script charset="utf-8" type="text/javascript" src="static/js/jquery.form.js" charset="utf-8"></script>
<script>//初始化弹窗
(function (d) {
    d['okValue'] = '确定';
    d['cancelValue'] = '取消';
    d['title'] = '消息';
})($.dialog.defaults);
</script>
<script src="static/js/plugins/listTable.js"></script><script>$(function(){
	$('.J_tablelist').listTable();
});
</script><script src="static/js/plugins/jquery.treetable.js"></script><script>$(function(){
    //initialState:'expanded'
    $("#J_cate_tree").treeTable({indent:20,treeColumn:2});
    $(".J_preview").preview();
});        
</script>

<?php echo $this->fetch('footer.html'); ?>