<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
  <p>���̵ȼ�</p>
  <ul class="subnav">
    <li><span>����</span></li>
    <li><a class="btn1" href="index.php?app=sgrade&amp;act=add">����</a></li>
  </ul>
</div>
<div class="mrightTop">
  <div class="fontl">
    <form method="get">
      <div class="left">
          <input type="hidden" name="app" value="sgrade" />
          <input type="hidden" name="act" value="index" />
          �ȼ�����:
          <input class="queryInput" type="text" name="grade_name" value="<?php echo htmlspecialchars($_GET['grade_name']); ?>" />
          <input type="submit" class="formbtn" value="��ѯ" />
      </div>
      <?php if ($this->_var['filtered']): ?>
      <a class="left formbtn1" href="index.php?app=sgrade">��������</a>
      <?php endif; ?>
    </form>
  </div>
  <div class="fontr"><?php echo $this->fetch('page.top.html'); ?></div>
</div>
<div class="tdare">
  <table width="100%" cellspacing="0" class="dataTable">
    <?php if ($this->_var['sgrades']): ?>
    <tr class="tatr1">
      <td width="20" class="firstCell"><input type="checkbox" class="checkall" /></td>
      <td>�ȼ�����</td>
      <td>��������Ʒ��</td>
      <td>�ϴ��ռ��С(MB)</td>
      <td>��ѡģ������</td>
      <td>�շѱ�׼</td>
      <td class="table-center">��Ҫ���</td>
      <td class="handler" style="width: 250px">����</td>
    </tr>
    <?php endif; ?>
    <?php $_from = $this->_var['sgrades']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'sgrade');if (count($_from)):
    foreach ($_from AS $this->_var['sgrade']):
?>
    <tr class="tatr2">
      <td class="firstCell"><?php if ($this->_var['sgrade']['grade_id'] != 1): ?><input type="checkbox" class="checkitem" value="<?php echo $this->_var['sgrade']['grade_id']; ?>" /><?php endif; ?></td>
      <td><?php echo htmlspecialchars($this->_var['sgrade']['grade_name']); ?></td>
      <td><?php echo $this->_var['sgrade']['goods_limit']; ?></td>
      <td><?php echo $this->_var['sgrade']['space_limit']; ?></td>
      <td><?php echo $this->_var['sgrade']['skin_limit']; ?></td>
      <td><?php echo $this->_var['sgrade']['charge']; ?></td>
      <td class="table-center"><?php if ($this->_var['sgrade']['need_confirm']): ?>��<?php else: ?>��<?php endif; ?></td>
      <td class="handler" style="width: 250px">
      <span style="width: 230px">
      <a href="index.php?app=sgrade&amp;act=edit&amp;id=<?php echo $this->_var['sgrade']['grade_id']; ?>">�༭</a> | <?php if ($this->_var['sgrade']['grade_id'] == 1): ?>Ĭ�ϵȼ�����ɾ��<?php else: ?><a href="javascript:drop_confirm('��ȷ��Ҫɾ���õ��̵ȼ���ɾ���õ��̵ȼ��µ����е��̻��Զ���ΪĬ�ϵȼ�', 'index.php?app=sgrade&amp;act=drop&amp;id=<?php echo $this->_var['sgrade']['grade_id']; ?>');">ɾ��</a><?php endif; ?> | <a href="index.php?app=sgrade&amp;act=set_skins&amp;id=<?php echo $this->_var['sgrade']['grade_id']; ?>">���ÿ�ѡģ��</a>
      </span>
      </td>
    </tr>
    <?php endforeach; else: ?>
    <tr class="no_data">
      <td colspan="10">û�з��������ļ�¼</td>
    </tr>
    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
  </table>
  <?php if ($this->_var['sgrade']): ?>
  <div id="dataFuncs">
    <div id="batchAction" class="left paddingT15"> &nbsp;&nbsp;
      <input class="formbtn batchButton" type="button" value="ɾ��" name="id" uri="index.php?app=sgrade&act=drop" presubmit="confirm('��ȷ��Ҫɾ���õ��̵ȼ���ɾ���õ��̵ȼ��µ����е��̻��Զ���ΪĬ�ϵȼ�');" />
    </div>
    <div class="pageLinks"><?php echo $this->fetch('page.bottom.html'); ?></div>
  </div>
  <div class="clear"></div>
  <?php endif; ?>
</div>
<?php echo $this->fetch('footer.html'); ?> 