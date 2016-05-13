<?php echo $this->fetch('top.html'); ?>
<script type="text/javascript">
$(function(){
    $('#login_form').validate({
        errorPlacement: function(error, element){
           var error_td = element.parent('dd');
            error_td.find('label').hide();
            error_td.append(error);
        },
        success       : function(label){
            label.addClass('validate_right').text('OK!');
        },
        onkeyup : false,
        rules : {
            user_name : {
                required : true
            },
            password : {
                required : true
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
            }
        },
        messages : {
            user_name : {
                required : '您必须提供一个用户名'
            },
            password  : {
                required : '您必须提供一个密码'
            },
            captcha : {
                required : '请输入右侧图片中的文字',
                remote   : '验证码错误'
            }
        }
    });
});
</script>
<style>
.w{width:990px;}
</style>
<div id="main" class="w-full">
	<div id="page-login" class="w login-register mt20 mb20">
    	<div class="w logo mb10">
			<a href="<?php echo $this->_var['site_url']; ?>" title="<?php echo $this->_var['site_title']; ?>"><img alt="<?php echo $this->_var['site_title']; ?>" src="<?php echo $this->_var['site_logo']; ?>" /></a>
		</div>
        <div class="w clearfix">
    	<div class="col-main">
    		<div class="login-edit-field" area="login_left" widget_type="area">
         		<?php $this->display_widgets(array('page'=>'login','area'=>'login_left')); ?>
        	</div>
    	</div>
		<div class="col-sub">
      		<div class="form">
        	<div class="title">用户登录</div>
            <div class="content">
        		<form method="post" id="login_form">
                	<dl class="clearfix">
                    	<dt>用户名</dt>
                        <dd>
                        	<input class="input" type="text" name="user_name"  />
                            <div class="clr"></div><label></label>
                        </dd>
                    </dl>
               		<dl class="clearfix">
                    	<dt>密&nbsp;&nbsp;&nbsp;码</dt>
                        <dd>
                        	<input class="input" type="password" name="password"/>
                            <div class="clr"></div><label></label>
                        </dd>
                    </dl>
               
               		<?php if ($this->_var['captcha']): ?>
              		<dl class="clearfix">
                  		<dt>验证码</dt>
                  		<dd class="captcha clearfix">
                     		<input type="text" class="input float-left" name="captcha" id="captcha1" />
                     		<img height="26" id="captcha" src="index.php?app=captcha&amp;<?php echo $this->_var['random_number']; ?>" class="float-left" />
                            <a href="javascript:change_captcha($('#captcha'));" class="float-left">看不清，换一张</a>
                     		<div class="clr"></div><label></label>
                  		</dd>
               		</dl>
               		<?php endif; ?>
               		<dl class="clearfix">
                  		<dt>&nbsp;</dt>
                  		<dd class="clearfix">
                     		<input type="submit" class="login-submit" name="Submit" value="登录" title="登录" />
                     		<a href="<?php echo url('app=find_password'); ?>" class="find-password">忘记密码？</a>
                     		<input type="hidden" name="ret_url" value="<?php echo $this->_var['ret_url']; ?>" />
                  		</dd>
               		</dl>
                	<dl class="clearfix">
                  		<dt>&nbsp;</dt>
                  		<dd class="register-now">
                        	如果您还不是会员，请<a href="<?php echo url('app=member&act=register&ret_url=' . $this->_var['ret_url']. ''); ?>" title="注册">注册</a><br/>
<a  href="<?php echo url('act=anyoneRegister&ret_url=' . $this->_var['ret_url']. ''); ?>"><img style="vertical-align:middle" src="<?php echo $this->res_base . "/" . 'images/niming.jpg'; ?>" /></a></dd>
               		</dl>
                    
            		<?php if ($this->_var['qqconnect_open'] || $this->_var['xwbconnect_open'] || $this->_var['alipayconnect_open']): ?>
            		<div class="partner-login">
						<h3>你可以用合作伙伴账号登陆</h3>
						<p>
                       		<?php if ($this->_var['qqconnect_open']): ?>
                        	<a href="<?php echo url('app=qqconnect&act=login'); ?>"><img style="vertical-align:middle" src="<?php echo $this->res_base . "/" . 'images/login_qq.png'; ?>" /></a>
                        	<?php endif; ?>
                        	<?php if ($this->_var['xwbconnect_open']): ?>
                        	<a href="<?php echo url('app=xwbconnect&act=login'); ?>"><img style="vertical-align:middle" src="<?php echo $this->res_base . "/" . 'images/login_weibo.png'; ?>" /></a>
                        	<?php endif; ?>
                        	<?php if ($this->_var['alipayconnect_open']): ?>
                        	<a href="<?php echo url('app=alipayconnect&act=login'); ?>"><img style="vertical-align:middle" src="<?php echo $this->res_base . "/" . 'images/login_alipay.png'; ?>" /></a>
                        	<?php endif; ?>
                        </p>
					</div>
                    <?php endif; ?>
                    
         		</form>
         	</div>
      	</div>
		</div>
        </div>
	</div>
</div>
<?php echo $this->fetch('footer.html'); ?>