<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
    <p>��վ����</p>
    <ul class="subnav">
        <li><a class="btn1" href="index.php?app=setting&amp;act=base_setting">ϵͳ����</a></li>
        <li><a class="btn1" href="index.php?app=setting&amp;act=base_information">������Ϣ</a></li>
        <li><a class="btn1" href="index.php?app=setting&amp;act=email_setting">Email</a></li>
        <li><a class="btn1" href="index.php?app=setting&amp;act=captcha_setting">��֤��</a></li>
        <li><span>��������</span></li>
        <li><a class="btn1" href="index.php?app=setting&amp;act=credit_setting">��������</a></li>
        <li><a class="btn1" href="index.php?app=setting&amp;act=subdomain_setting">��������</a></li>
        </ul>
</div>

<div class="info">
    <form method="post" enctype="multipart/form-data">
        <table class="infoTable">
            <tr>
                <th class="paddingT15">
                    �������뿪��:</th>
                <td class="paddingT15 wordSpacing5">
                    <input id="store_allow0" type="radio" name="store_allow" <?php if ($this->_var['setting']['store_allow'] == 0): ?>checked<?php endif; ?> value="0" /> <label for="store_allow0">�ر�</label>
                    <input id="store_allow1" type="radio" name="store_allow" <?php if ($this->_var['setting']['store_allow'] == 1): ?>checked<?php endif; ?> value="1" /> <label for="store_allow1">����</label>
                </td>
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
