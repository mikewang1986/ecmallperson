<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'ajax_tree.js'; ?>" charset="utf-8"></script>
<div id="rightTop">
    <p>��Ʒ����</p>
    <ul class="subnav">
        <li><span>����</span></li>
        <li><a class="btn1" href="index.php?app=gcategory&amp;act=add">����</a></li>
        <li><a class="btn1" href="index.php?app=gcategory&amp;act=export">����</a></li>
        <li><a class="btn1" href="index.php?app=gcategory&amp;act=import">����</a></li>
    </ul>
</div>

<div class="info2">
    <table  class="distinction">
        <?php if ($this->_var['gcategories']): ?>
        <thead>
        <tr class="tatr1">
            <td class="w30"><input id="checkall_1" type="checkbox" class="checkall" /></td>
            <td width="50%"><span class="all_checkbox"><label for="checkall_1">ȫѡ</label></span>��������</td>
            <td>����</td>
            <td>��ʾ</td>
            <td class="handler">����</td>
        </tr>
        </thead>
        <?php endif; ?>
        <?php if ($this->_var['gcategories']): ?><tbody id="treet1"><?php endif; ?>
        <?php $_from = $this->_var['gcategories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'gcategory');if (count($_from)):
    foreach ($_from AS $this->_var['gcategory']):
?>
        <tr>
            <td class="align_center w30"><input type="checkbox" class="checkitem" value="<?php echo $this->_var['gcategory']['cate_id']; ?>" /></td>
            <td class="node" width="50%"><?php if ($this->_var['gcategory']['switchs']): ?><img src="templates/style/images/treetable/tv-expandable.gif" ectype="flex" status="open" fieldid="<?php echo $this->_var['gcategory']['cate_id']; ?>"><?php else: ?><img src="templates/style/images/treetable/tv-item.gif"><?php endif; ?><span class="node_name editable" ectype="inline_edit" fieldname="cate_name" fieldid="<?php echo $this->_var['gcategory']['cate_id']; ?>" required="1" title="�ɱ༭"><?php echo htmlspecialchars($this->_var['gcategory']['cate_name']); ?></span></td>
            <td class="align_center"><span class="editable" ectype="inline_edit" fieldname="sort_order" fieldid="<?php echo $this->_var['gcategory']['cate_id']; ?>" datatype="number" title="�ɱ༭"><?php echo $this->_var['gcategory']['sort_order']; ?></span></td>
            <td class="align_center"><?php if ($this->_var['gcategory']['if_show']): ?><img src="templates/style/images/positive_enabled.gif" ectype="inline_edit" fieldname="if_show" fieldid="<?php echo $this->_var['gcategory']['cate_id']; ?>" fieldvalue="1" title="�ɱ༭"/><?php else: ?><img src="templates/style/images/positive_disabled.gif" ectype="inline_edit" fieldname="if_show" fieldid="<?php echo $this->_var['gcategory']['cate_id']; ?>" fieldvalue="0" title="�ɱ༭"/><?php endif; ?></td>
            <td class="handler"><span><a href="index.php?app=gcategory&amp;act=edit&amp;id=<?php echo $this->_var['gcategory']['cate_id']; ?>">�༭</a>
                |
                <a href="javascript:if(confirm('ɾ���÷��ཫ��ͬʱɾ���÷���������¼����࣬��ȷ��Ҫɾ����'))window.location = 'index.php?app=gcategory&amp;act=drop&amp;id=<?php echo $this->_var['gcategory']['cate_id']; ?>';">ɾ��</a><?php if ($this->_var['region']['layer'] < $this->_var['max_layer']): ?> | <a href="index.php?app=gcategory&amp;act=add&amp;pid=<?php echo $this->_var['gcategory']['cate_id']; ?>">�����¼�</a><?php endif; ?>
                </span>
                </td>
        </tr>
        <?php endforeach; else: ?>
        <tr class="no_data">
            <td colspan="5">������Ʒ����</td>
        </tr>
        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
        <?php if ($this->_var['gcategories']): ?></tbody><?php endif; ?>
        <tfoot>
            <tr class="tr_pt10">
            <?php if ($this->_var['gcategory']): ?>
                <td class="align_center"><label for="checkall1"><input id="checkall_2" type="checkbox" class="checkall"></label></td>
                <td colspan="4" id="batchAction">
                    <span class="all_checkbox"><label for="checkall_2">ȫѡ</label></span>&nbsp;&nbsp;
                    <input class="formbtn batchButton" type="button" value="ɾ��" name="id" uri="index.php?app=gcategory&act=drop" presubmit="confirm('ɾ���÷��ཫ��ͬʱɾ���÷���������¼����࣬��ȷ��Ҫɾ����');" />
                    <input class="formbtn batchButton" type="button" value="�༭" name="id" uri="index.php?app=gcategory&act=batch_edit" />
                    <!--<input class="formbtn batchButton" type="button" value="lang.update_order" name="id" presubmit="updateOrder(this);" />-->
                </td>
            <?php endif; ?>
            </tr>
        </tfoot>
    </table>
</div>

<?php echo $this->fetch('footer.html'); ?>