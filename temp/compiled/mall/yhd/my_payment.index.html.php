<?php echo $this->fetch('member.header.html'); ?>
<div class="content">
    <div class="totline"></div><div class="botline"></div>
    <?php echo $this->fetch('member.menu.html'); ?>
    <div id="right">
        <?php echo $this->fetch('member.submenu.html'); ?>
        <div class="wrap">
        <div class="public_index table">
            <table>
                <tr class="line_bold">
                    <th class="" colspan="6">
                    </th>
                </tr>
                <?php if ($this->_var['payments']): ?>
                <tr class="gray_new">
                    <th class="width13">����</td>
                    <th>���˵��</th>
                    <th class="width4">����</th>
                    <th class="width13">����</th>
                </tr>
                <?php endif; ?>
                <?php $_from = $this->_var['payments']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'payment');$this->_foreach['v'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['v']['total'] > 0):
    foreach ($_from AS $this->_var['payment']):
        $this->_foreach['v']['iteration']++;
?>
                <?php if (($this->_foreach['v']['iteration'] == $this->_foreach['v']['total'])): ?><tr class="line_bold"><?php else: ?><tr class="line"><?php endif; ?>
                    <td><span class="padding1"><?php echo htmlspecialchars($this->_var['payment']['name']); ?></span></td>
                    <td><?php echo $this->_var['payment']['desc']; ?></td>
                    <td class="align2"><?php if ($this->_var['payment']['enabled']): ?>��<?php else: ?>��<?php endif; ?></td>
                    <td>
                    <div class="padding1">
                     <?php if ($this->_var['payment']['installed']): ?>
                        <a href="javascript:void(0);" ectype="dialog" uri="index.php?app=my_payment&amp;act=config&payment_id=<?php echo $this->_var['payment']['payment_id']; ?>&amp;code=<?php echo $this->_var['payment']['code']; ?>" dialog_id="my_payment_config" dialog_title="����" dialog_width="600" class="add2_ico">����</a> <a href="javascript:drop_confirm('ж�غ�����ʹ�ø�֧����ʽ�Ķ������޷�֧��������ֻ�ǲ�ϣ�����û�����ѡ���֧����ʽ������ʹ�á����á�����֧����ʽ���ã���ȷ��Ҫж������', 'index.php?app=my_payment&amp;act=uninstall&payment_id=<?php echo $this->_var['payment']['payment_id']; ?>');" class="delete">ж��</a>
                    <?php else: ?>
                        <a href="javascript:void(0);" ectype="dialog" dialog_id="my_payment_install" dialog_title="��װ" uri="index.php?app=my_payment&amp;act=install&code=<?php echo $this->_var['payment']['code']; ?>" dialog_width="600" class="add1_ico">��װ</a>
                    <?php endif; ?>
                    </div>
                    </td>
                </tr>
                <?php endforeach; else: ?>
                <tr>
                    <td colspan="4" class="member_no_records">û�п��õ�֧����ʽ������ϵ����Ա���������</td>
                </tr>
                <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </table>
            <div class="wrap_bottom"></div>
        </div>
        <iframe name="my_payment" style="display:none"></iframe>
        <div class="clear"></div>
        <div class="adorn_right1"></div>
        <div class="adorn_right2"></div>
        <div class="adorn_right3"></div>
        <div class="adorn_right4"></div>
    </div>
</div>
<div class="clear"></div>
<?php echo $this->fetch('footer.html'); ?>
