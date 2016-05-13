<?php echo $this->fetch('header.html'); ?>
<link href="<?php echo $this->res_base . "/" . 'css/vip_index.css'; ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo $this->res_base . "/" . 'css/vip_integral.css'; ?>" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="<?php echo $this->res_base . "/" . 'js/focus.js'; ?>"></script>

<div class="content">

<div class="love">
    
    <div class="focus">
    <div style="display: none;">
        <p><a href="#" target="_blank" onclick="javascript:StatisticsByClick('VIP','I','大图1','',21);"><img src="<?php echo $this->res_base . "/" . 'images/1.jpg'; ?>" alt="" height="226" width="706"></a></p>

        <p class="focus_I"><a href="#" target="_blank" onclick="javascript:StatisticsByClick('VIP','I','大图1','',21);"></a></p>

        <p style="opacity: 0.5;" class="focus_C"></p>
    </div>
    <div style="display: none;">
        <p><a href="#" target="_blank" onclick="javascript:StatisticsByClick('VIP','I','大图2','',21);"><img src="<?php echo $this->res_base . "/" . 'images/2.jpg'; ?>" alt="" height="226" width="706"></a></p>

        <p class="focus_I"><a href="#" target="_blank" onclick="javascript:StatisticsByClick('VIP','I','大图2','',21);"></a></p>

        <p style="opacity: 0.5;" class="focus_C"></p>
    </div>
    <div style="display: none;">
        <p><a href="#" target="_blank" onclick="javascript:StatisticsByClick('VIP','I','大图3','',21);"><img src="<?php echo $this->res_base . "/" . 'images/3.jpg'; ?>" alt="" height="226" width="706"></a></p>

        <p class="focus_I"><a href="#" target="_blank" onclick="javascript:StatisticsByClick('VIP','I','大图3','',21);"></a></p>

        <p style="opacity: 0.5;" class="focus_C"></p>
    </div>
    <div style="display: block;">
        <p><a href="#" target="_blank" onclick="javascript:StatisticsByClick('VIP','I','大图4','',21);"><img src="<?php echo $this->res_base . "/" . 'images/4.jpg'; ?>" alt="" height="226" width="706"></a></p>

        <p class="focus_I"><a href="#" target="_blank" onclick="javascript:StatisticsByClick('VIP','I','大图4','',21);"></a></p>

        <p style="opacity: 0.5;" class="focus_C"></p>
    </div>
    <div style="display: none;">
        <p><a href="#" target="_blank" onclick="javascript:StatisticsByClick('VIP','I','大图5','',21);"><img src="<?php echo $this->res_base . "/" . 'images/5.jpg'; ?>" alt="" height="226" width="706"></a></p>

        <p class="focus_I"><a href="#" target="_blank" onclick="javascript:StatisticsByClick('VIP','I','大图5','',21);"></a></p>

        <p style="opacity: 0.5;" class="focus_C"></p>
    </div>

    
     <div style="display: none;">
        <p><a href="#" target="_blank" onclick="javascript:StatisticsByClick('VIP','I','大图6','',21);"><img src="<?php echo $this->res_base . "/" . 'images/6.jpg'; ?>" alt="" height="226" width="706"></a></p>

        <p class="focus_I"><a href="#" target="_blank" onclick="javascript:StatisticsByClick('VIP','I','大图6','',21);"></a></p>

        <p style="opacity: 0.5;" class="focus_C"></p>
    </div>
    <ul>
        <li class="">1</li>
        <li class="">2</li>
        <li class="">3</li>
        <li class="imgSelected">4</li>
        <li>5</li>
        <li>6</li>
    </ul>
</div>
<script type="text/javascript">
    $('div.focus div').eq(0).show();
    $('.focus_C').css('opacity', '0.5');
</script>
    
    
    <div class="member">
        <ul>
            <li class="member_A">
                <h3><a href="/" target="_blank">会员积分如何兑换？</a></h3>
                <p>在阿哩木微信商城获取积分，就可以兑换免费超值礼品</p>
            </li>
            <li class="member_B">
                <h3><a href="/" target="_blank">会员特权如何使用？</a></h3>
                <p>下单购买折扣商品时消耗积分，享受更多优惠</p>
            </li>
        </ul>
        <p class="member_C"><a href="<?php echo url('app=member'); ?>" target="_blank"><img src="<?php echo $this->res_base . "/" . 'images/member3.jpg'; ?>" alt="加入成为会员"></a>
        </p>
    </div>
    
</div>




	<div class="manner">
        <ul>
        <li class="showred">积分商城</li>
        	   <li class="manner_A"><a href="<?php echo url('app=integral'); ?>">全部</a></li>
			   <li><a href="<?php echo url('app=integral&to_jifen=0&from_jifen=10000'); ?>">0 - 10000分</a></li>
			   <li><a href="<?php echo url('app=integral&to_jifen=10001&from_jifen=50000'); ?>">10001 - 50000分</a></li>
        	   <li><a href="<?php echo url('app=integral&to_jifen=50000'); ?>">50001分以上</a></li>
        </ul>
	</div>
<div class="jfqing" id="prizeChoose">
	<ul>
	<?php $_from = $this->_var['index']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'integral');if (count($_from)):
    foreach ($_from AS $this->_var['integral']):
?>
		<li>
			<p class="jfqing_A"><a href="index.php?app=integral&act=view&id=<?php echo $this->_var['integral']['id']; ?>" target="_blank"><img <?php if ($this->_var['integral']['wupin_img']): ?>src="/<?php echo $this->_var['integral']['wupin_img']; ?>" alt="<?php echo $this->_var['integral']['wupin_name']; ?>"<?php else: ?>src="/data/system/default_goods_image.gif"<?php endif; ?> height="142" width="212"></a></p>
		<p class="jfqing_B"><span>奖品</span><a href="index.php?app=integral&act=view&id=<?php echo $this->_var['integral']['id']; ?>" target="_blank"><?php echo $this->_var['integral']['wupin_name']; ?></a></p>
		<p class="jfqing_E"><span>兑换价：</span><span class="jfqing_F"><?php echo ($this->_var['integral']['jifen'] == '') ? '0' : $this->_var['integral']['jifen']; ?>分</span><span class="jfqing_G">还剩<?php echo ($this->_var['integral']['shengyu'] == '') ? '0' : $this->_var['integral']['shengyu']; ?>份</span></p>
		<p><a href="index.php?app=integral&act=view&id=<?php echo $this->_var['integral']['id']; ?>" target="_blank"><img src="<?php echo $this->res_base . "/" . 'images/duihuan.jpg'; ?>" alt="立即兑换"></a></p>
	
		</li>
	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	</ul>
</div>
<br>


</div>


<?php echo $this->fetch('footer.html'); ?>