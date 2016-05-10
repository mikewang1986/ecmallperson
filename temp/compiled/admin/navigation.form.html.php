<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript" src="index.php?act=jslang"></script>

<script type="text/javascript" src="<?php echo $this->res_base . "/" . 'js/navigation.js'; ?>" charset="utf-8"></script>
<script type="text/javascript">
$(function(){
       $('#navigation_form').validate({
        errorPlacement: function(error, element){
            $(element).next('.field_notice').hide();
            $(element).after(error);
        },
        success       : function(label){
            label.addClass('right').text('OK!');
        },
        rules : {
            title : {
                required : true
            },
            sort_order:{
               number   : true
            }
        },
        messages : {
            title : {
                required : '���ⲻ��Ϊ��'
            },
            sort_order  : {
                number   : '�������Ϊ����'
            }
        }
    });
      $('#diy').click (
        function()
        {
            on('diy');
            $('#link').attr('disabled',false);
            $('#link').val("<?php echo htmlspecialchars($this->_var['navigation']['link']); ?>");
            $('#gcategory_cate_id').val('');
        }
    );
});

</script>
<div id="rightTop">
    <p>ҳ�浼��</p>
    <ul class="subnav">
        <li><a class="btn1" href="index.php?app=navigation">����</a></li>
        <?php if ($this->_var['navigation']['nav_id']): ?>
        <li><a class="btn1" href="index.php?app=navigation&amp;act=add">����</a></li>
        <?php else: ?>
        <li><span>����</span></li>
        <?php endif; ?>
    </ul>
</div>

<div class="info">
    <form method="post" enctype="multipart/form-data" id="navigation_form">
        <table class="infoTable">
            <tr>
                <th class="paddingT15">
                    ��������</th>
                <td class="paddingT15 wordSpacing5">
                    <input id="diy" type="radio" name="nav_type" value="diy" checked="checked" /><label for="diy">�Զ��嵼��</label>
                    <input id="gcategory" type="radio" name="nav_type" value="gcategory" />
                    <label for="gcategory">��Ʒ����</label>
                    <input type="hidden" id="gcategory_cate_id" name="gcategory_cate_id" class="mls_id" />
                    <span id='select_gcategory'>
                    <select><option value="">��ѡ��...</option><?php echo $this->html_options(array('options'=>$this->_var['gcategory_options'])); ?></select>
                    </span>
                    <input id="acategory" type="radio" name="nav_type" value="acategory" />
                    <label for="acategory">���·���</label>
                    <select id="acategory_cate_id" name="acategory_cate_id"><option value="">��ѡ��...</option><?php echo $this->html_options(array('options'=>$this->_var['acategory_options'])); ?></select>
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    ����:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="mls_name infoTableInput2" id="title" type="text" name="title" value="<?php echo htmlspecialchars($this->_var['navigation']['title']); ?>" />
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    ����:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" id="link" type="text" name="link" value="<?php echo htmlspecialchars($this->_var['navigation']['link']); ?>" />
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    <label for="type">����λ��:</label></th>
                <td class="paddingT15 wordSpacing5">
                    <?php echo $this->html_radios(array('options'=>$this->_var['type'],'checked'=>$this->_var['navigation']['type'],'name'=>'type')); ?>
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    <label>�´��ڴ�:</label></th>
                <td class="paddingT15 wordSpacing5">
                    <?php echo $this->html_radios(array('options'=>$this->_var['open_new'],'checked'=>$this->_var['navigation']['open_new'],'name'=>'open_new')); ?>
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    ����:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="sort_order" id="sort_order" type="text" name="sort_order" value="<?php echo $this->_var['navigation']['sort_order']; ?>" />
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
