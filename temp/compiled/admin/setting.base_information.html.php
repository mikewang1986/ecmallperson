<?php echo $this->fetch('header.html'); ?>

<script type="text/javascript">
//<!CDATA[
$(function(){
    $(".show_image").mouseover(function(){
        $(this).next("div").show();
    });
    $(".show_image").mouseout(function(){
        $(this).next("div").hide();
    });
});
//]]>
</script>

<div id="rightTop">
  <p>��վ����</p>
  <ul class="subnav">
    <li><a class="btn1" href="index.php?app=setting&amp;act=base_setting">ϵͳ����</a></li>
    <li><span>������Ϣ</span></li>
    <li><a class="btn1" href="index.php?app=setting&amp;act=email_setting">Email</a></li>
    <li><a class="btn1" href="index.php?app=setting&amp;act=captcha_setting">��֤��</a></li>
    <li><a class="btn1" href="index.php?app=setting&amp;act=store_setting">��������</a></li>
    <li><a class="btn1" href="index.php?app=setting&amp;act=credit_setting">��������</a></li>
    <li><a class="btn1" href="index.php?app=setting&amp;act=subdomain_setting">��������</a></li>
  </ul>
</div>
<div class="info">
  <form method="post" enctype="multipart/form-data">
    <table class="infoTable">
      <tr>
        <th class="paddingT15"> <label for="site_name">��վ����:</label></th>
        <td class="paddingT15 wordSpacing5"><input id="site_name" type="text" name="site_name" value="<?php echo $this->_var['setting']['site_name']; ?>" class="infoTableInput"/>        </td>
      </tr>
      <tr>
        <th class="paddingT15"> <label for="site_title">��վ����:</label></th>
        <td class="paddingT15 wordSpacing5"><input id="site_title" type="text" name="site_title" value="<?php echo $this->_var['setting']['site_title']; ?>" class="infoTableInput"/>        </td>
      </tr>
      <tr>
        <th class="paddingT15" valign="top"> <label for="site_description">��վ����:</label></th>
        <td class="paddingT15 wordSpacing5"><textarea name="site_description" id="site_description"><?php echo $this->_var['setting']['site_description']; ?></textarea>        </td>
      </tr>
      <tr>
        <th class="paddingT15">��վ�ؼ���:</th>
        <td class="paddingT15 wordSpacing5"><input id="site_keywords" type="text" name="site_keywords" value="<?php echo $this->_var['setting']['site_keywords']; ?>" class="infoTableInput"/></td>
      </tr>
<!--      <tr>
        <th class="paddingT15"> <label for="copyright">��Ȩ��Ϣ:</label></th>
        <td class="paddingT15 wordSpacing5"><input id="copyright" type="text" name="copyright" value="<?php echo $this->_var['setting']['copyright']; ?>" class="infoTableInput"/>        </td>
      </tr> -->
      <tr>
        <th class="paddingT15"> <label for="site_logo">��վLogo:</label></th>
        <td class="paddingT15 wordSpacing5"><input class="infoTableFile" id="site_logo" type="file" name="site_logo" />
          <?php if ($this->_var['setting']['site_logo']): ?>
          <img class="show_image" src="<?php echo $this->res_base . "/" . 'style/images/right.gif'; ?>" />
          <div style="position:absolute; display:none"><img src="<?php echo $this->_var['site_url']; ?>/<?php echo $this->_var['setting']['site_logo']; ?>?<?php echo $this->_var['random_number']; ?>" /></div>
          <?php endif; ?></td>
      </tr>
      <tr>
        <th class="paddingT15"> <label for="icp_number">ICP֤���:</label></th>
        <td class="paddingT15 wordSpacing5"><input id="icp_number" type="text" name="icp_number" value="<?php echo $this->_var['setting']['icp_number']; ?>" class="infoTableInput"/>        </td>
      </tr>
<!--      <tr>
        <th class="paddingT15"> <label for="site_region">��վ���ڵ�:</label></th>
        <td class="paddingT15 wordSpacing5"><input id="site_region" type="text" name="site_region" value="<?php echo $this->_var['setting']['site_region']; ?>" class="infoTableInput"/>        </td>
      </tr>
      <tr>
        <th class="paddingT15"> <label for="site_address">��վ��ϸ��ַ:</label></th>
        <td class="paddingT15 wordSpacing5"><input id="site_address" type="text" name="site_address" value="<?php echo $this->_var['setting']['site_address']; ?>" class="infoTableInput"/>        </td>
      </tr>
      <tr>
        <th class="paddingT15"> <label for="site_postcode">�ʱ�:</label></th>
        <td class="paddingT15 wordSpacing5"><input id="site_postcode" type="text" name="site_postcode" value="<?php echo $this->_var['setting']['site_postcode']; ?>" class="infoTableInput"/>        </td>
      </tr>
      <tr>
        <th class="paddingT15"> <label for="site_phone_tel">�绰:</label></th>
        <td class="paddingT15 wordSpacing5"><input id="site_phone_tel" type="text" name="site_phone_tel" value="<?php echo $this->_var['setting']['site_phone_tel']; ?>" class="infoTableInput"/>        </td>
      </tr>
      <tr>
        <th class="paddingT15"> <label for="site_email">Email:</label></th>
        <td class="paddingT15 wordSpacing5"><input id="site_email" type="text" name="site_email" value="<?php echo $this->_var['setting']['site_email']; ?>" class="infoTableInput"/>        </td>
      </tr>-->
      <tr>
        <th class="paddingT15">��վ״̬:</th>
        <td class="paddingT15"><input id="site_status0" type="radio" name="site_status" <?php if ($this->_var['setting']['site_status'] == 0): ?>checked<?php endif; ?> value="0" />
          <label for="site_status0">�ر�</label>
          <input id="site_status1" type="radio" name="site_status" <?php if ($this->_var['setting']['site_status'] == 1): ?>checked<?php endif; ?> value="1" />
          <label for="site_status1">����</label>        </td>
      </tr>
      <tr>
        <th class="paddingT15" valign="top"> <label for="closed_reason">�ر�ԭ��:</label></th>
        <td class="paddingT15 wordSpacing5"><textarea name="closed_reason" id="closed_reason"><?php echo $this->_var['setting']['closed_reason']; ?></textarea>        </td>
      </tr>
      <tr>
        <th class="paddingT15"> <label for="hot_search">��������:</label></th>
        <td class="paddingT15 wordSpacing5"><input id="hot_search" type="text" name="hot_search" value="<?php echo $this->_var['setting']['hot_search']; ?>" class="infoTableInput"/>
        <label class="field_notice">����ؼ���֮�����ö��ŷָ�</label></td>
      </tr>
      <tr>
        <th></th>
        <td class="ptb20"><input class="formbtn" type="submit" name="Submit" value="�ύ" />
          <input class="formbtn" type="reset" name="Submit2" value="����" />        </td>
      </tr>
    </table>
  </form>
</div>
<?php echo $this->fetch('footer.html'); ?>