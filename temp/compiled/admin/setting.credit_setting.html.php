<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
    <p>��վ����</p>
    <ul class="subnav">
        <li><a class="btn1" href="index.php?app=setting&amp;act=base_setting">ϵͳ����</a></li>
        <li><a class="btn1" href="index.php?app=setting&amp;act=base_information">������Ϣ</a></li>
        <li><a class="btn1" href="index.php?app=setting&amp;act=email_setting">Email</a></li>
        <li><a class="btn1" href="index.php?app=setting&amp;act=captcha_setting">��֤��</a></li>
        <li><a class="btn1" href="index.php?app=setting&amp;act=store_setting">��������</a></li>
        <li><span>��������</span></li>
        <li><a class="btn1" href="index.php?app=setting&amp;act=subdomain_setting">��������</a></li>
        </ul>
</div>

<div class="info">
    <form method="post" enctype="multipart/form-data">
        <table class="infoTable">
            <tr>
                <th class="paddingT15">
                    ��һ���������û���:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" id="upgrade_required" type="text" name="upgrade_required" value="<?php echo $this->_var['setting']['upgrade_required']; ?>"/></td>
            </tr>
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
