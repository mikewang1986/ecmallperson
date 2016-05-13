<?php echo $this->fetch('member.header.html'); ?>
<style>
.information .info table{width :auto;}
</style>

<div class="content">
  <div class="totline"></div>
  <div class="botline"></div>
  <?php echo $this->fetch('member.menu.html'); ?>
  <div id="right"> <?php echo $this->fetch('member.submenu.html'); ?>
    
    <div class="wrap">
            <!--<div class="eject_btn_two eject_pos1" title="bind"><b class="ico3" ectype="dialog" dialog_title="bind" dialog_id="my_coupon_bind" dialog_width="480" uri="index.php?app=my_coupon&act=bind">bind</b>

	</div>-->
            
            
            
            
            <div class="tradelist">
                    	<div class="title clearfix"><!--<h1>最近10条记录</h1>--></div>
                    	<div class="subtit">
                        	<ul class="clearfix">
                            	<li class="time">日期</li>
                                <li class="party">订单号</li>
                                  <li class="party">类型</li>
                                  <li class="party">推荐者|微信号</li>
                                <li class="party">购买者|微信号</li>
                              <!--  <li class="party">店铺</li>-->
                                <li class="price">金额</li>
                              <!--  <li class="status">状态</li>
                                <li class="detail">查看</li>-->
                            </ul>
                        </div>
                        <div class="list clearfix">
                        	    <?php $_from = $this->_var['affiliate_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>                    	                        	
                                <ul class="clearfix">
                                
                            	<li class="time"><?php echo local_date("Y.m.d H:i:s",$this->_var['list']['time']); ?></li>
                                <li class="party"><?php echo $this->_var['list']['order_id']; ?></li>
                                 <li class="party"><?php echo $this->_var['list']['leixing']; ?></li>
                                  <li class="party">  <img width="50" height="50" src="<?php echo $this->_var['list']['twx_portrait']; ?>"  /> <?php echo $this->_var['list']['tname']; ?> | <?php echo $this->_var['list']['twx_nickname']; ?> </li>
                                <li class="party"><img width="50" height="50" src="<?php echo $this->_var['list']['bwx_portrait']; ?>"  /> <?php echo $this->_var['list']['user_name']; ?> | <?php echo $this->_var['list']['bwx_nickname']; ?></li>
                           <!--      <li class="party"><?php echo $this->_var['list']['store_name']; ?></li>-->
                              <li class="price">
                                	 <strong class="f60"><?php echo $this->_var['list']['money']; ?></strong>
                                    </li>
                      
                            </ul>
                             <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>                                                       
                                                    </div>
                    </div>
            
            <div class="pull-right" style="margin-top:2px">
					<div class="btn-group">					
						<?php echo $this->fetch('member.page.bottom.html'); ?>
					</div>
				</div>
            <div class="wrap_bottom"></div>
        </div>
            

        <div class="clear"></div>
        <div class="adorn_right1"></div>
        <div class="adorn_right2"></div>
        <div class="adorn_right3"></div>
        <div class="adorn_right4"></div>
    </div>
    <div class="clear"></div>
</div>
<?php echo $this->fetch('footer.html'); ?>