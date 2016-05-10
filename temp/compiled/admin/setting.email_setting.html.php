<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript">
$(function(){
    $('#send_test_email').click(send_test_email);
});
function send_test_email(){
    var email_type = $('input[name="email_type"]:checked').val();
    $.ajax({
        type:"POST",
        url:"index.php",
        data:'app=setting&act=send_test_email&email_type='+email_type+'&email_host='+$("#email_host").val()+'&email_port='+$("#email_port").val()+'&email_addr='+$("#email_addr").val()+'&email_id='+$("#email_id").val()+'&email_pass='+$("#email_pass").val()+'&email_test='+$("#email_test").val(),
        dataType:"json",
        success:function(data){
            if(data.done){
            alert(data.msg);
            }
            else{
                alert(data.msg);
            }
        },
        error: function(){alert('�����ʼ�����ʧ�ܣ������������ʼ�������');}
    });
}
</script>



<div id="rightTop">
    <p>��վ����</p>
    <ul class="subnav">
        <li><a class="btn1" href="index.php?app=setting&amp;act=base_setting">ϵͳ����</a></li>
        <li><a class="btn1" href="index.php?app=setting&amp;act=base_information">������Ϣ</a></li>
        <li><span>Email</span></li>
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
                <th class="paddingT15">
                    <label for="email_type">�ʼ����ͷ�ʽ:</label></th>
                <td class="paddingT15 wordSpacing5">
                    <?php echo $this->html_radios(array('name'=>'email_type','options'=>$this->_var['mail_type'],'checked'=>$this->_var['setting']['email_type'])); ?>
                    <label class="field_notice">�����ѡ����������÷�ʽ��������д����ѡ��</label>
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    SMTP ������:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" id="email_host" type="text" name="email_host" value="<?php echo $this->_var['setting']['email_host']; ?>"/>
                    <label class="field_notice">���� SMTP �������ĵ�ַ</label></td>
            </tr>
            <tr>
                <th class="paddingT15">
                    SMTP �˿�:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" id="email_port" type="text" name="email_port" value="<?php echo $this->_var['setting']['email_port']; ?>"/>
                    <label class="field_notice">���� SMTP �������Ķ˿ڣ�Ĭ��Ϊ 25</label></td>
            </tr>
            <tr>
                <th class="paddingT15">
                    �������ʼ���ַ:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" id="email_addr" type="text" name="email_addr" value="<?php echo $this->_var['setting']['email_addr']; ?>"/>
                    <label class="field_notice">��� SMTP ������Ҫ�������֤������Ϊ�����������ʼ���ַ</label></td>
            </tr>
            <tr>
                <th class="paddingT15">
                    SMTP �����֤�û���:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" id="email_id" type="text" name="email_id" value="<?php echo $this->_var['setting']['email_id']; ?>"/></td>
            </tr>
            <tr>
                <th class="paddingT15">
                    SMTP �����֤����:</th>
                <td class="paddingT15 wordSpacing5">
                <input class="infoTableInput" id="email_pass" type="password" name="email_pass" value="<?php echo $this->_var['setting']['email_pass']; ?>"/></td>
            </tr>
            <tr>
                <th class="paddingT15">
                    �����ʼ���ַ:</th>
                <td class="paddingT15 wordSpacing5">
                <input class="infoTableInput" id="email_test" type="text" name="email_test" value="<?php echo $this->_var['setting']['email_test']; ?>"/>&nbsp;&nbsp;<input id="send_test_email" class="formbtn" type="button" name="send_test_email" value="����" /></td>
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
