<?php echo $this->fetch('header.html'); ?>
<script src="<?php echo $this->lib_base . "/" . 'mlselection.js'; ?>" charset="utf-8"></script>
<script src="<?php echo $this->lib_base . "/" . 'jquery.plugins/jquery.validate.js'; ?>" charset="utf-8"></script>
<style type="text/css">
.d_inline{display:inline;}
</style>
<div class="mainbox">
<script type="text/javascript">
//<!CDATA[
var SITE_URL = "<?php echo $this->_var['site_url']; ?>";
$(function(){
    regionInit("region");

    $("#apply_form").validate({
        errorPlacement: function(error, element){
            var error_td = element.parents('td').next('td');
            error_td.find('.field_notice').hide();
            error_td.find('.fontColor3').hide();
            error_td.append(error);
        },
        success: function(label){
            label.addClass('validate_right').text('OK!');
        },
        onkeyup: false,
        rules: {
            owner_name: {
                required: true
            },
            store_name: {
                required: true,
                remote : {
                    url  : 'index.php?app=apply&act=check_name&ajax=1',
                    type : 'get',
                    data : {
                        store_name : function(){
                            return $('#store_name').val();
                        },
                        store_id : '<?php echo $this->_var['store']['store_id']; ?>'
                    }
                },
                maxlength: 20
            },
            tel: {
                required: true,
                minlength:6,
                checkTel:true
            },
            image_1: {
                accept: "jpg|jpeg|png|gif"
            },
            image_2: {
                accept: "jpg|jpeg|png|gif"
            },
            image_3: {
                accept: "jpg|jpeg|png|gif"
            },
            notice: {
                required : true
            }
        },
        messages: {
            owner_name: {
                required: '�������������'
            },
            store_name: {
                required: '�������������',
                remote: '�õ��������Ѵ��ڣ�������һ��',
                maxlength: '�������20��������'
            },
            tel: {
                required: '��������ϵ�绰',
                minlength: '�绰���������֡��Ӻš����š��ո��������,����������6λ',
                checkTel: '�绰���������֡��Ӻš����š��ո��������,����������6λ'
            },
            image_1: {
                accept: '���ϴ���ʽΪ jpg,jpeg,png,gif ���ļ�'
            },
            image_2: {
                accept: '���ϴ���ʽΪ jpg,jpeg,png,gif ���ļ�'
            },
            image_3: {
                accept: '���ϴ���ʽΪ jpg,jpeg,png,gif ���ļ�'
            },
            notice: {
                required: '���Ķ���ͬ�⿪��Э��'
            }
        }
    });
});
//]]>
</script>
    <div class="module_common">
        <h2><b class="set_up_shop" title="SHOP REGISTRATION��Ҫ����"></b></h2>
        <div class="wrap">
            <div class="wrap_child">

                <div class="module_new_shop">

                    <div class="chart">
                        <div class="pos_x1 bg_a1" title="1. ѡ���������"></div>
                        <div class="pos_x2 bg_b2" title="2. ��д�����͵�����Ϣ"></div>
                        <div class="pos_x3 bg_c" title="3. ���"></div>
                    </div>

                    <div class="info_shop">
                        <form method="post" enctype="multipart/form-data" id="apply_form">
                        <table>
                            <tr>
                                <th>��������: </th>
                                <td class="width7"><input type="text" class="text width7" name="owner_name" value="<?php echo htmlspecialchars($this->_var['store']['owner_name']); ?>"/></td>
                                <td class="padding3"><span class="fontColor3">*</span> <span class="field_notice">����д��ʵ����</span></td>
                            </tr>
                            <tr>
                                <th>���֤��: </th>
                                <td><input type="text" class="text width7" name="owner_card"/ value="<?php echo htmlspecialchars($this->_var['store']['owner_card']); ?>"></td>
                                <td class="padding3"> <span class="field_notice">����д��ʵ׼ȷ�����֤��</span></td>
                            </tr>
                            <tr>
                                <th>��������: </th>
                                <td><input type="text" class="text width7" name="store_name" id="store_name" value="<?php echo htmlspecialchars($this->_var['store']['store_name']); ?>"/></td>
                                <td class="padding3"><span class="fontColor3">*</span> <span class="field_notice">�������20��������</span></td>
                            </tr>
                            <tr>
                                <th>��������: </th>
                                <td>
                                    <div class="select_add"><select name="cate_id">
                                    <option value="0">��ѡ��...</option>
                                    <?php echo $this->html_options(array('options'=>$this->_var['scategories'],'selected'=>$this->_var['scategory']['cate_id'])); ?>
                                    </select>
                                    </div>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <th>���ڵ���: </th>
                                <td>
                                <div class="select_add" id="region" style="width:500px;border:1px solide red;">
                                    <input type="hidden" name="region_id" value="<?php echo $this->_var['store']['region_id']; ?>" class="mls_id" />
                                    <input type="hidden" name="region_name" value="<?php echo $this->_var['store']['region_name']; ?>" class="mls_names" />
                                    <?php if ($this->_var['store']['region_name']): ?>
                                    <span><?php echo htmlspecialchars($this->_var['store']['region_name']); ?></span>
                                    <input type="button" value="�༭" class="edit_region" />
                                    <?php endif; ?>
                                    <select class="d_inline"<?php if ($this->_var['store']['region_name']): ?> style="display:none;"<?php endif; ?>>
                                    <option value="0">��ѡ��...</option>
                                    <?php echo $this->html_options(array('options'=>$this->_var['regions'])); ?>
                                    </select>
                                </div>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <th>��ϸ��ַ: </th>
                                <td><input type="text" class="text width7" name="address" value="<?php echo htmlspecialchars($this->_var['store']['address']); ?>"/></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th>��������: </th>
                                <td><input type="text" class="text width7" name="zipcode" value="<?php echo htmlspecialchars($this->_var['store']['zipcode']); ?>"/></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th>��ϵ�绰: </th>
                                <td>
                                    <input type="text" class="text width7" name="tel"  value="<?php echo htmlspecialchars($this->_var['store']['tel']); ?>"/>
                                </td>
                                <td class="padding3"><span class="fontColor3">*</span> <span class="field_notice">��������ϵ�绰</span></td>
                            </tr>
                            <tr>
                                <th>�ϴ�֤��: </th>
                                <td><input type="file" name="image_1" />
                                <?php if ($this->_var['store']['image_1']): ?><p style="display:inline;"><a href="<?php echo $this->_var['site_url']; ?>/<?php echo $this->_var['store']['image_1']; ?>" target="_blank">�鿴</a></p><?php endif; ?>
                                </td>
                                <td class="padding3"><span class="field_notice">֧�ָ�ʽjpg,jpeg,png,gif���뱣֤ͼƬ�������ļ���С������400KB</span></td>
                            </tr>
                            <tr>
                                <th>�ϴ�ִ��: </th>
                                <td><input type="file" name="image_2" />
                                <?php if ($this->_var['store']['image_2']): ?><p style="display:inline;"><a href="<?php echo $this->_var['site_url']; ?>/<?php echo $this->_var['store']['image_2']; ?>" target="_blank">�鿴</a></p><?php endif; ?>
                                </td>
                                <td class="padding3"><span class="field_notice">֧�ָ�ʽjpg,jpeg,png,gif���뱣֤ͼƬ�������ļ���С������400KB</span></td>
                            </tr>
                            <tr>
                                <td colspan="2"><p class="padding4"><input type="checkbox"<?php if ($this->_var['store']): ?> checked="checked"<?php endif; ?> name="notice" value="1" id="warning" /> <label for="warning">���������Ķ�����ȫͬ��<a href="index.php?app=article&act=system&code=setup_store" target="_blank">����Э��</a>�е���������</label></p></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="3"><p class="padding4"><input class="btn" type="submit" value="" /></p></td>
                            </tr>
                        </table>
                        </form>
                    </div>

                </div>

            </div>
        </div>
    </div>

</div>
<?php echo $this->fetch('footer.html'); ?>
