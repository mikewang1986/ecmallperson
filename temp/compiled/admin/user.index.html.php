<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
  <p>��Ա����</p>
  <ul class="subnav">
    <li><span>����</span></li>
    <li><a class="btn1" href="index.php?app=user&amp;act=add">����</a></li>
  </ul>
</div>

<div class="mrightTop">
  <div class="fontl">
    <form method="get">
       <div class="left">
          <input type="hidden" name="app" value="user" />
          <input type="hidden" name="act" value="index" />
          <select class="querySelect" name="field_name"><?php echo $this->html_options(array('options'=>$this->_var['query_fields'],'selected'=>$_GET['field_name'])); ?>
          </select>
          <input class="queryInput" type="text" name="field_value" value="<?php echo htmlspecialchars($_GET['field_value']); ?>" />
          ����:
          <select class="querySelect" name="sort"><?php echo $this->html_options(array('options'=>$this->_var['sort_options'],'selected'=>$_GET['sort'])); ?>
          </select>
          <input type="submit" class="formbtn" value="��ѯ" />
      </div>
      <?php if ($this->_var['filtered']): ?>
      <a class="left formbtn1" href="index.php?app=user">��������</a>
      <?php endif; ?>
    </form>
  </div>
  <div class="fontr"><?php echo $this->fetch('page.top.html'); ?></div>
</div>
<div class="tdare">
  <table width="100%" cellspacing="0" class="dataTable">
    <?php if ($this->_var['users']): ?>
    <tr class="tatr1">
      <td width="20" class="firstCell"><input type="checkbox" class="checkall" /></td>
      <td>��Ա�� | ��ʵ����</td>
      <td><span ectype="order_by" fieldname="email">��������</span></td>
      <td>��ʱͨѶ</td>
      <td><span ectype="order_by" fieldname="reg_time">ע��ʱ��</span></td>
      <td><span ectype="order_by" fieldname="last_login">����¼</span></td>
      <td><span ectype="order_by" fieldname="logins">��¼����</span></td>
      <td>�Ƿ��ǹ���Ա</td>
      <td class="handler">����</td>
    </tr>
    <?php endif; ?>
    <?php $_from = $this->_var['users']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'user');if (count($_from)):
    foreach ($_from AS $this->_var['user']):
?>
    <tr class="tatr2">
      <td class="firstCell"><input type="checkbox" class="checkitem" value="<?php echo $this->_var['user']['user_id']; ?>" /></td>
      <td><?php echo htmlspecialchars($this->_var['user']['user_name']); ?> | <?php echo htmlspecialchars($this->_var['user']['real_name']); ?></td>
      <td><?php echo htmlspecialchars($this->_var['user']['email']); ?></td>
      <td> <?php if ($this->_var['user']['im_qq']): ?>QQ: <?php echo htmlspecialchars($this->_var['user']['im_qq']); ?><br />
        <?php endif; ?>
        <?php if ($this->_var['user']['im_msn']): ?>MSN: <?php echo htmlspecialchars($this->_var['user']['im_msn']); ?><br />
        <?php endif; ?></td>
      <td><?php echo local_date("Y-m-d",$this->_var['user']['reg_time']); ?></td>
      <td><?php if ($this->_var['user']['last_login']): ?><?php echo local_date("Y-m-d",$this->_var['user']['last_login']); ?><?php endif; ?><br />
        <?php echo $this->_var['user']['last_ip']; ?></td>
      <td><?php echo $this->_var['user']['logins']; ?></td>
      <td><?php if ($this->_var['user']['if_admin']): ?>  ��
      <?php else: ?><a href="index.php?app=admin&amp;act=add&amp;id=<?php echo $this->_var['user']['user_id']; ?>" onclick="parent.openItem('admin_manage', 'user');">��Ϊ����Ա</a><?php endif; ?>
      </td>
      <td class="handler">
      <span style="width: 100px">
      <a href="index.php?app=user&amp;act=edit&amp;id=<?php echo $this->_var['user']['user_id']; ?>">�༭</a> | <a href="javascript:drop_confirm('��ȷ��Ҫɾ�����𣿸ò�������ɾ��ucenter����������Ӧ���е��û�', 'index.php?app=user&amp;act=drop&amp;id=<?php echo $this->_var['user']['user_id']; ?>');">ɾ��</a>
        <?php if ($this->_var['user']['store_id']): ?>
        | <a href="index.php?app=store&amp;act=edit&amp;id=<?php echo $this->_var['user']['store_id']; ?>" onclick="parent.openItem('store_manage', 'store');">����</a>
        <?php endif; ?>
      </span>
      </td>
    </tr>
    <?php endforeach; else: ?>
    <tr class="no_data">
      <td colspan="10">û�з��������ļ�¼</td>
    </tr>
    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
  </table>
  <?php if ($this->_var['users']): ?>
  <div id="dataFuncs">
    <div id="batchAction" class="left paddingT15"> &nbsp;&nbsp;
      <input class="formbtn batchButton" type="button" value="ɾ��" name="id" uri="index.php?app=user&act=drop" presubmit="confirm('��ȷ��Ҫɾ�����𣿸ò�������ɾ��ucenter����������Ӧ���е��û�');" />
    </div>
    <div class="pageLinks"><?php echo $this->fetch('page.bottom.html'); ?></div>
    <div class="clear"></div>
  </div>
  <?php endif; ?>
</div>
<?php echo $this->fetch('footer.html'); ?>