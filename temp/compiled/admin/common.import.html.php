<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
  <p>��������</p>
  <ul class="subnav">
  </ul>
</div>
<div class="info">
  <form method="post" enctype="multipart/form-data">
    <table class="infoTable">
      <tr>
        <th class="paddingT15">��ѡ���ļ�:</th>
        <td class="paddingT15 wordSpacing5">
        <input type="file" name="csv" id="csv" />
        <span class="grey">��������ٶȽ��������������ļ����Ϊ����С�ļ���Ȼ��ֱ���</span></td>
      </tr>
      <tr>
        <th class="paddingT15">��ѡ���ļ�����:</th>
        <td class="paddingT15 wordSpacing5"><p>
            <label>
            <input type="radio" name="charset" value="utf-8" checked="checked" />
            utf-8</label>
            <label>
            <input type="radio" name="charset" value="gbk" />
            gbk</label>
            <label>
            <input type="radio" name="charset" value="big5" />
            big5</label>
            <span class="grey"><?php echo $this->_var['note_for_import']; ?></span>
          </p>
          </td>
      </tr>
      <tr>
        <th class="paddingT15" valign="top">�ļ���ʽ:</th>
        <td class="paddingT15 wordSpacing5"><table border="1"><tr><td>һ������</td></tr><tr><td></td><td>��������</td></tr><tr><td></td><td>��������</td></tr><tr><td>һ������</td></tr></table></td>
      </tr>
      <tr>
        <th></th>
        <td class="ptb20"><input class="formbtn" type="submit" name="Submit" value="����" />
          <input class="formbtn" type="button" onclick="history.go(-1)" value="����" />        </td>
      </tr>
    </table>
  </form>
</div>
<?php echo $this->fetch('footer.html'); ?> 