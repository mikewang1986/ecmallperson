<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript">
//<!CDATA[
$(function(){
    // multi-select mall_gcategory
    $('#gcategory').length>0 && gcategoryInit("gcategory");
});
//]]>
</script>
<div id="rightTop">
  <p>��Ʒ</p>
  <ul class="subnav">
    <li><?php if ($_GET['closed']): ?><a class="btn1" href="index.php?app=goods">������Ʒ</a><?php else: ?><span>������Ʒ</span><?php endif; ?></li>
    <li><?php if ($_GET['closed']): ?><span>������Ʒ</span><?php else: ?><a class="btn1" href="index.php?app=goods&amp;closed=1">������Ʒ</a><?php endif; ?></li>
  </ul>
</div>
<div class="mrightTop1 info">
  <div class="fontl">
    <form method="get">
      <input type="hidden" name="app" value="goods" />
      <?php if ($_GET['closed']): ?>
      <input type="hidden" name="closed" value="1" />
      <?php endif; ?> ��Ʒ��:
      <input class="queryInput" type="text" name="goods_name" value="<?php echo htmlspecialchars($_GET['goods_name']); ?>" />
      ������:
      <input class="queryInput" type="text" name="store_name" value="<?php echo htmlspecialchars($_GET['store_name']); ?>" />
      Ʒ��:
      <input class="queryInput" type="text" name="brand" value="<?php echo htmlspecialchars($_GET['brand']); ?>" /><br />
      <span style="position: relative; top: 5px;">
      <div class="left">
          ������:
          <div id="gcategory" style="display:inline;">
            <input type="hidden" name="cate_id" value="0" class="mls_id" />
            <select class="querySelect">
              <option>��ѡ��...</option>
              <?php echo $this->html_options(array('options'=>$this->_var['gcategories'])); ?>
            </select>
          </div>
          <input type="submit" class="formbtn" value="��ѯ" />
      </div>
      <?php if ($_GET['cate_id'] || $this->_var['query']['goods_name'] || $this->_var['query']['store_name'] || $this->_var['query']['brand']): ?>
      <a class="left formbtn1" href="index.php?app=goods<?php if ($this->_var['query']['closed']): ?>&amp;closed=<?php echo $this->_var['query']['closed']; ?><?php endif; ?>">��������</a>
      <?php endif; ?>
      </span>
    </form>
  </div>
  <div class="fontr"><?php echo $this->fetch('page.top.html'); ?></div>
</div>
<div class="tdare">
  <table width="100%" cellspacing="0" class="dataTable">
    <?php if ($this->_var['goods_list']): ?>
    <tr class="tatr1">
      <td width="10%" class="firstCell"><input type="checkbox" class="checkall" /></td>
	  <?php if ($this->_var['enable_radar']): ?><td width="10%">��Ʒ�״�</td><?php endif; ?>
      <td width="30%"><span ectype="order_by" fieldname="goods_name">��Ʒ��</span></td>
      <td width="10%"><span ectype="order_by" fieldname="store_name">������</span></td>
      <td><span ectype="order_by" fieldname="brand">Ʒ��</span></td>
      <td><span ectype="order_by" fieldname="cate_id">������</span></td>
      <td class="table-center"><span ectype="order_by" fieldname="if_show">�ϼ�</span></td>
      <td class="table-center"><span ectype="order_by" fieldname="closed">����</span></td>
      <td><span ectype="order_by" fieldname="views">�����</span></td>
      <td>����</td>
    </tr>
    <?php endif; ?>
    <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
    <tr class="tatr2">
      <td class="firstCell"><input type="checkbox" class="checkitem" value="<?php echo $this->_var['goods']['goods_id']; ?>"/></td>
    <?php if ($this->_var['enable_radar']): ?>
    <td><span id="r<?php echo $this->_var['goods']['goods_id']; ?>"class="radar_product_point" radar_price="<?php echo $this->_var['goods']['shop_price']; ?>" radar_product_id='<?php echo $this->_var['goods']['goods_id']; ?>' radar_brand="<?php echo $this->_var['goods']['brand_name']; ?>"  radar_catname="<?php echo $this->_var['goods']['cat_name']; ?>" radar_sn="<?php echo $this->_var['goods']['goods_sn']; ?>" radar_keyword="" radar_name="<?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?>"></span></td>
    <?php endif; ?>
      <td><span ectype="inline_edit" fieldname="goods_name" fieldid="<?php echo $this->_var['goods']['goods_id']; ?>" required="1" class="editable" title="�ɱ༭"><?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?></span></td>
      <td><?php echo htmlspecialchars($this->_var['goods']['store_name']); ?></td>
      <td><?php echo htmlspecialchars($this->_var['goods']['brand']); ?></td>
      <td><?php echo nl2br($this->_var['goods']['cate_name']); ?></td>
      <td class="table-center"><?php if ($this->_var['goods']['if_show']): ?><img src="<?php echo $this->res_base . "/" . 'style/images/positive_enabled.gif'; ?>" /><?php else: ?><img src="<?php echo $this->res_base . "/" . 'style/images/positive_disabled.gif'; ?>" /><?php endif; ?></td>
      <td class="table-center"><?php if ($this->_var['goods']['closed']): ?><img src="<?php echo $this->res_base . "/" . 'style/images/negative_enabled.gif'; ?>" ectype="inline_edit" fieldname="closed" fieldid="<?php echo $this->_var['goods']['goods_id']; ?>" fieldvalue="1" title="�ɱ༭"/><?php else: ?><img src="<?php echo $this->res_base . "/" . 'style/images/negative_disabled.gif'; ?>" ectype="inline_edit" fieldname="closed" fieldid="<?php echo $this->_var['goods']['goods_id']; ?>" fieldvalue="0" title="�ɱ༭"/><?php endif; ?></td>
      <td><?php echo ($this->_var['goods']['views'] == '') ? '0' : $this->_var['goods']['views']; ?></td>
      <td><a target="_blank" href="<?php echo $this->_var['site_url']; ?>/index.php?app=goods&amp;id=<?php echo $this->_var['goods']['goods_id']; ?>">�鿴</a></td>
    </tr>
    <?php endforeach; else: ?>
    <tr class="no_data info">
      <td colspan="8">û�з��������ļ�¼</td>
    </tr>
    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
  </table>
  <?php if ($this->_var['goods_list']): ?>
  <div id="dataFuncs">
    <div id="batchAction" class="left paddingT15"> <?php if (! $_GET['closed']): ?>
      <input class="formbtn batchButton" type="button" value="�Ƽ�" name="id" uri="index.php?app=goods&act=recommend&ret_page=<?php echo $this->_var['page_info']['curr_page']; ?>" />
          &nbsp;&nbsp;<?php endif; ?>
      <input class="formbtn batchButton" type="button" value="�༭" name="id" uri="index.php?app=goods&act=edit&ret_page=<?php echo $this->_var['page_info']['curr_page']; ?>" />&nbsp;&nbsp;
      <input class="formbtn batchButton" type="button" value="ɾ��" name="id" uri="index.php?app=goods&act=drop&ret_page=<?php echo $this->_var['page_info']['curr_page']; ?>" presubmit="confirm('��ȷ��Ҫɾ������Ʒ�𣨲��ɻָ�����')" />
    </div>
    <div class="pageLinks"><?php echo $this->fetch('page.bottom.html'); ?></div>
   <?php endif; ?>
  </div>
  <div class="clear"></div>
</div>
<?php echo $this->fetch('footer.html'); ?><?php if ($this->_var['enable_radar']): ?>
<input type="hidden" id="radar_lincense_id" value="" />
<input type="hidden" id="radar_product_key" value="ecmall" />
<input type="hidden" id="radar_sign_key" value="" />
<script type="text/javascript" src="http://js.sradar.cn/radarForGoodsList.js"></script>
<script>
radar_point_extract();
</script>
<?php endif; ?>