<?php echo $this->fetch('header.html'); ?>
<script language="javascript">
$(function(){
    $.getJSON('<?php echo $this->_var['spt']; ?>&jsoncallback=?',function(){});
    $.getJSON('http://ecmall.shopex.cn/system/notice2.php?charset=<?php echo $this->_var['cur_lang']; ?>&uniqueid=<?php echo $this->_var['uniqueid']; ?>&jsoncallback=?',function(data){
        var message='';
        $.each(data,function(i){
            message += '<li>' + data[i] + '</li>';
        });
        $('#news').html(message);
    }
);
});
<?php if ($this->_var['dangerous_apps']): ?>
var dangerous_apps = '';
<?php $_from = $this->_var['dangerous_apps']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'da');if (count($_from)):
    foreach ($_from AS $this->_var['da']):
?>
dangerous_apps += "<?php echo $this->_var['da']; ?>\r\n";
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
alert(dangerous_apps);
<?php endif; ?>
</script>
<div id="rightTop">
<p>
    ���ã�<b><?php echo $this->_var['admin']['user_name']; ?></b>����ӭʹ�� ECMall��
    <!--[ <a target="_blank" href="<?php echo $this->_var['site_url']; ?>/index.php?app=message&amp;act=inbox" class="tidings">����Ϣ</a>: <?php echo $this->_var['new']['total']; ?> ]
-->    ���ϴε�¼��ʱ���� <?php echo local_date("Y-m-d H:i:s",$this->_var['admin']['last_login']); ?> ��IP �� <?php echo $this->_var['admin']['last_ip']; ?>
</p>
</div>
<dl id="rightCon">
<?php if ($this->_var['dangerous_apps']): ?>
<dt>���棡����</dt>
<dd>
    <ul style="color:red; font-weight:bold;">
        <?php $_from = $this->_var['dangerous_apps']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'da');if (count($_from)):
    foreach ($_from AS $this->_var['da']):
?>
        <li><?php echo $this->_var['da']; ?></li>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </ul>
</dd>
<?php endif; ?>
<dt>ECMall ��̬</dt>
<dd>
    <ul id="news">
    </ul>
</dd>
<?php if ($this->_var['remind_info']): ?>
<dt>վ������</dt>
<dd>
    <ul>
        <?php $_from = $this->_var['remind_info']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'remind');if (count($_from)):
    foreach ($_from AS $this->_var['remind']):
?>
        <li><?php echo $this->_var['remind']; ?></li>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </ul>
</dd>
<?php endif; ?>
<dt>һ�ܶ�̬</dt>
<dd>
    <table>
        <tr>
            <th>������Ա��:</th>
            <td class="td"><?php echo $this->_var['news_in_a_week']['new_user_qty']; ?></td>
            <th>����������/������:</th>
            <td class="td"><?php echo $this->_var['news_in_a_week']['new_store_qty']; ?>/<?php echo $this->_var['news_in_a_week']['new_apply_qty']; ?></td>
        </tr>
        <tr>
            <th>������Ʒ��:</th>
            <td class="td"><?php echo $this->_var['news_in_a_week']['new_goods_qty']; ?></td>
            <th>����������:</th>
            <td class="td"><?php echo $this->_var['news_in_a_week']['new_order_qty']; ?></td>
        </tr>
    </table>
</dd>
<dt>ͳ����Ϣ</dt>
<dd>
    <table>
        <tr>
            <th>��Ա����:</th>
            <td class="td"><?php echo $this->_var['stats']['user_qty']; ?></td>
            <th>��������/��������:</th>
            <td class="td"><?php echo $this->_var['stats']['store_qty']; ?>/<?php echo $this->_var['stats']['apply_qty']; ?></td>
        </tr>
        <tr>
            <th>��Ʒ����:</th>
            <td class="td"><?php echo $this->_var['stats']['goods_qty']; ?></td>
            <th>��������:</th>
            <td class="td"><?php echo $this->_var['stats']['order_qty']; ?></td>
        </tr>
        <tr>
            <th>�����ܽ��:</th>
            <td class="td"><?php echo price_format($this->_var['stats']['order_amount']); ?></td>
            <th></th>
            <td class="td"></td>
        </tr>
    </table>
</dd>
<dt>ϵͳ��Ϣ</dt>
<dd>
    <table>
        <tr>
            <th>����������ϵͳ:</th>
            <td class="td"><?php echo $this->_var['sys_info']['server_os']; ?></td>
            <th>WEB ������:</th>
            <td class="td"><?php echo $this->_var['sys_info']['web_server']; ?></td>
        </tr>
        <tr>
            <th>PHP �汾:</th>
            <td class="td"><?php echo $this->_var['sys_info']['php_version']; ?></td>
            <th>MYSQL �汾:</th>
            <td class="td"><?php echo $this->_var['sys_info']['mysql_version']; ?></td>
        </tr>
        <tr>
            <th>ECMall �汾:</th>
            <td class="td"><?php echo $this->_var['sys_info']['ecmall_version']; ?></td>
            <th>��װ����:</th>
            <td class="td"><?php echo $this->_var['sys_info']['install_date']; ?></td>
        </tr>
    </table>
</dd>
</dl>
<?php echo $this->fetch('footer.html'); ?>
