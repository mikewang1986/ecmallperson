<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
  <p>����Ա����</p>
  <ul class="subnav">
    <li><a class="btn1" href="index.php?app=admin">����</a></li>
    <li><span>���</span></li>
  </ul>
</div>
<div class="info">
  <form method="post" enctype="multipart/form-data" id="test_form">
    <table class="infoTable">
      <tr>
        <th class="paddingT15"> �û���:</th>
        <td class="paddingT15 wordSpacing5"><input class="infoTableInput2" name="user_name" type="text" id="user_name" /><label class="field_notice">����������Ҫ��ӵĹ���Ա��Ա��</label></td>
      </tr>
      <tr>
        <th></th>
        <td class="ptb20"><input class="formbtn" type="submit" name="Submit" value="�ύ" />
          <input class="formbtn" type="reset" name="Reset" value="����" /></td>
      </tr>
    </table>
  </form>
</div>
<?php echo $this->fetch('footer.html'); ?> 