<?php
return array (
  'version' => '1.0',
  'subject' => '{$site_name}����:����һ���¶�����Ҫ����',
  'content' => '<p>�𾴵�{$order.seller_name}:</p>
<p style="padding-left: 30px;">����һ���µĶ�����Ҫ������������{$order.order_sn}���뾡�촦����</p>
<p style="padding-left: 30px;">�鿴������ϸ��Ϣ������������</p>
<p style="padding-left: 30px;"><a href="{$site_url}/index.php?app=seller_order&amp;act=view&amp;order_id={$order.order_id}">{$site_url}/index.php?app=seller_order&amp;act=view&amp;order_id={$order.order_id}</a></p>
<p style="padding-left: 30px;">�鿴���Ķ����б�����ҳ������������</p>
<p style="padding-left: 30px;"><a href="{$site_url}/index.php?app=seller_order">{$site_url}/index.php?app=seller_order</a></p>
<p style="text-align: right;">{$site_name}</p>
<p style="text-align: right;">{$mail_send_time}</p>',
);
?>