<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript">
function clean_file()
{
    $.getJSON('index.php?app=widget&act=clean_file', function(data){
        if (!data.done)
        {
            alert(data.msg);

            return;
        }
        else
        {
            if (confirm(data.msg))
            {
                $.getJSON('index.php?app=widget&act=clean_file&continue', function(rzt){
                    alert(rzt.msg);
                });
            }
        }

    });
}
</script>
<div id="rightTop">
    <p><strong>�Ҽ�����</strong>[<a href="javascript:void(0);" onclick="clean_file();" title="�����ļ���ָ���ϴ����������ϣ���ʵ�ʲ�û�б����õ��ļ����ظ��������ϴ��ļ��ĹҼ�������������ļ��������Ҫ��ʱ������Щ�ļ����ͷ�Ӳ�̿ռ�">��������ļ�</a>]</p>
</div>
<div class="tdare info">
    <table width="100%" cellspacing="0">
        <?php if ($this->_var['widgets']): ?>
        <tr class="tatr1">
            <td width="15%">�Ҽ�����</td>
            <td align="left">�Ҽ�����</td>
            <td width="10%">����</td>
            <td width="50">�汾</td>
            <td class="handler" style="width:150px;">����</td>
        </tr>
        <?php endif; ?>
        <?php $_from = $this->_var['widgets']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'widget');if (count($_from)):
    foreach ($_from AS $this->_var['widget']):
?>
        <tr class="tatr2">
            <td><?php echo htmlspecialchars($this->_var['widget']['display_name']); ?></td>
            <td align="left"><?php echo htmlspecialchars($this->_var['widget']['desc']); ?></td>
            <td><a href="<?php echo $this->_var['widget']['website']; ?>" target="_blank" title="��������"><?php echo htmlspecialchars($this->_var['widget']['author']); ?></a></td>
            <td><?php echo htmlspecialchars($this->_var['widget']['version']); ?></td>
            <td class="handler">
                <a href="index.php?app=widget&amp;act=edit&name=<?php echo $this->_var['widget']['name']; ?>&file=script">�༭�ű�</a>
                |
                <a href="index.php?app=widget&amp;act=edit&name=<?php echo $this->_var['widget']['name']; ?>&file=template">�༭ģ��</a>
                </td>
        </tr>
        <?php endforeach; else: ?>
        <tr class="no_data">
            <td colspan="5">��δ��װ�κιҼ�</td>
        </tr>
        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </table>
</div>
<?php echo $this->fetch('footer.html'); ?>
