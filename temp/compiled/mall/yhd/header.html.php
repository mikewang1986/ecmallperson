<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo $this->_var['site_url']; ?>/" />

<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7 charset=<?php echo $this->_var['charset']; ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $this->_var['charset']; ?>" />
<?php echo $this->_var['page_seo']; ?>

<meta name="author" content="ecmall.shopex.cn" />
<meta name="generator" content="ECMall <?php echo $this->_var['ecmall_version']; ?>" />
<meta name="copyright" content="ShopEx Inc. All Rights Reserved" />
<link href="<?php echo $this->res_base . "/" . 'css/ecmall.css'; ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="index.php?act=jslang"></script>
<script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'jquery.js'; ?>" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'ecmall.js'; ?>" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo $this->res_base . "/" . 'js/nav.js'; ?>" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo $this->res_base . "/" . 'js/select.js'; ?>" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo $this->res_base . "/" . 'js/scroll.js'; ?>" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo $this->res_base . "/" . 'js/main.js'; ?>" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo $this->res_base . "/" . 'js/jquery.cycle.all.min.js'; ?>" charset="utf-8"></script>
<!--[if lte IE 6]>
<script type="text/javascript" language="Javascript" src="<?php echo $this->res_base . "/" . 'js/hoverForIE6.js'; ?>" charset="utf-8"></script>
<![endif]-->
<script type="text/javascript">
//<!CDATA[
var SITE_URL = "<?php echo $this->_var['site_url']; ?>";
var PRICE_FORMAT = '<?php echo $this->_var['price_format']; ?>';

$(function(){
    var select_list = document.getElementById("select_list");
    var float_list = document.getElementById("float_list");
    select_list.onmouseover = function () {
        float_list.style.display = "block";
    };
    select_list.onmouseout = function () {
        float_list.style.display = "none";
    };
});
//]]>
</script>

<?php echo $this->_var['_head_tags']; ?>
<!--<editmode></editmode>-->
</head>

<body>
<div id="head">
	<div id="top">
		<div class="menu">
        	<p class="link1">
            	����,<?php echo htmlspecialchars($this->_var['visitor']['user_name']); ?>  ��ӭ����<?php echo $this->_var['site_title']; ?>��
            	<?php if (! $this->_var['visitor']['user_id']): ?>
            	<a href="<?php echo url('app=member&act=login&ret_url=' . $this->_var['ret_url']. ''); ?>" style="color:#0066CC">���¼</a> | <a href="<?php echo url('app=member&act=register&ret_url=' . $this->_var['ret_url']. ''); ?>" style="color:#0066CC">���ע��</a>
            	<?php else: ?>
            	<a href="<?php echo url('app=member&act=logout'); ?>" style="color:#0066CC">�˳�</a>
            	<?php endif; ?>
        	</p>
        	<ul class="subnav">
            <li id="select_list">
                <a class="z_index" href="<?php echo url('app=member'); ?>">�û�����</a>
                <ul id="float_list">
                    <div class="adorn1"></div>
                    <div class="adorn2"></div>
                    <?php if ($this->_var['visitor']['store_id']): ?>
                    <li><a href="<?php echo url('app=my_goods'); ?>">��Ʒ����</a></li>
                    <li><a href="<?php echo url('app=seller_order'); ?>">��������</a></li>
                    <li><a href="<?php echo url('app=my_qa'); ?>">��ѯ����</a></li>
                    <?php else: ?>
                    <li><a href="<?php echo url('app=buyer_order'); ?>">�ҵĶ���</a></li>
                    <li><a href="<?php echo url('app=buyer_groupbuy'); ?>">�ҵ��Ź�</a></li>
                    <li><a href="<?php echo url('app=my_question'); ?>">�ҵ���ѯ</a></li>
                    <?php endif; ?>
                </ul>
            </li>
            <li class="line"><a href="<?php echo url('app=message&act=newpm'); ?>">վ����Ϣ<?php if ($this->_var['new_message']): ?>(<?php echo $this->_var['new_message']; ?>)<?php endif; ?></a></li>
            <li class="line"><a href="<?php echo url('app=article&code=' . $this->_var['acc_help']. ''); ?>">��������</a></li>
            <?php $_from = $this->_var['navs']['header']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'nav');if (count($_from)):
    foreach ($_from AS $this->_var['nav']):
?>
            <li class="line"><a href="<?php echo $this->_var['nav']['link']; ?>"<?php if ($this->_var['nav']['open_new']): ?> target="_blank"<?php endif; ?>><?php echo htmlspecialchars($this->_var['nav']['title']); ?></a></li>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </ul>
    	</div>
	</div>
    <div id="nav">
		<h1 title="<?php echo $this->_var['site_title']; ?>"><a href="index.php"><img alt="<?php echo $this->_var['site_title']; ?>" src="<?php echo $this->_var['site_logo']; ?>" /></a></h1>
		<ul>
    		<li><a class="<?php if ($this->_var['index']): ?>link<?php else: ?>hover<?php endif; ?>" href="index.php">��ҳ</a></li>
    		<?php $_from = $this->_var['navs']['middle']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'nav');if (count($_from)):
    foreach ($_from AS $this->_var['nav']):
?>
    		<li><a class="<?php if (! $this->_var['index'] && $this->_var['nav']['link'] == $this->_var['current_url']): ?>link<?php else: ?>hover<?php endif; ?>" href="<?php echo $this->_var['nav']['link']; ?>"<?php if ($this->_var['nav']['open_new']): ?> target="_blank"<?php endif; ?>><?php echo htmlspecialchars($this->_var['nav']['title']); ?></a></li>
    		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		</ul>
    </div>
    <div class="search">
    	<div class="wrap">
        	<form method="GET" action="<?php echo url('app=search'); ?>">
                	<div class="select_js">
                    	<p>������Ʒ</p>
                    	<div class="ico"></div>
                    	<ul>
                        	<li ectype="index">������Ʒ</li>
                        	<li ectype="store">��������</li>
                        	<li ectype="groupbuy">�����Ź�</li>
                    	</ul>
                    	<input type="hidden" name="act" value="index" />
                	</div>
                    <div class="input">
                		<input type="text" name="keyword" class="text2"  style="_width:250px;" />
                    </div>
            	<input type="hidden" name="app" value="search" />
            	<input type="submit" name="Submit" value="����" class="btn" />
        	</form>
    	</div>
    	<div class="nav">
        	<div class="nav1"></div>
        	<div class="nav2"></div>
        	<a href="<?php echo url('app=cart'); ?>" class="buy">���ﳵ <strong id="cart_goods_kinds"><?php echo $this->_var['cart_goods_kinds']; ?></strong> ����Ʒ</a>
        	<a href="<?php echo url('app=my_favorite'); ?>" class="buyline">�ղؼ�</a>
        	<a href="<?php echo url('app=buyer_order'); ?>" class="buyline">�ҵĶ���</a>
    	</div>
        <div class="hotword">    		
    		<?php $_from = $this->_var['hot_keywords']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'keyword');if (count($_from)):
    foreach ($_from AS $this->_var['keyword']):
?>
    		<a href="<?php echo url('app=search&keyword=' . $this->_var['keyword']. ''); ?>"><?php echo $this->_var['keyword']; ?></a>
    		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		</div>
	</div>
</div>


