<?php echo $this->fetch('member.header.html'); ?>
<div class="content">
    <?php echo $this->fetch('member.menu.html'); ?>
    <div id="right">
        <?php echo $this->fetch('member.submenu.html'); ?>
        <script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'jquery.plugins/jquery.validate.js'; ?>" charset="<?php echo $this->_var['charset']; ?>"></script>
        <div class="wrap">
            <div class="eject_btn"><b class="ico5" ectype="dialog" uri="index.php?app=my_shipping&amp;act=add" ectype="dialog" dialog_id="my_shipping_add" dialog_width="600" dialog_title="�������ͷ�ʽ">�������ͷ�ʽ</b></div>
            <div class="public table">
            <table class="table_head_line">
                <?php if ($this->_var['shippings']): ?>
                <tr class="line_bold">
                    <th class="" colspan="6">
                    </th>
                </tr>
                
                <tr class="gray">
                    <th class="width13">����</th>
                    <th>���</th>
                    <th class="width4">�׼��ʷ�</th>
                    <th class="width4">�����ʷ�</th>
                    <th class="width4">����</th>
                    <th class="width13">����</th>
                </tr>
                <?php endif; ?>
                <?php $_from = $this->_var['shippings']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'shipping');$this->_foreach['v'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['v']['total'] > 0):
    foreach ($_from AS $this->_var['shipping']):
        $this->_foreach['v']['iteration']++;
?>
                <tr <?php if (($this->_foreach['v']['iteration'] == $this->_foreach['v']['total'])): ?>class="line_bold"<?php else: ?>class="line"<?php endif; ?>>
                    <td><span class="padding1"><?php echo htmlspecialchars($this->_var['shipping']['shipping_name']); ?></span></td>
                    <td><?php echo htmlspecialchars($this->_var['shipping']['shipping_desc']); ?></td>
                    <td class="align2"><?php echo $this->_var['shipping']['first_price']; ?></td>
                    <td class="align2"><?php echo $this->_var['shipping']['step_price']; ?></td>
                    <td class="align2"><?php if ($this->_var['shipping']['enabled']): ?>��<?php else: ?>��<?php endif; ?></td>
                    <td>
                        <div class="padding1">
                            <a href="javascript:void(0);" uri="index.php?app=my_shipping&amp;act=edit&shipping_id=<?php echo $this->_var['shipping']['shipping_id']; ?>" ectype="dialog" dialog_id="my_shipping_edit" dialog_width="600" dialog_title="�༭" class="edit1">�༭</a><a href="javascript:drop_confirm('��ȷ��Ҫɾ������', 'index.php?app=my_shipping&amp;act=drop&shipping_id=<?php echo $this->_var['shipping']['shipping_id']; ?>');" class="delete">ɾ��</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; else: ?>
                <tr>
                    <td colspan="6" class="member_no_records padding6">��û��������ͷ�ʽ</td>
                </tr>
                <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                <iframe name="my_shipping" style="display:none" ></iframe>
            </table>
        </div>
    </div>
</div>
<div class="clear"></div>
<?php echo $this->fetch('footer.html'); ?>
