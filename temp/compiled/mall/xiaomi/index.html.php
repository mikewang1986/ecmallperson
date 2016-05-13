<?php echo $this->fetch('header_index.html'); ?>


<div class="main">

	<div  class="banner" id="bann" area="col-1-banner" widget_type="area">
        <?php $this->display_widgets(array('page'=>'index','area'=>'col-1-banner')); ?>
    </div>
    
    <div class="kucont">
        <div class="mode">
            <div class="left">
                <div id="tab">
	                            <ul class="tab_menu">
    	                            <li class="selected" style="border-right:1px solid #EEE;">新产品</li>
                                    <li>周销量</li>
                                </ul>
                                <div class="clearfix h0"></div>
                                <div class="tab_box">
    	                          <div class="tab_box_n">
									  <?php $_from = $this->_var['hot_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'hgoods');if (count($_from)):
    foreach ($_from AS $this->_var['hgoods']):
?>
										<li><img src="<?php echo $this->_var['hgoods']['default_image']; ?>" width="80" height="80" /><a href="<?php echo url('app=goods&id=' . $this->_var['hgoods']['goods_id']. ''); ?>"><p><?php echo sub_str(htmlspecialchars($this->_var['hgoods']['goods_name']),50); ?></p><em><?php echo price_format($this->_var['hgoods']['price']); ?></em></a></li>
									  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                   </div>
                                   <div class="hide tab_box_n">
									   <?php $_from = $this->_var['new_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'ngoods');if (count($_from)):
    foreach ($_from AS $this->_var['ngoods']):
?>
										<li><img src="<?php echo $this->_var['ngoods']['default_image']; ?>" width="80" height="80" /><a href="<?php echo url('app=goods&id=' . $this->_var['ngoods']['goods_id']. ''); ?>"><p><?php echo sub_str(htmlspecialchars($this->_var['ngoods']['goods_name']),50); ?></p><em><?php echo price_format($this->_var['ngoods']['price']); ?></em></a></li>
									   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                   </div>
                                 </div>
                              </div>
<script type="text/javascript">
$(document).ready(function(){
	var $tab_li = $('#tab ul li');
	$tab_li.hover(function(){
		$(this).addClass('selected').siblings().removeClass('selected');
		var index = $tab_li.index(this);
		$('div.tab_box > div').eq(index).show().siblings().hide();
	});	
});
</script>
            </div>
            
        <div class="right" area="col-2-elastic" widget_type="area">
            <?php $this->display_widgets(array('page'=>'index','area'=>'col-2-elastic')); ?>
        </div>

     </div>
            

            <div class="clearfix h0"></div>
        </div>


    <div class="kucont" >
	    <div class="f0">
            <div class="title">
                <h3>今日特价</h3>                
            </div>
            <div class="clearfix h0"></div>
             <div class="list" area="col-tejia" widget_type="area">
               
             <?php $this->display_widgets(array('page'=>'index','area'=>'col-tejia')); ?>

               <div class="clearfix h0"></div>
            </div>
        </div>
    </div>


    
    <div class="kucont" >
	    <div class="f1">
            <div class="title">
                <h3>1F 手机</h3>
                <div class="hot"><a href="#">热销手机</a></div>
            </div>
            <div class="clearfix h0"></div>
             <div class="list" area="col-3-floor" widget_type="area">
               
             <?php $this->display_widgets(array('page'=>'index','area'=>'col-3-floor')); ?>

               <div class="clearfix h0"></div>
            </div>
        </div>
    </div>
    
    <div class="kucont">
    <div class="banner2" area="col-4-ad" widget_type="area"><?php $this->display_widgets(array('page'=>'index','area'=>'col-4-ad')); ?></div>
    </div>
    
    <div class="kucont">
        <div class="f2">
            <div class="title">
                <h3>2F 配件/存储</h3>
                <div class="hot"><a href="">热销配件/存储</a></div>
            </div>
            <div class="clearfix h0"></div>
            <div class="list" area="col-5-floor2" widget_type="area">
                <?php $this->display_widgets(array('page'=>'index','area'=>'col-5-floor2')); ?>
                <div class="clearfix h0"></div>
            </div>
        </div>
    </div>

</div>

<?php echo $this->fetch('server.html'); ?>
<?php echo $this->fetch('footer.html'); ?>