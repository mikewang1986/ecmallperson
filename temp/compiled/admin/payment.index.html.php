<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
    <p><strong>֧����ʽ����</strong></p>
</div>
<div class="tdare info">
    <table width="100%" cellspacing="0" class="dataTable">
        <?php if ($this->_var['payment']): ?>
        <tr class="tatr1">
            <td class="firstCell" width="15%">֧����ʽ����</td>
            <td>֧����ʽ����</td>
            <td width="5%">����</td>
            <td width="10%">֧�ֵĻ���</td>
            <td width="10%">����</td>
            <td width="10%" class="table-center">�汾</td>
            <td width="50" class="handler" style="width: 100px">����</td>
        </tr>
        <?php endif; ?>
        <?php $_from = $this->_var['payments']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'payment');if (count($_from)):
    foreach ($_from AS $this->_var['payment']):
?>
        <tr class="tatr2">
            <td class="firstCell"><?php echo $this->_var['payment']['name']; ?></td>
            <td><span class="padding1"><?php echo $this->_var['payment']['desc']; ?></span></td>
            <td><?php if ($this->_var['payment']['system_enabled']): ?>��<?php else: ?>��<?php endif; ?></td>
            <td><span class="padding1"><?php echo $this->_var['payment']['currency']; ?></span></td>
            <td><a href="<?php echo $this->_var['payment']['website']; ?>" target="_blank" title="��������"><?php echo $this->_var['payment']['author']; ?></a></td>
            <td class="table-center"><?php echo $this->_var['payment']['version']; ?></td>
            <td class="handler" width="50" style="width: 100px">
                <?php if (! $this->_var['payment']['system_enabled']): ?>
            <a href="index.php?app=payment&amp;act=enable&amp;code=<?php echo $this->_var['payment']['code']; ?>">����</a>
                <?php else: ?>
                <a href="javascript:if(confirm('��ȷ��Ҫ��������'))window.location='index.php?app=payment&act=disable&code=<?php echo $this->_var['payment']['code']; ?>';">����</a>
                <?php endif; ?>
                </td>
        </tr>
        <?php endforeach; else: ?>
        <tr class="no_data">
            <td colspan="7">��δ��װ�κ�֧����ʽ</td>
        </tr>
        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </table>
</div>
<?php echo $this->fetch('footer.html'); ?>
