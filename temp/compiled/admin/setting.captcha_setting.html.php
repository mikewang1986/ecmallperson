<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
    <p>��վ����</p>
    <ul class="subnav">
        <li><a class="btn1" href="index.php?app=setting&amp;act=base_setting">ϵͳ����</a></li>
        <li><a class="btn1" href="index.php?app=setting&amp;act=base_information">������Ϣ</a></li>
        <li><a class="btn1" href="index.php?app=setting&amp;act=email_setting">Email</a></li>
        <li><span>��֤��</span></li>
        <li><a class="btn1" href="index.php?app=setting&amp;act=store_setting">��������</a></li>
        <li><a class="btn1" href="index.php?app=setting&amp;act=credit_setting">��������</a></li>
        <li><a class="btn1" href="index.php?app=setting&amp;act=subdomain_setting">��������</a></li>
        </ul>
</div>

<div class="info">
    <form method="post" enctype="multipart/form-data">
        <table class="infoTable">
            <tr>
                <th class="paddingT15">
                    ����ʱ��:</th>
              <td class="paddingT15 wordSpacing5">
                  <input id="captcha_status1" type="checkbox" name="captcha_status[login]" value="1" <?php if ($this->_var['setting']['captcha_status']['login']): ?>checked<?php endif; ?>/> <label for="captcha_status1">ǰ̨��¼</label>
                    <input id="captcha_status2" type="checkbox" name="captcha_status[register]" value="1" <?php if ($this->_var['setting']['captcha_status']['register']): ?>checked<?php endif; ?>/> <label for="captcha_status2">ǰ̨ע��</label>
                     <input id="captcha_status3" type="checkbox" name="captcha_status[goodsqa]" value="1" <?php if ($this->_var['setting']['captcha_status']['goodsqa']): ?>checked<?php endif; ?>/> <label for="captcha_status3">��Ʒ��ѯ</label> 
                    <input id="captcha_status4" type="checkbox" name="captcha_status[backend]" value="1" <?php if ($this->_var['setting']['captcha_status']['backend']): ?>checked<?php endif; ?>/> <label for="captcha_status4">��̨��¼</label>                </td>
            </tr>
            <!--<tr>
                <th class="paddingT15">
                    �����¼ʧ�ܴ���:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" id="captcha_error_login" type="text" name="captcha_error_login" value="<?php echo $this->_var['setting']['captcha_error_login']; ?>"/></td>
            </tr>-->
            <tr>
            <th></th>
            <td class="ptb20">
                <input class="formbtn" type="submit" name="Submit" value="�ύ" />
                <input class="formbtn" type="reset" name="Submit2" value="����" />
            </td>
        </tr>
        </table>
    </form>
</div>
<?php echo $this->fetch('footer.html'); ?>
