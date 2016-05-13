<?php echo $this->fetch('header.html'); ?>
<style>
body {
	font: 12px/1.5 tahoma,arial,宋体,sans-serif;
}
</style>
<header style="position: relative;z-index: 999;width: 100%;display: block;">
	<nav style="background-color: #E22;position: relative;height: 45px;display: block;">
		<h1 style="text-align: center;line-height: 46px;font-weight: 600;margin: 0px;color: #FFF;font-size: 16px;">店铺分类</h1>
	</nav>
	<a href="javascript:history.back(-1)" style="background-image: url('/themes/wapmall/vchuang_cn/styles/default/images/index.png');background-size: 25px 20px;position: absolute;top: 0px;left: 10px;bottom: 0px;width: 2rem;overflow: hidden;
color: transparent;background-repeat: no-repeat;background-position: 50% 50%;">返回</a>
</header>

<?php $_from = $this->_var['scategorys']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'scategory');if (count($_from)):
    foreach ($_from AS $this->_var['scategory']):
?>
<div class="radius" style="min-width: 300px;
height: 100%;
width: 100%;
background: none repeat scroll 0% 0% #F4F4F4;
padding: 0px;
margin: 0px;">
    <h3 style="clear: both;
width: 100%;
background: none repeat scroll 0% 0% #F4F4F4;
line-height: 50px;"><a href='<?php echo url('app=search&act=store&cate_id=' . $this->_var['scategory']['id']. ''); ?>' style="font-size: 16px;
color: #666;
text-decoration: none;float: left;font: 16px/1.231 arial;
line-height: 50px;
margin-left: 4px;
text-indent: 10px;width: 100%;
border-bottom: 1px solid #D7D7D8;
border-top: 1px solid #FAFAFA;"><?php echo htmlspecialchars($this->_var['scategory']['value']); ?></a></h3>
    <?php $_from = $this->_var['scategory']['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'child');if (count($_from)):
    foreach ($_from AS $this->_var['child']):
?>
    <a href='<?php echo url('app=search&act=store&cate_id=' . $this->_var['child']['id']. ''); ?>' style="display: inline-table;width: 30%;padding: 10px 0;text-align: center;color: #546280;font-size: .75em;"><?php echo htmlspecialchars($this->_var['child']['value']); ?></a> 
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</div>
<?php endforeach; else: ?>
<div class="radius">
    暂无分类
</div>
<?php endif; unset($_from); ?><?php $this->pop_vars();; ?>

</div>
<?php echo $this->fetch('footer.html'); ?>
