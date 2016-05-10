<?php echo $this->fetch('header.html'); ?>

<script type="text/javascript">
$(function(){
    $('#login_form').validate({
        errorPlacement: function(error, element){
            $(element).parent('td').append(error); 
        },
        success       : function(label){
            label.addClass('validate_right').text('OK!');
        },
        onkeyup : false,
        rules : {
            user_name : {
                required : true
            },
            password : {
                required : true
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
            }
        },
        messages : {
            user_name : {
                required : '�������ṩһ���û���'
            },
            password  : {
                required : '�������ṩһ������'
            },
            captcha : {
                required : '�������Ҳ�ͼƬ�е�����',
                remote   : '��֤�����'
            }
        }
    });
});
</script>
<div class="login">
	<div class="main">
    	<h2>�û���½</h2>
                <div class="login_con">
                    <div class="login_left">
                        <form method="post" id="login_form">
                        <table>
                            <tr>
                                <td>�û���: </td>
                                <td><input type="text" name="user_name" class="text width5" /></td>
                            </tr>
                            <tr>
                                <td>��&nbsp;&nbsp;&nbsp;��: </td>
                                <td><input type="password" name="password" class="text width5" /></td>
                            </tr>
                            <?php if ($this->_var['captcha']): ?>
                            <tr>
                                <td>��֤��:</td>
                                <td>
                                    <input type="text" name="captcha" class="text" id="captcha1" />
                                    <span><a href="javascript:change_captcha($('#captcha'));" class="renewedly"><img id="captcha" src="index.php?app=captcha&amp;<?php echo $this->_var['random_number']; ?>" /></a></span>
                                </td>
                            </tr>
                            <?php endif; ?>
                            <tr class="distance">
                                <td></td>
                                <td>
                                  <input type="submit" name="Submit" value="" class="enter" />                                  
                                  <a href="<?php echo url('app=find_password'); ?>" class="clew">�������룿</a>
                                </td>
                            </tr>
                        </table>
                        <input type="hidden" name="ret_url" value="<?php echo $this->_var['ret_url']; ?>" />
                        </form>
                    </div>

                    <div class="login_right">
                        <h4>������ʾ:<br />����������ǻ�Ա����ע��</h4>
                        <p>ע��֮����Ϳ���</p>
                        <ul>
                            <li><strong>1.</strong> �������ĸ�������</li>
                            <li><strong>2.</strong> �ղ�����ע����Ʒ</li>
                           <!-- <li><strong>3.</strong> ���ܻ�Ա�����ƶ�</li>-->
                            <li><strong>3.</strong> ���ı�����Ʒ��Ϣ</li>
                        </ul>
                        <a href="<?php echo url('app=member&act=register&ret_url=' . $this->_var['ret_url']. ''); ?>" class="login_btn" title="����ע��"></a>
                    </div>
                </div>
    </div>
</div>


<?php echo $this->fetch('footer.html'); ?>