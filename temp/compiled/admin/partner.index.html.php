<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
    <p>�������</p>
    <ul class="subnav">
        <li><span>����</span></li>
        <li><a class="btn1" href="index.php?app=partner&amp;act=add">����</a></li>
    </ul>
</div>
<div class="mrightTop">
    <div class="fontl">
        <form method="get">
            <div class="left">
                <input type="hidden" name="app" value="partner" />
                <input type="hidden" name="act" value="index" />
                ����:
                <input class="queryInput" type="text" name="title" value="<?php echo htmlspecialchars($this->_var['query']['title']); ?>" />
                <input type="submit" class="formbtn" value="��ѯ" />
            </div>
            <?php if ($this->_var['filtered']): ?>
            <a class="left formbtn1" href="index.php?app=partner">��������</a>
            <?php endif; ?>
        </form>
    </div>
    <div class="fontr">
        <?php echo $this->fetch('page.top.html'); ?>
    </div>
</div>
<div class="tdare">
    <table width="100%" cellspacing="0" class="dataTable">
        <?php if ($this->_var['partners']): ?>
        <tr class="tatr1">
            <td width="20" class="firstCell"><input type="checkbox" class="checkall" /></td>
            <td>����</td>
            <td>����</td>
            <td class="table-center">ͼƬ��ʶ</td>
            <td class="table-center">����</td>
            <td class="handler">����</td>
        </tr>
        <?php endif; ?>
        <?php $_from = $this->_var['partners']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'partner');if (count($_from)):
    foreach ($_from AS $this->_var['partner']):
?>
        <tr class="tatr2">
            <td class="firstCell"><input type="checkbox" class="checkitem" value="<?php echo $this->_var['partner']['partner_id']; ?>" /></td>
            <td><?php echo $this->_var['partner']['title']; ?></td>
            <td><?php echo $this->_var['partner']['link']; ?></td>
            <td class="table-center"><?php if ($this->_var['partner']['logo']): ?><img src="<?php echo $this->_var['partner']['logo']; ?>" height="30"/><?php endif; ?></td>
            <td class="table-center"><span ectype="inline_edit" fieldname="sort_order" fieldid="<?php echo $this->_var['partner']['partner_id']; ?>" datatype="pint" maxvalue="255" class="editable" title="�ɱ༭"><?php echo $this->_var['partner']['sort_order']; ?></span></td>
            <td class="handler">
            <a href="index.php?app=partner&amp;act=edit&amp;id=<?php echo $this->_var['partner']['partner_id']; ?>">�༭</a>
                |
                <a href="javascript:drop_confirm('��ȷ��Ҫɾ������', 'index.php?app=partner&amp;act=drop&amp;id=<?php echo $this->_var['partner']['partner_id']; ?>');">ɾ��</a>
            </td>
        </tr>
        <?php endforeach; else: ?>
        <tr class="no_data">
            <td colspan="6">û�з��������ļ�¼</td>
        </tr>
        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </table>
    <?php if ($this->_var['partners']): ?>
    <div id="dataFuncs">
        <div id="batchAction" class="left paddingT15">&nbsp;&nbsp;
            <input class="formbtn batchButton" type="button" value="ɾ��" name="id" uri="index.php?app=partner&act=drop" presubmit="confirm('��ȷ��Ҫɾ������');" />
            &nbsp;&nbsp;
           <!-- <input class="formbtn batchButton" type="button" value="lang.update_order" name="id" presubmit="updateOrder(this);" />-->
        </div>
        <div class="pageLinks">
            <?php echo $this->fetch('page.bottom.html'); ?>
        </div>
        <div class="clear"></div>
    </div>
    <?php endif; ?>
</div>
<?php echo $this->fetch('footer.html'); ?>
