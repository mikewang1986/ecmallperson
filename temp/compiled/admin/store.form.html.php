<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript" src="index.php?act=jslang"></script>
<script type="text/javascript">
//<!CDATA[
$(function(){
    regionInit("region");

    $("#tr_close_reason").hide();
<?php if ($_GET['act'] == "edit"): ?>
    $(":radio[name='state']").click(function(){
        if (this.value == 2)
        {
            $("#tr_close_reason").show();
        }
        else
        {
            $("#tr_close_reason").hide();
        }
    });
    $(":radio[name='state']:checked").click();
<?php endif; ?>

    $('#store_form').validate({
        errorPlacement: function(error, element){
            $(element).next('.field_notice').hide();
            $(element).after(error);
        },
        success       : function(label){
            label.addClass('right').text('OK!');
        },
        onkeyup    : false,
        rules : {
            owner_name: {
                required: true
            },
            store_name: {
                required : true,
                remote : {
                    url  : 'index.php?app=store&act=check_name',
                    type : 'get',
                    data : {
                        store_name : function(){
                            return $('#store_name').val();
                        },
                        id : '<?php echo $this->_var['store']['store_id']; ?>'
                    }
                }
            },
            end_time : {
                dateISO : true
            }
        },
        messages : {
            owner_name: {
                required: '�������������'
            },
            store_name: {
                required: '�������������',
                remote: '�õ��������Ѿ����ڣ�������һ��'
            },
            end_time : {
                dateISO : '��ʽ��2009-4-30�����ձ�ʾ����ʱ��'
            }
        }
    });
});
//]]>
</script>
<div id="rightTop">
  <p>����</p>
  <ul class="subnav">
    <li><a class="btn1" href="index.php?app=store">����</a></li>
    <?php if ($this->_var['store']['store_id']): ?>
    <li><a class="btn1" href="index.php?app=store&amp;act=test">����</a></li>
    <?php else: ?>
    <li><span>����</span></li>
    <?php endif; ?>
    <li><a class="btn1" href="index.php?app=store&amp;wait_verify=1">�����</a></li>
  </ul>
</div>
<div class="info">
  <form method="post" enctype="multipart/form-data" id="store_form">
    <table class="infoTable">
      <?php if ($_GET['act'] == "add"): ?>
      <tr>
        <th class="paddingT15">�����û���:</th>
        <td class="paddingT15 wordSpacing5"><?php echo $this->_var['user']['user_name']; ?></td>
      </tr>
      <?php endif; ?>
      <tr>
        <th class="paddingT15">��������:</th>
        <td class="paddingT15 wordSpacing5"><input class="infoTableInput2" name="owner_name" type="text" id="owner_name" value="<?php echo htmlspecialchars($this->_var['store']['owner_name']); ?>" /></td>
      </tr>
      <tr>
        <th class="paddingT15">�������֤��:</th>
        <td class="paddingT15 wordSpacing5"><input class="infoTableInput2" name="owner_card" type="text" id="owner_card" value="<?php echo htmlspecialchars($this->_var['store']['owner_card']); ?>" /></td>
      </tr>
      <tr>
        <th class="paddingT15"> ��������:</th>
        <td class="paddingT15 wordSpacing5"><input class="infoTableInput" name="store_name" type="text" id="store_name" value="<?php echo htmlspecialchars($this->_var['store']['store_name']); ?>"/>        </td>
      </tr>
      <?php if ($this->_var['enabled_subdomain']): ?>
      <tr>
        <th class="paddingT15"> ��������:</th>
        <td class="paddingT15 wordSpacing5"><input class="infoTableInput" name="domain" type="text" id="domain" value="<?php echo htmlspecialchars($this->_var['store']['domain']); ?>"/></td>
      </tr>
      <?php endif; ?>
      <tr>
        <th class="paddingT15">��������:</th>
        <td class="paddingT15 wordSpacing5" ><select name="cate_id">
          <option value="0">��ѡ��...</option>
                <?php echo $this->html_options(array('options'=>$this->_var['scategories'],'selected'=>$this->_var['scates']['0']['cate_id'])); ?>
        </select></td>
      </tr>
      <tr>
        <th class="paddingT15"> ���ڵ�:</th>
        <td class="paddingT15 wordSpacing5" ><div id="region">
            <input type="hidden" name="region_id" value="<?php echo $this->_var['store']['region_id']; ?>" class="mls_id" />
            <input type="hidden" name="region_name" value="<?php echo htmlspecialchars($this->_var['store']['region_name']); ?>" class="mls_names" />
            <?php if ($this->_var['store']['store_id']): ?>
            <span><?php echo htmlspecialchars($this->_var['store']['region_name']); ?></span>
            <input type="button" value="�༭" class="edit_region" />
            <select style="display:none">
              <option>��ѡ��...</option>
              <?php echo $this->html_options(array('options'=>$this->_var['regions'])); ?>
            </select>
            <?php else: ?>
            <select>
              <option>��ѡ��...</option>
              <?php echo $this->html_options(array('options'=>$this->_var['regions'])); ?>
            </select>
            <?php endif; ?>
          </div></td>
      </tr>
      <tr>
        <th class="paddingT15">��ϸ��ַ:</th>
        <td class="paddingT15 wordSpacing5"><input class="infoTableInput" name="address" type="text" id="address" value="<?php echo htmlspecialchars($this->_var['store']['address']); ?>"/></td>
      </tr>
      <tr>
        <th class="paddingT15">��������:</th>
        <td class="paddingT15 wordSpacing5"><input class="infoTableInput2" name="zipcode" type="text" id="zipcode" value="<?php echo htmlspecialchars($this->_var['store']['zipcode']); ?>" /></td>
      </tr>
      <tr>
        <th class="paddingT15">��ϵ�绰:</th>
        <td class="paddingT15 wordSpacing5"><input class="infoTableInput2" name="tel" type="text" id="tel" value="<?php echo htmlspecialchars($this->_var['store']['tel']); ?>" /></td>
      </tr>
      <tr>
        <th class="paddingT15"> <label for="sgrade"> �����ȼ�: </label>        </th>
        <td class="paddingT15 wordSpacing5"><select name="sgrade" id="sgrade">
          <?php echo $this->html_options(array('options'=>$this->_var['sgrades'],'selected'=>$this->_var['store']['sgrade'])); ?>
          </select>        </td>
      </tr>
      <tr>
          <th class="paddingT15">��Ч����:</th>
          <td class="paddingT15 wordSpacing5"><input class="infoTableInput2" name="end_time" type="text" id="end_time" value="<?php echo local_date("Y-m-d",$this->_var['store']['end_time']); ?>" /> <label class="field_notice">��ʽ��2009-4-30�����ձ�ʾ����ʱ��</label></td>
      </tr>
      <tr>
        <th class="paddingT15"> <label for="state">״̬:</label></th>
        <td class="paddingT15 wordSpacing5"><?php echo $this->html_radios(array('name'=>'state','options'=>$this->_var['states'],'checked'=>$this->_var['store']['state'])); ?></td>
      </tr>
      <tr id="tr_close_reason">
          <th class="paddingT15" valign="top">�ر�ԭ��:</th>
          <td class="paddingT15 wordSpacing5"><label for="close_reason"></label>
              <textarea name="close_reason" id="close_reason"></textarea></td>
      </tr>
      <tr>
        <th class="paddingT15"> ��֤:</th>
        <td class="paddingT15 wordSpacing5"><label for="autonym">
          <input name="autonym" type="checkbox" id="autonym" value="1" <?php if ($this->_var['store']['cert_autonym']): ?>checked="checked"<?php endif; ?> />
          ʵ����֤</label>
          <label for="material">
          <input type="checkbox" name="material" value="1" id="material" <?php if ($this->_var['store']['cert_material']): ?>checked="checked"<?php endif; ?> />
          ʵ�������֤</label></td>
      </tr>
      <tr>
        <th class="paddingT15">�Ƽ�:</th>
        <td class="paddingT15 wordSpacing5"><?php echo $this->html_radios(array('name'=>'recommended','options'=>$this->_var['recommended_options'],'checked'=>$this->_var['store']['recommended'])); ?></td>
      </tr>
      <tr>
        <th class="paddingT15">����:</th>
        <td class="paddingT15 wordSpacing5"><input class="sort_order" name="sort_order" type="text" id="sort_order" value="<?php echo $this->_var['store']['sort_order']; ?>" /></td>
      </tr>
      <?php if ($this->_var['store']['store_id']): ?>
      <tr>
        <th class="paddingT15">�ϴ���ͼƬ:</th>
        <td class="paddingT15 wordSpacing5">
          <?php if ($this->_var['store']['image_1']): ?><a href="<?php echo $this->_var['site_url']; ?>/<?php echo $this->_var['store']['image_1']; ?>" target="_blank">�鿴</a><?php endif; ?>
          <?php if ($this->_var['store']['image_2']): ?><a href="<?php echo $this->_var['site_url']; ?>/<?php echo $this->_var['store']['image_2']; ?>" target="_blank">�鿴</a><?php endif; ?>
          <?php if ($this->_var['store']['image_3']): ?><a href="<?php echo $this->_var['site_url']; ?>/<?php echo $this->_var['store']['image_3']; ?>" target="_blank">�鿴</a><?php endif; ?>        </td>
      </tr>
      <?php endif; ?>
      <tr>
        <th></th>
        <td class="ptb20"><input class="formbtn" type="submit" name="Submit" value="�ύ" />
          <input class="formbtn" type="reset" name="Reset" value="����" /></td>
      </tr>
    </table>
  </form>
</div>
<?php echo $this->fetch('footer.html'); ?>