<?php 
return array (
  'version' => '1.0',
  'subject' => '�����������{$coupon.store_name}���Ż�ȯ',
  'content' => '<p>�𾴵�{$user.user_name}��</p>
<p>&nbsp;&nbsp;&nbsp; ���ã���ϲ�������һ������{$coupon.store_name}���̵��Ż�ȯ��</p>
<p>&nbsp;&nbsp;&nbsp; �Żݽ�{$coupon.coupon_value|price}</p>
<p>&nbsp;&nbsp;&nbsp; ��Ч�ڣ�{$coupon.start_time|date}��{$coupon.end_time|date}</p>
<p>&nbsp;&nbsp;&nbsp; �Ż�ȯ���룺{$user.coupon.coupon_sn}</p>
<p>&nbsp;&nbsp;&nbsp; ʹ��������������{$coupon.min_amount|price}����ʹ��</p>
<p>&nbsp;&nbsp;&nbsp; ���̵�ַ��<a href="{$site_url}/index.php?app=store&amp;id={$coupon.store_id}">{$coupon.store_name}</a></p>
<p style="padding-left: 30px;">&nbsp;</p>
<p style="text-align: right;">��վ���ƣ�{$site_name}</p>
<p style="text-align: right;">���ڣ�{$mail_send_time}</p>',
);
?>