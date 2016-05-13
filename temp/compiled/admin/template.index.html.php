<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript">
</script>
<style type="text/css">
<!--
.clearfix:after{content:'20'; display:block; height:0; overflow:hidden; clear:both}
body {background: none}
.subnav li span{*top:0;}
#rightCon {list-style:none;}
#rightCon li {float:left; margin:8px; width:188px;}
#rightCon .page_item {text-align:center; width:188px; height:120px;}
#rightCon .page_item h3 {background:#eee; border:#ddd 1px solid; color:#4DA1E0; margin-bottom:3px; height:20px; line-height:20px; font-size:13px;}
#rightCon .page_item div {background:#eee; border:#ddd 1px solid; height:85px;}
#rightCon .page_item input {padding:3px 0 0 0; margin-top:50px; text-align:center}
-->
</style>
<script>
$(function(){
	$('input.preview').click(function(){
		window.open($(this).attr('url'));
	});
	$('input.edit').click(function(){
		window.location.href = REAL_BACKEND_URL + '/index.php?app=channel&act=edit&id='+$(this).attr('id');
	});
	$('input.drop').click(function(){
		if(confirm('删除后，该频道的页面文件以及频道页面的配置文件都会一起删除，您确定么？')){
			window.location.href = REAL_BACKEND_URL + '/index.php?app=channel&act=drop&id='+$(this).attr('id');
		}
	});
});
</script>

<div id="rightTop">
	<p>模板编辑</p>
  	<ul class="subnav">
    	<li><span>页面列表</span></li>
   	 	<li><a class="btn1" href="<?php echo url('app=channel&act=add'); ?>">添加页面</a></li>
  </ul>

</div>
<ul id="rightCon" class="clearfix">
    <?php $_from = $this->_var['pages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'page');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['page']):
?>
    <li>
        <div class="page_item">
            <h3><?php echo $this->_var['page']['title']; ?></h3>
            <div>
                <form action="index.php" target="_blank">
                	<input type="hidden" name="app" value="template" />
                	<input type="hidden" name="act" value="edit" />
                	<input type="hidden" name="page" value="<?php echo $this->_var['key']; ?>" />
                    <input type="submit" class="submit" value="可视化" />
                    <input type="button" class="preview" url="<?php echo $this->_var['page']['url']; ?>" value="预览" />
                    <?php $_from = $this->_var['page']['action']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'action');if (count($_from)):
    foreach ($_from AS $this->_var['action']):
?>
                	<input type="button" class="<?php echo $this->_var['action']; ?>" id="<?php echo $this->_var['key']; ?>" value="<?php echo $this->_var['lang'][$this->_var['action']]; ?>" />
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </form>
            </div>
        </div>
    </li>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</ul>
<div style="clear:both"></div>
<?php echo $this->fetch('footer.html'); ?>
