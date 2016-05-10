<?php echo $this->fetch('header.html'); ?>
<?php echo $this->fetch('curlocal.html'); ?>
<script type="text/javascript">
//<!CDATA[
$(function (){
    var order = '<?php echo $_GET['order']; ?>';
    var arrow = '';

    switch (order){
        case 'credit_value desc' : order = '';
        arrow = '↓';
        break;
        default : order = 'credit_value desc';
    }
    $('#credit_grade').html('信用度' + arrow);
    $('#credit_grade').click(function(){query('order', order);return false;});
	$("#show_scategory").click(function(){
        $("dl[ectype='dl_scategory'] dd").show();
		$("dl[ectype='dl_scategory']").show();
        //$(this).hide();
		$("#show_scategory").hide();
		$("#hide_scategory").show();
    });
	$("#hide_scategory").click(function(){document.location.reload()});
  }
);
function query(name, value){
    $("input[name='"+name+"']").val(value);
    $('#search').submit();
}

//]]>
</script>



<div id="main-store">
   <div class="scatalog">
        <?php $_from = $this->_var['scategorys']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'scategory');$this->_foreach['fe_scategory'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_scategory']['total'] > 0):
    foreach ($_from AS $this->_var['scategory']):
        $this->_foreach['fe_scategory']['iteration']++;
?>
        <dl ectype="dl_scategory" <?php if ($this->_foreach['fe_scategory']['iteration'] >= 5): ?> style="display:none"<?php endif; ?>>
            <dt><a href="<?php echo url('app=search&act=store&cate_id=' . $this->_var['scategory']['id']. ''); ?>"><?php echo htmlspecialchars($this->_var['scategory']['value']); ?></a></dt>
            <?php $_from = $this->_var['scategory']['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'child');$this->_foreach['fe_child'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_child']['total'] > 0):
    foreach ($_from AS $this->_var['child']):
        $this->_foreach['fe_child']['iteration']++;
?>
            <?php if ($this->_foreach['fe_child']['iteration'] <= 2): ?>
            <dd><a href="<?php echo url('app=search&act=store&cate_id=' . $this->_var['child']['id']. ''); ?>"><?php echo htmlspecialchars($this->_var['child']['value']); ?></a></dd>
            <?php else: ?>
            <dd style="display:none"><a href="<?php echo url('app=search&act=store&cate_id=' . $this->_var['child']['id']. ''); ?>"><?php echo htmlspecialchars($this->_var['child']['value']); ?></a></dd>
            <?php endif; ?>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
       </dl>
       <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
       <div class="clr"></div>
       <div class="smore"><div class="smore2" id="show_scategory">显示更多</div><div class="smore2" id="hide_scategory" style="display:none">收起</div></div>
   </div>
   <div class="s-conditions">
   <form id="search" method="GET" action="index.php">
       <input type="hidden" name="order" value="<?php echo htmlspecialchars($_GET['order']); ?>"/>
       <input type="hidden" name="app" value="search"/>
       <input type="hidden" name="act" value="store"/>
       <input type="hidden" name="cate_id" value="<?php echo htmlspecialchars($_GET['cate_id']); ?>"/>店铺名称：
       <input type="text" name="keyword" value="<?php echo htmlspecialchars($this->_var['query']['keyword']); ?>" class="keyword" />店主：
       <input type="text" name="user_name" value="<?php echo htmlspecialchars($this->_var['query']['user_name']); ?>" />所在地：
       <select id="region_id" name="region_id" class="display_select">
            <option value="">所在地</option>
            <?php echo $this->html_options(array('options'=>$this->_var['regions'],'selected'=>$this->_var['query']['region_id'])); ?>
       </select>
       <input class="btn-searchstore" type="submit" name="Submit" value="搜索" />
   </form>
   </div>
   <div class="bar"><?php echo $this->fetch('page.top.html'); ?></div>
   <?php $_from = $this->_var['stores']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'store');if (count($_from)):
    foreach ($_from AS $this->_var['store']):
?>
   <div class="each">
      <div class="store-info">
         <div class="store-name"><b></b><a href="<?php echo url('app=store&id=' . $this->_var['store']['store_id']. ''); ?>"><?php echo htmlspecialchars($this->_var['store']['store_name']); ?></a></div>
         <div class="goods-amount">商&nbsp;品&nbsp;数：<font color="#CC6600"><b><?php echo $this->_var['store']['goods_count']; ?></b></font> 件</div>
         <div class="store-credit">信用度：<?php echo $this->_var['store']['credit_value']; ?>
            <?php if ($this->_var['store']['credit_value'] >= 0): ?><img src="<?php echo $this->_var['store']['credit_image']; ?>" alt="" align="absmiddle" /><?php endif; ?>
         </div>
         <div class="store-add_time">创店时间：<?php echo local_date("Y-m-d",$this->_var['store']['add_time']); ?></div>
         <div class="store-owner">店主：<?php echo htmlspecialchars($this->_var['store']['user_name']); ?>&nbsp;<a target="_blank" class="email" href="<?php echo $this->_var['site_url']; ?>/index.php?app=message&amp;act=send&amp;to_id=<?php echo $this->_var['store']['user_id']; ?>"><img src="<?php echo $this->res_base . "/" . 'images/web_mail.gif'; ?>" alt="发站内信" align="absmiddle" /></a></div>
         <div class="store-region">所在地：<?php echo htmlspecialchars($this->_var['store']['region_name']); ?></div>
         <a class="store-enter" href="<?php echo url('app=store&id=' . $this->_var['store']['store_id']. ''); ?>" hidefocus="true"></a>
         
         
      </div>
      <div class="store-goods">        
         <?php $_from = $this->_var['store']['regoods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
         <dl class="each">
            <dt><a href="<?php echo url('app=goods&id=' . $this->_var['item']['goods_id']. ''); ?>"><img src="<?php echo $this->_var['item']['default_image']; ?>" width="160" height="160" /></a></dt>
            <dd class="price"><?php echo $this->_var['item']['price']; ?></dd>
            <dd><a href="<?php echo url('app=goods&id=' . $this->_var['item']['goods_id']. ''); ?>"><?php echo $this->_var['item']['goods_name']; ?></a></dd>
         </dl>
         <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
         <div class="clr"></div>
      </div>
      <div class="clr"></div>
   </div>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
   <div class="page-bottom"><?php echo $this->fetch('page.bottom.html'); ?></div>
   <div class="clr"></div>
</div>

<?php echo $this->fetch('footer.html'); ?>