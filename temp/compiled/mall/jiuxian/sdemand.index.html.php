<?php echo $this->fetch('header.html'); ?>
<div id="main" class="w-full">
<div id="page-sdemand" class="w mb20 mt10 clearfix">
    <div class="col-sub">
        <div class="title">信息分类</div>
		<ul class="content mb10">
			<?php $_from = $this->_var['acategories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'acategory');if (count($_from)):
    foreach ($_from AS $this->_var['acategory']):
?>
			<li><a href="<?php echo url('app=sdemand&cate_id=' . $this->_var['acategory']['cate_id']. ''); ?>"><?php echo htmlspecialchars($this->_var['acategory']['cate_name']); ?></a></li>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		</ul>
		<div class="title">最新信息</div>
		<ul class="content">
			<?php $_from = $this->_var['new_articles']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'new_article');if (count($_from)):
    foreach ($_from AS $this->_var['new_article']):
?>
			<li><a  href="<?php echo url('app=sdemand&act=view&id=' . $this->_var['new_article']['id']. ''); ?>"><?php echo htmlspecialchars($this->_var['new_article']['title']); ?></a></li>
			<?php endforeach; else: ?>
			<li>暂无新信息</li>
			<?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
		</ul>
    </div>

    <div class="col-main">
    	<?php echo $this->fetch('curlocal.html'); ?>
        <div class="sdemand-form">
			<form method="get">
				<input type="hidden" name="app" value="sdemand" />
				标题:<input class="queryInput" type="text" name="keyword" value="<?php echo htmlspecialchars($_GET['keyword']); ?>" />&nbsp;&nbsp;
 				信息类型:
				<select class="querySelect" name="type">
					<option value="">请选择...</option>
					<?php echo $this->html_options(array('options'=>$this->_var['type'],'selected'=>$_GET['type'])); ?>
				</select>
 				&nbsp;&nbsp;
				<input type="submit" class="btn" value="查询" />
				<a class="btn-fabu" href="<?php echo url('app=supply_demand&act=add'); ?>" target="_blank"><i></i>免费发布信息</a>
			</form>
		</div>
   		<div class="sdemand-list">
   			<div class="title">
				<ul class="clearfix">
                    <li class="desc">标题</li>
                    <li>价格</li>
                    <li>联系人</li>
                    <li>电话/手机</li>
                    <li>所在地区</li>
                    <li>发布时间</li>
                </ul>
             </div>
			<div class="content">  
                <?php $_from = $this->_var['infos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'info');if (count($_from)):
    foreach ($_from AS $this->_var['info']):
?>
                <ul class="clearfix">
                    <li class="desc"><a href="index.php?app=sdemand&type=<?php echo $this->_var['info']['type']; ?>" target="_blank" style="color:red"><?php if ($this->_var['info']['type'] == 1): ?>[供应]<?php else: ?>[求购]<?php endif; ?></a> <a href="<?php echo url('app=sdemand&act=view&id=' . $this->_var['info']['id']. ''); ?>" target="_blank"><?php echo sub_str(htmlspecialchars($this->_var['info']['title']),20); ?></a></li>
                    <li class="price"><?php if ($this->_var['info']['price'] != 0): ?><?php echo price_format($this->_var['info']['price']); ?><?php elseif ($this->_var['info']['price_from'] != 0 && $this->_var['info']['price_to'] != 0): ?><?php echo price_format($this->_var['info']['price_from']); ?> - <?php echo price_format($this->_var['info']['price_to']); ?><?php else: ?>面议<?php endif; ?></li>
                    <li ><?php echo $this->_var['info']['name']; ?></li>
                    <li ><?php echo $this->_var['info']['phone']; ?></li>
                    <li ><?php echo $this->_var['info']['region_name']; ?></li>
                    <li ><?php echo local_date("Y-m-d H:i",$this->_var['info']['add_time']); ?></li>
                </ul>
                <?php endforeach; else: ?>
                <div>
                  <p class="mt10">没有符合条件的记录</p>
                </div>
                <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
        	</div>
		</div>
		<?php echo $this->fetch('page.bottom.html'); ?>
    </div>
</div>
</div>
<?php echo $this->fetch('footer.html'); ?>