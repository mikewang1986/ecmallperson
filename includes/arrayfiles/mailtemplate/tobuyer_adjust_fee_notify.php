<?php
return array (
  'version' => '1.0',
  'subject' => '{$site_name}����:����{$order.seller_name}���������Ķ�������',
  'content' => '<p>�𾴵�{$order.buyer_name}:</p>
<p style="padding-left: 30px;">�������׵ĵ���{$order.seller_name}��������������Ϊ{$order.order_sn}�Ķ����ķ��ã�������ʱ���</p>
<p style="padding-left: 30px;">�鿴������ϸ��Ϣ������������</p>
<p style="padding-left: 30px;"><a href="{$site_url}/index.php?app=buyer_order&amp;act=view&amp;order_id={$order.order_id}">{$site_url}/index.php?app=buyer_order&amp;act=view&amp;order_id={$order.order_id}</a></p>
<p style="text-align: right;">{$site_name}</p>
<p style="text-align: right;">{$mail_send_time}</p>',
);
?>