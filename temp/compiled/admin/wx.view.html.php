<?php echo $this->fetch('header.html'); ?>
<div class="main">
  <div id="rightTop">
  <p>会员管理</p>
  <ul class="subnav">
    <li><span>管理</span></li>
    	<li><a class="btn1" href="index.php?app=user&amp;act=weixin">微信会员</a></li>
    <li><a class="btn1" href="index.php?app=user&amp;act=add">新增</a></li>
  </ul>
</div>



	<div class="mrightTop">
	  <div class="fontl">
		<form method="get" name="search_form">
		   <div class="left">
           <input type="hidden" name="wxid" value="<?php echo $this->_var['id']; ?>" />
			  <input type="hidden" name="app" value="user" />
			  <input type="hidden" name="act" value="view" />
			  <select class="querySelect" name="field_name"><?php echo $this->html_options(array('options'=>$this->_var['query_fields'],'selected'=>$_GET['field_name'])); ?>
			  </select>
			  <input class="queryInput" type="text" name="field_value" value="<?php echo htmlspecialchars($_GET['field_value']); ?>" />
			  
			   <a href="JavaScript:void(0);" class="btn-search" onclick="document.search_form.submit()">查询</a>
		  </div>
		  <?php if ($this->_var['filtered']): ?>
		  <a class="left formbtn1" href="index.php?app=user&weixin">撤销检索</a>
		  <?php endif; ?>
		</form>
	  </div>
	  <div class="fontr"><?php echo $this->fetch('page.top.html'); ?></div>
	</div>
	<div class="tdare">
	  <table width="100%" cellspacing="0" class="dataTable">
		<?php if ($this->_var['wxmessage_list']): ?>
		<tr class="tatr1">
		  <td width="20" class="firstCell"><input type="checkbox" class="checkall" /></td>
		  <td>微信号</td>
		
	 <td>时间</td>
         <td>内容</td>
         
       

		  <td>操作</td>
		</tr>
		<?php endif; ?>
		<?php $_from = $this->_var['wxmessage_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'user');if (count($_from)):
    foreach ($_from AS $this->_var['user']):
?>
		<tr class="tatr2">
		  <td class="firstCell"><input type="checkbox" class="checkitem" value="<?php echo $this->_var['user']['id']; ?>" /></td>
		  <td> 
          <?php if ($this->_var['user']['w_message']): ?>
          
          平台公众号
          <?php else: ?>
          <?php echo htmlspecialchars($this->_var['wxinfo']['nickname']); ?>
          
          
          
          <?php endif; ?>
           </td>
	
         <td>
     <?php echo local_date("Y.m.d H:i:s",$this->_var['user']['dateline']); ?>
         </td>
    
        

        <td>
        
       
        <?php echo htmlspecialchars($this->_var['user']['message']); ?>
        
          <?php echo htmlspecialchars($this->_var['user']['w_message']); ?>
        </td>
        
     
   
		
	      <td><a href="index.php?app=user&act=wxdrop&id=<?php echo $this->_var['user']['id']; ?>" > 删除</a> </td>


		
		</tr>
		<?php endforeach; else: ?>
		<tr class="no_data">
		  <td colspan="10">没有符合条件的记录</td>
		</tr>
		<?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
	  </table>
	  <?php if ($this->_var['wxmessage_list']): ?>
	  <div id="dataFuncs">
		<div id="batchAction" class="left paddingT15"> &nbsp;&nbsp;
			<a href="javaScript:void(0);" class="formbtn batchButton" name="id" uri="index.php?app=user&act=wxdrop" presubmit="confirm('您确定要删除么？')"><span>删除</span></a>
		</div>
		<div class="pageLinks"><?php echo $this->fetch('page.bottom.html'); ?></div>
		<div class="clear"></div>
	  </div>
	  <?php endif; ?>
	</div>
</div>
<?php echo $this->fetch('footer.html'); ?>