<?php
return array (
  'version' => '1.0',
  'subject' => '{$site_name}����:{$user.user_name}�޸���������',
  'content' => '<p>�𾴵�{$user.user_name}:</p>
<p style="padding-left: 30px;">����, ���ղ��� {$site_name} �������������룬������������ӽ������ã�</p>
<p style="padding-left: 30px;"><a href="{$site_url}/index.php?app=find_password&act=set_password&id={$user.user_id}&activation={$word}">{$site_url}/index.php?app=find_password&act=set_password&id={$user.user_id}&activation={$word}</a></p>
<p style="padding-left: 30px;">������ֻ��ʹ��һ��, ���ʧЧ����������. ������������޷�������뽫�������������(����IE)�ĵ�ַ���С�</p>
<p style="text-align: right;">{$site_name}</p>
<p style="text-align: right;">{$mail_send_time}</p>',
);
?>