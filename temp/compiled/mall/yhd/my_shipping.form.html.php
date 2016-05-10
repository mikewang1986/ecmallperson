<script type="text/javascript">
//<!CDATA[
$(function(){
   regionInit("region");
   $('#add_region_button').click(function(){
        var region_id = $('#region_id').val();
        var region_name = $('#region_name').val();
        if(!region_id || !region_name){
            return;
        }
        if($('#region_' + region_id).length == 0){
            $('#current_cod_regions').append($('<label id="region' + region_id + '"><input type="checkbox" checked="true" name="cod_regions[' + region_id + ']" id="region_' + region_id + '" value="' + region_name + '" />&nbsp;' + region_name + '<a href="javascript:void(0);" class="delete" onclick="del_region('+region_id+')">ɾ��</a></label>'));
        }
   });
   $('#shipping_form').validate({
         errorLabelContainer: $('#warning'),
        invalidHandler: function(form, validator) {
           var errors = validator.numberOfInvalids();
           if(errors)
           {
               $('#warning').show();
           }
           else
           {
               $('#warning').hide();
           }
        },
        onkeyup : false,
        rules : {
            shipping_name : {
                required : true
            },
            first_price   : {
                required : true,
                number   : true
            }
        },
        messages:{
            shipping_name : {
                required : '���Ʋ���Ϊ��.'
            },
            first_price   : {
                required : '�׼��ʷѲ���Ϊ��.',
                number   : 'ֻ��������'
            }
        }
    });
});
function del_region(region_id){
    $('#region'+region_id).remove();
}
//]]>
</script>
<style>
.borline td {padding:10px 0px;}
.ware_list th {text-align:left;}
</style>
<ul class="tab">
    <li class="active"><?php if ($_GET['act'] == edit): ?>�༭���ͷ�ʽ<?php else: ?>�������ͷ�ʽ<?php endif; ?></li>
</ul>
<div class="eject_con">
    <div class="info_table_wrap">
        <div id="warning"></div>
        <form method="post" action="index.php?app=my_shipping&amp;act=<?php echo $_GET['act']; ?><?php if ($_GET['shipping_id'] != ''): ?>&amp;shipping_id=<?php echo $_GET['shipping_id']; ?><?php endif; ?>" target="my_shipping" id="shipping_form">
        <h3>������Ϣ</h3>
        <ul class="info_table">
            <li>
                <h4>����:</h4>
                <p><input type="text" class="text width_normal" name="shipping_name" value="<?php echo htmlspecialchars($this->_var['shipping']['shipping_name']); ?>" /><b>*</b></p>
            </li>
            <li>
                <h4>���:</h4>
                <p><textarea class="text" name="shipping_desc"><?php echo htmlspecialchars($this->_var['shipping']['shipping_desc']); ?></textarea><span>����Ϣ�����û��µ�ʱ������</span></p>
            </li>
            <li>
                <h4>�׼��ʷ�:</h4>
                <p><input type="text" class="text width_normal" name="first_price" value="<?php echo $this->_var['shipping']['first_price']; ?>"/><b>*</b></p>
            </li>
            <li>
                <h4>�����ʷ�:</h4>
                <p><input type="text" class="text width_normal" name="step_price" value="<?php echo $this->_var['shipping']['step_price']; ?>" /></p>
            </li>
            <li>
                <h4>����:</h4>
                <p>
                   <?php echo $this->html_radios(array('options'=>$this->_var['yes_or_no'],'checked'=>$this->_var['shipping']['enabled'],'name'=>'enabled')); ?>
                </p>
            </li>
            <li>
                <h4>����:</h4>
                <p><input type="text" class="text width_short" name="sort_order" value="<?php echo $this->_var['shipping']['sort_order']; ?>"/></p>
            </li>
        </ul>
        <h3>�ɻ����������</h3>
        <ul class="info_table">
            <li>
                <h5>��ӿɻ�������ĵ���:</h5>
                <p>
                    <div id="region">
                    <input type="hidden" name="region_id" id="region_id" class="mls_id" />
                    <input type="hidden" name="region_name" id="region_name" class="mls_names" />
                    <select>
                      <option>��ѡ��...</option>
                      <?php echo $this->html_options(array('options'=>$this->_var['regions'])); ?>
                    </select>
                    <input class="btn" type="button" id="add_region_button" value="����" />
                    </div>
                </p>
            </li>
            <li>
                <h5>�ɻ����������:</h5>
                <div class="zone" id="current_cod_regions">
                    <?php $_from = $this->_var['cod_regions']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('cod_r_id', 'cod_r');if (count($_from)):
    foreach ($_from AS $this->_var['cod_r_id'] => $this->_var['cod_r']):
?>
                    <label id="region<?php echo $this->_var['cod_r_id']; ?>"><input type="checkbox" checked="true" name="cod_regions[<?php echo $this->_var['cod_r_id']; ?>]" id="region_<?php echo $this->_var['cod_r_id']; ?>" value="<?php echo $this->_var['cod_r']; ?>" />&nbsp;<?php echo $this->_var['cod_r']; ?><a href="javascript:;" class="delete" onclick="del_region(<?php echo $this->_var['cod_r_id']; ?>)">ɾ��</a></label>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

                </div>
            </li>
        </ul>
        <div class="submit"><input type="submit" class="btn" value="�ύ" /></div>
        </form>
    </div>
</div>