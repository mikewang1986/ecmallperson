<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript">
//ע�����֤
$(function(){
    $('#register_form').validate({
        errorPlacement: function(error, element){
            var error_td = element.parent('td').next('td');
            error_td.find('.field_notice').hide();
            error_td.append(error);
        },
        success       : function(label){
            label.addClass('validate_right').text('OK!');
        },
        onkeyup: false,
        rules : {
            user_name : {
                required : true,
                byteRange: [3,15,'<?php echo $this->_var['charset']; ?>'],
                remote   : {
                    url :'index.php?app=member&act=check_user&ajax=1',
                    type:'get',
                    data:{
                        user_name : function(){
                            return $('#user_name').val();
                        }
                    },
                    beforeSend:function(){
                        var _checking = $('#checking_user');
                        _checking.prev('.field_notice').hide();
                        _checking.next('label').hide();
                        $(_checking).show();
                    },
                    complete :function(){
                        $('#checking_user').hide();
                    }
                }
            },
            password : {
                required : true,
                minlength: 6
            },
            password_confirm : {
                required : true,
                equalTo  : '#password'
            },
            email : {
                required : true,
                email    : true
            },
            captcha : {
                required : true,
                remote   : {
                    url : 'index.php?app=captcha&act=check_captcha',
                    type: 'get',
                    data:{
                        captcha : function(){
                            return $('#captcha1').val();
                        }
                    }
                }
            },
            agree : {
                required : true
            }
        },
        messages : {
            user_name : {
                required : '�������ṩһ���û���',
                byteRange: '�û���������3-15���ַ�֮��',
                remote   : '���ṩ���û����Ѵ���'
            },
            password  : {
                required : '�������ṩһ������',
                minlength: '���볤��Ӧ��6-20���ַ�֮��'
            },
            password_confirm : {
                required : '�������ٴ�ȷ����������',
                equalTo  : '������������벻һ��'
            },
            email : {
                required : '�������ṩ���ĵ�������',
                email    : '�ⲻ��һ����Ч�ĵ�������'
            },
            captcha : {
                required : '�������Ҳ�ͼƬ�е�����',
                remote   : '��֤�����'
            },
            agree : {
                required : '�������Ķ���ͬ���Э��,�����޷�ע��'
            }
        }
    });
});
</script>
<div class="login">
	<div class="main">
    	<h2>�û�ע��</h2>
                <div class="login_con">
                    <div class="login_fill_in">
                        <form name="" id="register_form" method="post" action="">
                        <table>
                            <tr>
                                <td colspan="3"><h4>��дע����Ϣ</h4></td>
                            </tr>
                            <tr>
                                <td>�û���:</td>
                                <td><input type="text" id="user_name" name="user_name" class="text width10" /></td>
                                <td class="padding3 fontColor4"><label class="field_notice">���ڵ�¼������</label><label id="checking_user" class="checking">�����...</label></td>
                            </tr>
                            <tr>
                                <td>��&nbsp;&nbsp;&nbsp;��:</td>
                                <td><input type="password" id="password" name="password" class="text width10" /></td>
                                <td class="padding3 fontColor4"><label class="field_notice">��������</label></td>
                            </tr>
                            <tr>
                                <td>ȷ������:</td>
                                <td><input type="password" name="password_confirm" class="text width10" /></td>
                                <td class="padding3 fontColor4"><label class="field_notice">�ظ�������������</label></td>
                            </tr>
                            <tr>
                                <td>��������:</td>
                                <td><input type="text" name="email" class="text width10" /></td>
                                <td class="padding3 fontColor4"><label class="field_notice">������һ����Ч�ĵ��������ַ</label></td>
                            </tr>
                            <?php if ($this->_var['captcha']): ?>
                            <tr>
                                <td>��֤��:</td>
                                <td>
                                    <input type="text" name="captcha" class="text" id="captcha1" />
                                    <a href="javascript:change_captcha($('#captcha'));" class="renewedly"><img id="captcha" src="index.php?app=captcha&amp;<?php echo $this->_var['random_number']; ?>" /></a>
                                </td>
                                <td class="padding3 fontColor4"><label class="field_notice">������ͼƬ�е�����,���ͼƬ�Ը���</label></td>
                            </tr>
                            <?php endif; ?>
                            <tr>
                                <td></td>
                                <td><input id="clause" type="checkbox" name="agree" value="1" /> <label for="clause">�����Ķ���ͬ�� <a href="<?php echo url('app=article&act=system&code=eula'); ?>" target="_blank" class="agreement">�û�����Э��</a></label></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="2"><input type="submit" name="Submit" value="" class="login_btn" title="����ע��" /></td><input type="hidden" name="ret_url" value="<?php echo $this->_var['ret_url']; ?>" />
                            </tr>
                        </table>
                        </form>
                    </div>

                    <div class="login_right">
                        <h4>������ʾ:<br />����������ǻ�Ա����ע��</h4>
                        <p>ע��֮����Ϳ���</p>
                        <ul>
                            <li><strong>1.</strong> �������ĸ�������</li>
                            <li><strong>2.</strong> �ղ�����ע����Ʒ</li>
                            <!--<li><strong>3.</strong> ���ܻ�Ա�����ƶ�</li>-->
                            <li><strong>3.</strong> ���ı�����Ʒ��Ϣ</li>
                        </ul>
                        <h4>�Ѿ�ӵ���˺�</h4>
                        <a href="<?php echo url('app=member&act=login&ret_url=' . $this->_var['ret_url']. ''); ?>" class="enter" title="������¼"></a>
                    </div>
                </div>
    </div>
</div>


<?php echo $this->fetch('footer.html'); ?>
