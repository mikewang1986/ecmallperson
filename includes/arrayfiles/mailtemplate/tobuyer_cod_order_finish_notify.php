<?php
return array (
  'version' => '1.0',
  'subject' => '{$site_name}����:����{$order.seller_name}ȷ���յ������Ļ��������ɣ�',
  'content' => '<p>�𾴵�{$order.buyer_name}:</p>
<p style="padding-left: 30px;">�������׵ĵ���{$order.seller_name}�Ѿ�ȷ���յ������Ļ��������{$order.order_sn}�ĸ��������ɣ������Ե��û�����-&gt;�ҵĶ����жԸý��׽������ۡ�</p>
<p style="padding-left: 30px;">�鿴������ϸ��Ϣ������������</p>
<p style="padding-left: 30px;"><a href="{$site_url}/index.php?app=buyer_order&amp;act=view&amp;order_id={$order.order_id}">{$site_url}/index.php?app=buyer_order&amp;act=view&amp;order_id={$order.order_id}</a></p>
<p style="padding-left: 30px;">�鿴�ҵĶ����б�������������</p>
<p style="padding-left: 30px;"><a href="{$site_url}/index.php?app=buyer_order">{$site_url}/index.php?app=buyer_order</a></p>
<p style="text-align: right;">{$site_name}</p>
<p style="text-align: right;">{$mail_send_time}</p>',
);
?>