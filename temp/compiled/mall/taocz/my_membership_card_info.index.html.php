<?php echo $this->fetch('member.header.html'); ?>
<div class="content">
    <?php echo $this->fetch('member.menu.html'); ?>
    <div id="right"> 
        <?php echo $this->fetch('member.submenu.html'); ?>
        <div class="wrap">
            <div class="public table">
                <table id="my_category" >
                    <tr class="line_bold" >
                        <th class="width1"></th>
                        <th class="align1" colspan="7">
                            <div class="select_div">
                            <form id="my_goods_form" method="get">
                            <input type="hidden" name="app" value="my_membership_card_info">
                            <select class="select2" name="character">
                                <option value="0">-请选择-</option>
                                <?php echo $this->html_options(array('options'=>$this->_var['lang']['character_array'],'selected'=>$_GET['character'])); ?>
                            </select>
                            <input type="text" class="text_normal" name="keyword" value="<?php echo htmlspecialchars($_GET['keyword']); ?>"/>
                            <input type="submit" class="btn" value="搜索" />
                            </form>
                            </div>
                        </th>
                    </tr>
                    <tr class="gray">
                        <th class="width1"></th>
                        <th  style="width:50;text-align:center;">会员卡号</th>
                        <th  style="width:60;text-align:center;">用户名</th>
                        <th  style="width:60;text-align:center;">电话/手机</th>
                        <th  style="width:70;text-align:center;">领卡时间</th>
                        <th  style="width:30;text-align:center;">状态</th>
                        <th  style="width:50;text-align:center;">操作</th>
                    </tr>
                 <?php if ($this->_var['datas']): ?>
                <tbody id="treet1">
                <?php endif; ?>
                <?php $_from = $this->_var['datas']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'data');$this->_foreach['v'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['v']['total'] > 0):
    foreach ($_from AS $this->_var['data']):
        $this->_foreach['v']['iteration']++;
?>
                <tr class="line<?php if (($this->_foreach['v']['iteration'] == $this->_foreach['v']['total'])): ?> last_line<?php endif; ?>" ectype="table_item" idvalue="<?php echo $this->_var['data']['membership_card_info_id']; ?>">
                    <td class="align2"></td>
                    <td width="50" class="align2"><?php echo htmlspecialchars($this->_var['data']['card_num']); ?></td>
                    <td width="60" class="align2"><?php echo htmlspecialchars($this->_var['data']['user_name']); ?></td>
                    <td width="50" class="align2"><?php echo htmlspecialchars($this->_var['data']['phone']); ?></td>
                    <td width="70" class="align2"><?php echo local_date("Y-m-d H:i:s",$this->_var['data']['create_time']); ?></td>
                    <td width="30" class="align2"><?php if ($this->_var['data']['status'] == '1'): ?>正常<?php elseif ($this->_var['data']['status'] == '0'): ?><b style="color:red;">冻结</b><?php endif; ?></td>
                    <td width="50" class="padding5" >
                        <a href="index.php?app=my_membership_card_info&amp;act=edit&amp;id=<?php echo $this->_var['data']['membership_card_info_id']; ?>"  class="edit1">编辑</a>
                        <?php if ($this->_var['data']['status'] == '1'): ?>
                          <a href="javascript:drop_confirm('确认冻结', 'index.php?app=my_membership_card_info&amp;act=freeze&id=<?php echo $this->_var['data']['membership_card_info_id']; ?>');" class="freeze">冻结</a>
                          <?php elseif ($this->_var['data']['status'] == '0'): ?>
                          <a href="javascript:drop_confirm('确认解冻', 'index.php?app=my_membership_card_info&amp;act=unfreeze&id=<?php echo $this->_var['data']['membership_card_info_id']; ?>');" class="unfreeze">解冻</a>
                          
                          <?php endif; ?>
                        </td>
                </tr>
                <?php endforeach; else: ?>
                <tr>
                    <td colspan="8" class="member_no_records padding6">没有符合条件的记录</td>
                </tr>
                <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                <?php if ($this->_var['datas']): ?>
                </tbody>
                <?php endif; ?>
                <?php if ($this->_var['datas']): ?>
                <tr class="line_bold line_bold_bottom">
                    <td colspan="8">&nbsp;</td>
                </tr>
                <tr>
                    <th></td>
                    <th colspan="7"></td>
                    <p class="position2">
                           <?php echo $this->fetch('member.page.bottom.html'); ?>
                    </p>
                </tr>
                <?php endif; ?>
                </table>
            </div>
            <div class="wrap_bottom"></div>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php echo $this->fetch('footer.html'); ?>