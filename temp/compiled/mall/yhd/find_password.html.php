<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript">
$(function(){
    $('#find_password_form').validate({
        errorPlacement: function(error, element){
          $(element).parent('td').append(error);
        },
        success       : function(label){
            label.addClass('validate_right').text('OK!');
        },
        rules : {
            username : {
                required : true
            },
            email : {
                required : true,
                email : true
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
            username : {
                required : '�û�������Ϊ��'
            },
            email  : {
                required : '�������䲻��Ϊ��',
                email : '����������д����'
            },
            captcha : {
                required : '��֤�벻��Ϊ��',
                remote   : '��֤�����'
            }
        }
    });
});
</script>     
<div class="login">
	<div class="main">
    	<h2>�һ����� <b style=" color:#F00; margin-left:50px;">��������ĵ�¼�ʺź͵�������, ϵͳ���֮��ᷢ�ʼ����������, �밴���ʼ�����ʾ����</b></h2>
                <div class="login_con" style="background:#FFF;">
                    <div class="login_left">
                      <form action="" method="POST" id="find_password_form">
                           <table> 
                                <tr>
                                     <td>���ĵ�¼�˺�:</td><td><input type="text" class="text width5" name="username"/></td>
                                </tr>
                                <tr>
                                     <td>���ĵ�������:</td><td><input type="text" class="text width5" name="email"/></td>
                                </tr>
                                <tr>
                                     <td>��֤��:</td>
                                     <td><input type="text" class="text" name="captcha" id="captcha1"><span><a class="renewedly" href="javascript:change_captcha($('#captcha'));"><img id="captcha" src="index.php?app=captcha"></a></span></td>
                                </tr>
                                <tr class="distance">
                                     <td></td>
                                     <td><input type="submit" value="�ύ" name="Submit" class="btn" id="captcha1"></td>
                                </tr>
                           </table>
                      </form>
                    </div>
                </div>
   </div>
</div>

<?php echo $this->fetch('footer.html'); ?>