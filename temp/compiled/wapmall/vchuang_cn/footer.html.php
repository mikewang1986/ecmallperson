
<div style="height:80px; width:100%; float:left;"></div>
<link href="<?php echo $this->res_base . "/" . 'css/global_nav.css?v'; ?>" type="text/css" rel="stylesheet"/>

<div class="global-nav global-nav--current">
    <div class="global-nav__nav-wrap">
        <div class="global-nav__nav-item">
            <a href="<?php echo url('app=default'); ?>" class="global-nav__nav-link">
                <i class="global-nav__iconfont global-nav__icon-index">&#xf0001;</i>
                <span class="global-nav__nav-tit">首页</span>
            </a>
        </div>
        <div class="global-nav__nav-item">
            <a href="<?php echo url('app=category'); ?>" class="global-nav__nav-link">
                <i class="global-nav__iconfont global-nav__icon-category">&#xf0002;</i>
                <span class="global-nav__nav-tit">分类</span>
            </a>
        </div>
        <div class="global-nav__nav-item">
            <a href="<?php echo url('app=article'); ?>" id="get_search_box"  class="global-nav__nav-link get_search_box">
                <i class="global-nav__iconfont global-nav__icon-search">&#xf0003;</i>
                <span class="global-nav__nav-tit">资讯</span>
            </a>
        </div>
        <div class="global-nav__nav-item">
            <a href="<?php echo url('app=cart'); ?>" class="global-nav__nav-link">
                <i class="global-nav__iconfont global-nav__icon-shop-cart">&#xf0004;</i>
                <span class="global-nav__nav-tit">购物车</span>
                <span class="global-nav__nav-shop-cart-num" id="carId"><?php echo $this->_var['cart_goods_kinds']; ?></span>
            </a>
        </div>
        <div class="global-nav__nav-item">
            <a href="<?php echo url('app=member'); ?>" class="global-nav__nav-link">
                <i class="global-nav__iconfont global-nav__icon-my-yhd">&#xf0005;</i>
                <span class="global-nav__nav-tit">个人中心</span>
            </a>
        </div>
    </div>
  
</div>

 
<nav id="menu" style="display:None">
  <ul> <?php $_from = $this->_var['gcates']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'category');$this->_foreach['fe_category'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_category']['total'] > 0):
    foreach ($_from AS $this->_var['category']):
        $this->_foreach['fe_category']['iteration']++;
?>
      
        <li> <a href="<?php echo url('app=search&cate_id=' . $this->_var['category']['id']. ''); ?>"> <?php echo htmlspecialchars($this->_var['category']['value']); ?> </a>
     
    </li>
       <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      </ul>
</nav>





<script type="text/javascript" src="<?php echo $this->res_base . "/" . 'js/jquery.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo $this->res_base . "/" . 'js/jquery.mmenu.js'; ?>"></script>
<script type="text/javascript" src="<?php echo $this->res_base . "/" . 'js/ectouch.js'; ?>"></script>

<script type="text/javascript">
window.onload = function(){
  $('#menu').css('display','');
}
$(function() {
	$('nav#menu').mmenu();


});
</script>
<style>
#menu {background: none repeat scroll 0% 0% #CCC; position: fixed; top: 0px; right: -276px; height: 100%;  padding-top: 2.3rem; box-sizing: border-box; padding: 20px 1rem;}
#mm-m0-p0 {height: 100%; padding-bottom: 1000rem; background: none repeat scroll 0% 0% #333;}
</style>
</body>
</html>