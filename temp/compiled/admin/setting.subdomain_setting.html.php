<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
    <p>��վ����</p>
    <ul class="subnav">
        <li><a class="btn1" href="index.php?app=setting&amp;act=base_setting">ϵͳ����</a></li>
        <li><a class="btn1" href="index.php?app=setting&amp;act=base_information">������Ϣ</a></li>
        <li><a class="btn1" href="index.php?app=setting&amp;act=email_setting">Email</a></li>
        <li><a class="btn1" href="index.php?app=setting&amp;act=captcha_setting">��֤��</a></li>
        <li><a class="btn1" href="index.php?app=setting&amp;act=store_setting">��������</a></li>
        <li><a class="btn1" href="index.php?app=setting&amp;act=credit_setting">��������</a></li>
        <li><span>��������</span></li>
    </ul>
</div>

<div class="info">
    <form method="post">
        <table class="infoTable">
            <tr>
                <th class="paddingT15">
                    �Ƿ����ö�������:</th>
                <td class="paddingT15 wordSpacing5">
                    <?php echo $this->html_radios(array('name'=>'enabled_subdomain','options'=>$this->_var['yes_or_no'],'checked'=>$this->_var['config']['enabled_subdomain'])); ?>
                <span class="grey">���ö���������Ҫ���ķ�����֧�֣��������÷�����鿴��װ����docsĿ¼�еĶ������������ĵ�</span>
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    ����������׺:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" id="subdomain_suffix" type="text" name="subdomain_suffix" value="<?php echo $this->_var['config']['subdomain_suffix']; ?>"/>
                <span class="grey">����:�û��Ķ�����������"test.mall.example.com", ����ֻ��Ҫ�ڴ���д"mall.example.com"</span>
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    ��������:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" id="subdomain_reserved" type="text" name="subdomain_reserved" value="<?php echo $this->_var['setting']['subdomain_reserved']; ?>"/>
                <span class="grey">���������������Ķ��������������������֮������","�Ÿ���</span>
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    ��������:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" id="subdomain_length" type="text" name="subdomain_length" value="<?php echo $this->_var['setting']['subdomain_length']; ?>"/>
                    <span class="grey">����"3-12"������ע�������������3��12���ַ�����֮��</span>
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
