<?php echo $this->fetch('member.header.html'); ?>
<style>
.borline td {padding:10px 0px;}
.ware_list th {text-align:left;}
</style>
<script type="text/javascript">

$(function(){
    $('#profile_form').validate({
        errorPlacement: function(error, element){
            $(element).parent('span').parent('b').after(error);
        },
        rules : {
            portrait : {
                accept   : 'gif|jpe?g|png'
            }
        },
        messages : {
            portrait  : {
                accept   : 'avatar'
            }
        }
    });
    $('input[ectype="change_avatar"]').change(function(){

        var src = getFullPath($(this)[0]);
        $('img[ectype="avatar"]').attr('src', src);
        $('input[ectype="change_avatar"]').removeAttr('name');
        $(this).attr('name', 'portrait');
    });
});
</script>
<div class="content">
    <?php echo $this->fetch('member.menu.html'); ?>
    <div id="right">
            <?php echo $this->fetch('member.submenu.html'); ?>
            
            
            <div class="wrap">
          <div class="public table">
                		
			<div class="user_search">
      
                <br />
                        
  

 
                </div>
                <table>
                    <?php if ($this->_var['users']): ?>

                    <tr class="line tr_bgcolor">
                        
                        <th>会员名 | 微信号 </th>
                        <th align="center">电子邮箱</th>
                        <th>手机号码</th>
                       <!-- <th>注册时间</th>-->
					<!--	<th>最后登录</th>
						<th>登录次数</th>-->
						
						<!--<th>操作</th>-->
                        
                    </tr>
                    <?php endif; ?>
                    <?php $_from = $this->_var['users']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'user');$this->_foreach['v'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['v']['total'] > 0):
    foreach ($_from AS $this->_var['user']):
        $this->_foreach['v']['iteration']++;
?>
                    	<?php if (($this->_foreach['v']['iteration'] == $this->_foreach['v']['total'])): ?><tr class="line_bold"><?php else: ?><tr class="line"><?php endif; ?>
                        
                        <td align="center"><img  width="60" height="60" src="<?php echo $this->_var['user']['portrait']; ?>"  /> <?php echo htmlspecialchars($this->_var['user']['user_name']); ?> | <?php echo htmlspecialchars($this->_var['user']['nickname']); ?> </td>
                        <td align="center"><?php echo htmlspecialchars($this->_var['user']['email']); ?></td>
                        <td align="center"> <?php echo $this->_var['user']['phone_mob']; ?><br />
       </td>
						<!--<td align="center"><?php echo local_date("Y-m-d",$this->_var['user']['reg_time']); ?></td>-->
				
				<!--		<td align="center"><a href="<?php echo $this->_var['site_url']; ?>/index.php?app=default&amp;act=back_login&amp;id=<?php echo $this->_var['user']['user_id']; ?>&amp;key=<?php echo $this->_var['user']['login_key']; ?>" >登陆</a> | <a target="_blank" href="<?php echo url('app=buyer_order&id=' . $this->_var['user']['user_id']. ''); ?>">查看订单</a></td>-->
                    </tr>
                    <?php endforeach; else: ?>
                    <tr>
                        <td colspan="5" class="member_no_records padding6"><?php echo $this->_var['lang'][$_GET['act']]; ?>没有符合条件的记录</td>
                    </tr>
                    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </table>
            </div>
           
			<div id="dataFuncs">
        <div class="pageLinks">
           <?php if ($this->_var['users']): ?>
		   <?php echo $this->fetch('page.bottom.html'); ?>
		   <?php endif; ?>
        </div>
    </div>
	 <div class="wrap_bottom"></div>
    <div class="clear"></div>
        </div>

            <div class="clear"></div>
            <div class="adorn_right1"></div>
            <div class="adorn_right2"></div>
            <div class="adorn_right3"></div>
            <div class="adorn_right4"></div>
        </div>
        <div class="clear"></div>
    </div>
</div>
<?php echo $this->fetch('footer.html'); ?>
