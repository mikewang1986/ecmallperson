<?php echo $this->fetch('top.html'); ?>
<script type="text/javascript">
$(function(){
    $('#register_form').validate({
        errorPlacement: function(error, element){
            var error_td = element.parent('dd');
            error_td.find('label').hide();
            error_td.append(error);
        },
        success       : function(label){
            label.addClass('validate_right').text('OK!');
        },
        onkeyup: false,
        rules : {
            user_name : {
                required : true,
                byteRange: [3,15,'<?php echo $this->_var['charset']; ?>'],
                remote   : {
                    url :'index.php?app=member&act=check_user&ajax=1',
                    type:'get',
                    data:{
                        user_name : function(){
                            return $('#user_name').val();
                        }
                    },
                    beforeSend:function(){
                        var _checking = $('#checking_user');
                        _checking.prev('.field_notice').hide();
                        _checking.next('label').hide();
                        $(_checking).show();
                    },
                    complete :function(){
                        $('#checking_user').hide();
                    }
                }
            },
            password : {
                required : true,
                minlength: 6
            },
            password_confirm : {
                required : true,
                equalTo  : '#password'
            },
            email : {
                required : true,
                email    : true
            },
            captcha : {
                required : true,
                remote   : {
                    url : 'index.php?app=captcha&act=check_captcha',
                    type: 'get',
                    data:{
                        captcha : function(){
                            return $('#captcha1').val();
                        }
                    }
                }
            },
            agree : {
                required : true
            }
        },
        messages : {
            user_name : {
                required : '您必须提供一个用户名',
                byteRange: '用户名必须在3-15个字符之间',
                remote   : '您提供的用户名已存在'
            },
            password  : {
                required : '您必须提供一个密码',
                minlength: '密码长度应在6-20个字符之间'
            },
            password_confirm : {
                required : '您必须再次确认您的密码',
                equalTo  : '两次输入的密码不一致'
            },
            email : {
                required : '您必须提供您的电子邮箱',
                email    : '这不是一个有效的电子邮箱'
            },
            captcha : {
                required : '请输入右侧图片中的文字',
                remote   : '验证码错误'
            },
            agree : {
                required : '您必须阅读并同意该协议,否则无法注册'
            }
        }
    });
});
</script>
<script type="text/javascript">
$(function(){
	poshytip_message($('#user_name'));
	poshytip_message($('#password'));
	poshytip_message($('#password_confirm'));	
	poshytip_message($('#email'));
	poshytip_message($('#captcha1'));
});
</script>
<style>
.w{width:990px;}
</style>
<div id="main" class="w-full">
<div id="page-register" class="w login-register mt20 mb20">
	<div class="w logo mb10">
		<p><a href="<?php echo $this->_var['site_url']; ?>" title="<?php echo $this->_var['site_title']; ?>"><img alt="<?php echo $this->_var['site_title']; ?>" src="<?php echo $this->_var['site_logo']; ?>" /></a></p>
	</div>
	<div class="w clearfix">
		<div class="col-main">
    	<ul class="clearfix">
        	<li class="icon_1"><i></i>购买商品支付订单</li>
			<li class="icon_2"><i></i>申请开店销售商品</li>
			<li class="icon_3"><i></i>收藏你喜欢的商品</li>
			<li class="icon_4"><i></i>收藏你喜欢的店铺</li>
			<li class="icon_5"><i></i>商品咨询服务评价</li>
			<li class="icon_6"><i></i>安全交易诚信无忧</li>
        </ul>
		<h4>如果您是本站用户</h4>
		<div class="login-field">
			<span>我已经注册过帐号，立即<a href="index.php?app=member&act=login" class="login-field-btn">登录</a></span>
			<span>或者 <a href="index.php?app=find_password" class="find-password">找回密码</a></span>
		</div>
	</div>
		<div class="col-sub">
		<div class="form">
    		<div class="title">用户注册</div>
       	 	<div class="content">
				<form name="" id="register_form" method="post" action="">
                
                	<dl class="clearfix">
                		<dt>推荐人</dt>
                    	<dd>
                    		<input type="text" style="width:145px;height:26px;" id="tname" class="input"  name="tname" title="tname"  />
                        	可以不填<br /><label></label>
                    	 </dd>
                	</dl>
                
        			<dl class="clearfix">
                		<dt>用户名</dt>
                    	<dd>
                    		<input type="text" style="width:245px;height:26px;" id="user_name" class="input"  name="user_name" title="3-15位字符，由中文、英文、数字以及'-'、'_'组成"  />
                        	<br /><label></label>
                   	  </dd>
                	</dl>
             		<dl class="clearfix">
                		<dt>密&nbsp;&nbsp;&nbsp;码</dt>
                    	<dd>
                    		<input class="input" type="password" id="password" name="password" title="长度在6-20个字符之间,由字母、数字和标点符号组成" />
                        	<div class="clr"></div><label></label>
                    	</dd>
                	</dl>
                	<dl class="clearfix">
              			<dt>确认密码</dt>
                    	<dd>
                    		<input class="input" type="password" id="password_confirm" name="password_confirm" title="请再次输入你的密码" />
                        	<div class="clr"></div><label></label>
                   	 	</dd>
                	</dl>
                	<dl class="clearfix">
                		<dt>电子邮箱</dt>
                    	<dd>
                    		<input class="input" type="text" id="email" name="email" title="请输入你的常用电邮，将来用于找回密码和接收商城信息" />
                        	<div class="clr"></div><label></label>
                    	</dd>
                	</dl>
            		<?php if ($this->_var['captcha']): ?>
                	<dl class="clearfix">
                		<dt>验证码</dt>
                    	<dd class="captcha clearfix">
                    		<input type="text" class="input float-left" name="captcha"  id="captcha1" title="请输入验证码，不区分大小写" />
                        	<img height="26" id="captcha" src="index.php?app=captcha&amp;<?php echo $this->_var['random_number']; ?>" class="float-left" />
                        	<a href="javascript:change_captcha($('#captcha'));" class="float-left">看不清，换一张</a>
                        	<div class="clr"></div><label></label>
                    	</dd>
                	</dl>
           			<?php endif; ?>
           			<dl class="clearfix">
                		<dt>&nbsp;</dt>
                    	<dd class="mall-eula">
                    		<input id="clause" type="checkbox" name="agree" value="1" class="agree-checkbox" checked="checked" />
                 			<span>我已阅读并同意 <a href="<?php echo url('app=article&act=system&code=eula'); ?>" target="_blank">用户服务协议</a></span>
                        	<div class="clr"></div><label></label>
                    	</dd>
               	 	</dl>
                	<dl class="clearfix">
                		<dt>&nbsp;</dt>
                    	<dd>
                 			<input type="submit" name="Submit"value="立即注册"class="register-submit"title="立即注册" />
                  			<input type="hidden" name="ret_url" value="<?php echo $this->_var['ret_url']; ?>" />
                   	  </dd>
                	</dl>
      			</form>                  
   			</div>
		</div>
    </div>
    </div>
</div>
</div>
<?php echo $this->fetch('footer.html'); ?>
