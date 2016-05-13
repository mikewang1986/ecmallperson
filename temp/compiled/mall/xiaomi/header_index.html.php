<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo $this->_var['site_url']; ?>/" />

<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7 charset=<?php echo $this->_var['charset']; ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $this->_var['charset']; ?>" />
<?php echo $this->_var['page_seo']; ?>
<meta name="copyright" content="vchuang_Vmall3.0(xiaomi). All Rights Reserved" />
<link href="/themes/mall/xiaomi/css/kucss.css" rel="stylesheet" type="text/css">
<script src="/includes/libraries/javascript/jquery.js" type="text/javascript" /></script>
<script type="text/javascript">
//<!CDATA[
var SITE_URL = "<?php echo $this->_var['site_url']; ?>";
var REAL_SITE_URL = "<?php echo $this->_var['real_site_url']; ?>";
var PRICE_FORMAT = '<?php echo $this->_var['price_format']; ?>';
//]]>
</script>

<?php echo $this->_var['_head_tags']; ?>
<!--<editmode></editmode>-->
</head>

<body>

<div class="header">
    <div class="topad"><a href="#"><img src="/themes/mall/xiaomi/images/topad.jpg"></a></div>

    <div class="topnav">
        <div class="kucont">
            <div class="top-left">
                <span>您好</span>
				<?php if (! $this->_var['visitor']['user_id']): ?>
				<a href="<?php echo url('app=member&act=login&ret_url=' . $this->_var['ret_url']. ''); ?>">[ 登录 ]</a>
				<a href="<?php echo url('app=member&act=register&ret_url=' . $this->_var['ret_url']. ''); ?>">[ 注册 ]</a>
                <a href="<?php echo url('app=qqconnect&act=login'); ?>"><img style="vertical-align:middle" src="<?php echo $this->res_base . "/" . 'images/login_qq_top.png'; ?>" /></a>
				<?php else: ?>
				<a href="<?php echo url('app=member'); ?>"><?php echo htmlspecialchars($this->_var['visitor']['user_name']); ?></a>
				<a href="<?php echo url('app=member&act=logout'); ?>">退出</a>
				<a href="<?php echo url('app=message&act=newpm'); ?>">站内消息<?php if ($this->_var['new_message']): ?>(<span><?php echo $this->_var['new_message']; ?></span>)<?php endif; ?></a>
				<?php endif; ?>

				<?php if ($this->_var['ustore']): ?>
				<a href="<?php echo url('app=search&cate_id=6'); ?>">采购中心</a>
				<?php endif; ?>
            </div>
            <div class="top-right">
                <a href="<?php echo url('app=buyer_admin'); ?>">用户中心</a><a href="<?php echo url('app=buyer_order'); ?>">我的订单</a><a href="<?php echo url('app=article&code=help'); ?>">帮助中心</a><a  onclick="javascript:addFavorite2()" style="cursor:pointer;">加入收藏</a>
            </div>
            <div class="clearfix h0"></div>
        </div>
    </div>
    <div class="head">
        <div class="kucont">
            <h1 class="logo">
			    <a href="/"><img alt="<?php echo $this->_var['site_title']; ?>" src="<?php echo $this->_var['site_logo']; ?>" /></a>
		    </h1>
            <div class="search">
                <form action="<?php echo url('app=search'); ?>" method="get">  
				<input type="hidden" name="app" value="search" />
				<input type="hidden" name="act" value="<?php if ($_GET['act'] == 'store'): ?>store<?php elseif ($_GET['act'] == 'groupbuy'): ?>groupbuy<?php else: ?>index<?php endif; ?>" />
				<input type="text"   name="keyword"  placeholder="<?php $_from = $this->_var['hot_keywords']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'keyword');$this->_foreach['fe_keyword'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_keyword']['total'] > 0):
    foreach ($_from AS $this->_var['keyword']):
        $this->_foreach['fe_keyword']['iteration']++;
?><?php echo $this->_var['keyword']; ?><?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>" class="sinput <?php if (! $_GET['keyword']): ?>kw_bj <?php if ($_GET['act'] == 'store'): ?>store<?php elseif ($_GET['act'] == 'groupbuy'): ?>groupbuy<?php else: ?>index<?php endif; ?>_bj <?php endif; ?>" onfocus="if(placeholder=='<?php $_from = $this->_var['hot_keywords']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'keyword');$this->_foreach['fe_keyword'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_keyword']['total'] > 0):
    foreach ($_from AS $this->_var['keyword']):
        $this->_foreach['fe_keyword']['iteration']++;
?><?php echo $this->_var['keyword']; ?><?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>') {placeholder=''}" onblur="if (placeholder=='') {placeholder='<?php $_from = $this->_var['hot_keywords']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'keyword');$this->_foreach['fe_keyword'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_keyword']['total'] > 0):
    foreach ($_from AS $this->_var['keyword']):
        $this->_foreach['fe_keyword']['iteration']++;
?><?php echo $this->_var['keyword']; ?><?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>'}" x-webkit-speech/>
				<input type="submit" value="" class="sbtn" hidefocus="true" />

                </form> 


            </div>
            <div class="clearfix h0"></div>
        </div>
    </div>
    <div class="nav">
        <div class="kucont"><h1><a href="/"><img src="/themes/mall/xiaomi/images/menu.jpg" /></a></h1>
            <div class="nav-menu">
                <ul>
                   <?php $_from = $this->_var['navs']['middle']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'nav');if (count($_from)):
    foreach ($_from AS $this->_var['nav']):
?>
                    <li <?php if (! $this->_var['index'] && $this->_var['nav']['link'] == $this->_var['current_url']): ?>class="current"<?php endif; ?>><a href="<?php echo $this->_var['nav']['link']; ?>" <?php if ($this->_var['nav']['open_new']): ?> target="_blank"<?php endif; ?>><?php echo htmlspecialchars($this->_var['nav']['title']); ?><?php if ($this->_var['nav']['hot'] == 1): ?><span class="absolute block"></span><?php endif; ?></a></li>
                   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </ul>
            </div>
            <div class="cart">
                <a href="<?php echo url('app=cart'); ?>"><span>购物车有<?php echo $this->_var['cart_goods_kinds']; ?>件</span></a>
            </div>
            <div class="clearfix h0"></div>
        </div>
    </div>
</div>

            <div class="list-menu"> 
                <ul id="cardlist">
				<?php $_from = $this->_var['header_gcategories']['gcategories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'category');$this->_foreach['fe_category'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_category']['total'] > 0):
    foreach ($_from AS $this->_var['category']):
        $this->_foreach['fe_category']['iteration']++;
?>
                    <li>
                    <h3><i><img src="/themes/mall/xiaomi/images/m<?php echo $this->_foreach['fe_category']['iteration']; ?>.png" width="20" height="20" /></i><a href="<?php echo url('app=search&cate_id=' . $this->_var['category']['id']. ''); ?>" target="_blank"><?php echo htmlspecialchars($this->_var['category']['value']); ?></a></h3>
					<?php $_from = $this->_var['category']['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'child');$this->_foreach['fe_child'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_child']['total'] > 0):
    foreach ($_from AS $this->_var['child']):
        $this->_foreach['fe_child']['iteration']++;
?>
						<a href="<?php echo url('app=search&cate_id=' . $this->_var['child']['id']. ''); ?>" target="_blank"><?php echo htmlspecialchars($this->_var['child']['value']); ?></a>
					<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </li>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </ul>
            </div>

			<div class="list-menu-child">  
				<?php $_from = $this->_var['header_gcategories']['gcategories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'category');$this->_foreach['fe_category'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_category']['total'] > 0):
    foreach ($_from AS $this->_var['category']):
        $this->_foreach['fe_category']['iteration']++;
?>
                    <ul class="box" >
					    <h3><a href="<?php echo url('app=search&cate_id=' . $this->_var['category']['id']. ''); ?>" target="_blank"><?php echo htmlspecialchars($this->_var['category']['value']); ?></a></h3>
					    <?php $_from = $this->_var['category']['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'child');$this->_foreach['fe_child'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_child']['total'] > 0):
    foreach ($_from AS $this->_var['child']):
        $this->_foreach['fe_child']['iteration']++;
?>
						<li><a href="<?php echo url('app=search&cate_id=' . $this->_var['child']['id']. ''); ?>" target="_blank"><?php echo htmlspecialchars($this->_var['child']['value']); ?></a></li>
					    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </ul>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </div>

<style>
.list-menu-child {display: block;position: absolute;z-index: 999;width: 240px;left: 50%;margin-left: -356px;}
.list-menu-child .box{display:none;background: #fff;border: 1px solid #dfdfdf;height:420px;}
.list-menu-child .box li{float:left;margin:2px 4px;}
.list-menu-child .box h3{border-bottom:2px solid #ddd;line-height:35px;}
</style>

		<script type="text/javascript">

		$(document).ready(function(){
				   $("#cardlist li").each(function(index){
		$(this).mouseover(function(){
			//清除没有访问过的层，同时计算当前的相对位置，实现等位置平移效果
			$("ul.box").css({display:"none"});
			var height = index * 50+"px";
		//显示具体内容效果
		  $("ul.box").eq(index).addClass("show showcontent").css({display:"block",top:height});
		$(this).addClass("hover");
		}).mouseleave(function(){
		   //关闭所有的层效果
		   $("ul.box").eq(index).css({display:"none"});
		   $(this).removeClass("hover"); 
		}); 
				 });
		$(".box").hover(function(){
			 //获取当前选中的状态的时候让其处于显示状态
				 $('.box').eq($('.box').index($(this))).addClass("show showcontent").css({display:"block"});
		 //同时添加背景效果
				 $(".box li").eq($('.box').index($(this))).addClass("hover");},function(){
		 //移除当前效果，同时隐藏内容层
					 $(".box li").removeClass("hover");
					 $('ul.box').css({display:"none"});
		}); 
		});
</script>

