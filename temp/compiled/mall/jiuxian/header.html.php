<?php echo $this->fetch('top.html'); ?>
<div id="header" class="w-full">
	<div class="top_above_ads w-full" area="top_above_ads" widget_type="area">
     	<?php $this->display_widgets(array('page'=>'index','area'=>'top_above_ads')); ?>
	</div>
	<div class="shop-t w clearfix pb10 mb5 mt5">
      <div class="logo mt10">
         <a href="<?php echo $this->_var['site_url']; ?>" title="<?php echo $this->_var['site_title']; ?>"><img alt="<?php echo $this->_var['site_title']; ?>" src="<?php echo $this->_var['site_logo']; ?>" /></a>
      </div>
      <div class="top-search">
      	<!--
      	 <ul class="top-search-tab clearfix">
            <li <?php if ($_GET['act'] != 'store' && $_GET['act'] != 'groupbuy'): ?>class="current"<?php endif; ?> id="index">
            	<a href="javascript:;">商品</a><b class="rc-lt"></b><b class="rc-rt"></b></li>
            <li <?php if ($_GET['act'] == 'store'): ?>class="current"<?php endif; ?> id="store">
            	<a href="javascript:;">店铺</a><b class="rc-lt"></b><b class="rc-rt"></b></li>
            <li <?php if ($_GET['act'] == 'groupbuy'): ?>class="current"<?php endif; ?> id="groupbuy">
            	<a href="javascript:;">团购</a><b class="rc-lt"></b><b class="rc-rt"></b>
            </li>
         </ul>
         -->
         <div class="top-search-box clearfix">
         	<div class="form-fields float-left">
            	<!--<b class="rc-lt"></b><b class="rc-lb"></b>-->
           		<form method="GET" action="<?php echo url('app=search'); ?>">
               		<input type="hidden" name="app" value="search" />
               		<input type="hidden" name="act" value="<?php if ($_GET['act'] == 'store'): ?>store<?php elseif ($_GET['act'] == 'groupbuy'): ?>groupbuy<?php else: ?>index<?php endif; ?>" />
               		<input type="text"   name="keyword" value="<?php echo $_GET['keyword']; ?>" class="keyword <?php if (! $_GET['keyword']): ?>kw_bj <?php if ($_GET['act'] == 'store'): ?>store<?php elseif ($_GET['act'] == 'groupbuy'): ?>groupbuy<?php else: ?>index<?php endif; ?>_bj <?php endif; ?>" />
               		<input type="submit" value="搜索" class="submit" hidefocus="true" />
            	</form>
         	</div>
         </div>
         <div class="top-search-keywords">
         	<?php $_from = $this->_var['hot_keywords']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'keyword');$this->_foreach['fe_keyword'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_keyword']['total'] > 0):
    foreach ($_from AS $this->_var['keyword']):
        $this->_foreach['fe_keyword']['iteration']++;
?>
    		<a href="<?php echo url('app=search&keyword=' . urlencode($this->_var['keyword']). ''); ?>" <?php if (($this->_foreach['fe_keyword']['iteration'] <= 1)): ?>style="color:#BB000D;border-left:0"<?php endif; ?>><?php echo $this->_var['keyword']; ?></a>
    		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
         </div>
      </div>
      <div class="top-search-ads float-right clearfix">
		<a href="<?php echo $this->_var['site_url']; ?>" target="_blank"><img  width="114"  class="lazyload" initial-url="static/images/top_ads1.jpg" /></a>
		<a href="<?php echo $this->_var['site_url']; ?>" target="_blank"><img  width="114"  class="lazyload" initial-url="static/images/top_ads2.jpg" /></a>
		<a href="<?php echo $this->_var['site_url']; ?>" target="_blank"><img  width="114"  class="lazyload" initial-url="static/images/top_ads3.jpg" /></a>
	  </div>
  	</div>
    <div class="w-full mall-nav">
    	<ul class="w clearfix">
            <li class="allcategory float-left">
            	<a href="<?php echo url('app=category'); ?>" class="allsort clearfix <?php if (! $this->_var['index']): ?>no-box-shadow<?php endif; ?>" target="_blank"><i></i><span>所有分类</span></a>
                 <?php if (! $this->_var['index']): ?>
                <div class="allcategory-list hidden">
                    <div class="content clearfix">
                        <?php $_from = $this->_var['header_gcategories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'category');$this->_foreach['fe_category'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_category']['total'] > 0):
    foreach ($_from AS $this->_var['category']):
        $this->_foreach['fe_category']['iteration']++;
?>
                        <div <?php if ($this->_foreach['fe_category']['iteration'] % 2 == 1): ?>style="background: #f1f1f1;"<?php endif; ?> class="item">
                            <div class="pborder">
								<h3 clas="clearfix"><a href="<?php echo url('app=search&cate_id=' . $this->_var['category']['id']. ''); ?>" target="_blank"><?php echo htmlspecialchars($this->_var['category']['value']); ?></a><span>></span></h3>
                    			<p>
                    				<?php $_from = $this->_var['category']['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'child');$this->_foreach['fe_child'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_child']['total'] > 0):
    foreach ($_from AS $this->_var['child']):
        $this->_foreach['fe_child']['iteration']++;
?> 
                        			<a href="index.php?app=search&cate_id=<?php echo $this->_var['child']['id']; ?>"><?php echo htmlspecialchars($this->_var['child']['value']); ?></a>
                        			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    			</p>
							</div>
                            <div class="pop" <?php if ($this->_var['category']['position']): ?> style="top:<?php echo $this->_var['category']['position']; ?>px"<?php endif; ?>>
								<div class="catlist">
									<?php $_from = $this->_var['category']['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'child');$this->_foreach['fe_child'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_child']['total'] > 0):
    foreach ($_from AS $this->_var['child']):
        $this->_foreach['fe_child']['iteration']++;
?> 
									<dl>
										<dt><a href="index.php?app=search&cate_id=<?php echo $this->_var['child']['id']; ?>"><strong><?php echo htmlspecialchars($this->_var['child']['value']); ?></strong></a></dt>
										<dd>
											<?php $_from = $this->_var['child']['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'child2');$this->_foreach['fe_child2'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_child2']['total'] > 0):
    foreach ($_from AS $this->_var['child2']):
        $this->_foreach['fe_child2']['iteration']++;
?> 
                        					<a href="index.php?app=search&cate_id=<?php echo $this->_var['child2']['id']; ?>"><?php echo htmlspecialchars($this->_var['child2']['value']); ?></a>
                       		    			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
										</dd>
									</dl> 
									<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
								</div>          
							</div>
                        </div>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </div>
                </div>
                <?php endif; ?>
            </li>
            <li class="each float-left inline-block"><a class="<?php if ($this->_var['index']): ?>current<?php endif; ?>" href="<?php echo $this->_var['site_url']; ?>">首页</a></li>
            <?php $_from = $this->_var['navs']['middle']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'nav');$this->_foreach['fe_nav'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_nav']['total'] > 0):
    foreach ($_from AS $this->_var['nav']):
        $this->_foreach['fe_nav']['iteration']++;
?>
            <li class="each float-left inline-block"><a class="<?php if (! $this->_var['index'] && $this->_var['nav']['link'] == $this->_var['current_url']): ?>current<?php endif; ?>" href="<?php echo $this->_var['nav']['link']; ?>"<?php if ($this->_var['nav']['open_new']): ?> target="_blank"<?php endif; ?>><?php echo htmlspecialchars($this->_var['nav']['title']); ?><?php if ($this->_var['nav']['hot']): ?><span class="absolute block"></span><?php endif; ?></a></li>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            
            <li class="float-right nav-ads">
                <a href=""><img src="static/images/832478ffccfd441a82dc20e97166b4c6.jpg" height="40" /></a>
            </li>
    	</ul>
    </div>
</div>