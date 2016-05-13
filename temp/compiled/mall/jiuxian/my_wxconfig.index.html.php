<?php echo $this->fetch('member.header.html'); ?>
<script type="text/javascript">
//<!CDATA[
    $(function() {
        $('#my_wxconfig_form').validate({
            errorPlacement: function(error, element) {
                $(element).next('.field_notice').hide();
                if ($(element).parent().parent().is('b'))
                {
                    $(element).parent().parent('b').next('.explain').hide();
                    $(element).parent().parent('b').after(error);
                }
                else
                {
                    $(element).after(error);
                }
            },
            rules: {
                url: {
                    required: true,
                },
                token: {
                    required: true,
                }
            },
            messages: {
                url: {
                    required: '不能为空',
                },
                token: {
                    required: '不能为空',
                }
            }
        });
    });

//]]>

</script>
<?php echo $this->_var['build_editor']; ?>
<div class="content">
    <div class="totline"></div>
    <div class="botline"></div>
    <?php echo $this->fetch('member.menu.html'); ?>
    <div id="right"> <?php echo $this->fetch('member.submenu.html'); ?>
        <div class="wrap">
            <div class="public">
                <div class="information">
                    <div class="setup info shop">
                        <form method="post"  id="my_wxconfig_form">
                            <table style="width: 100%">
                                
                                <tr>
                                    <th class="width2">接口配置URL:</th>
                                    <td>
                                        <p class="td_block"><input id="url" type="text" class="text width_normal" name="url" value="<?php echo htmlspecialchars($this->_var['wx_config']['url']); ?>" style="width:480px;" readonly/></p>
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <th>接口配置Token:</th>
                                    <td>
                                        <p class="td_block"><input type="text" name="token" class="text width_normal" id="token" value="<?php echo htmlspecialchars($this->_var['wx_config']['token']); ?>" readonly/></p>
                                        <a href="static/weixin/help/index.html" target="_blank" class="btn1">说明文档</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="issuance"><input type="submit" class="btn" value="提交" /></div>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
            <div class="wrap_bottom"></div>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php echo $this->fetch('footer.html'); ?>