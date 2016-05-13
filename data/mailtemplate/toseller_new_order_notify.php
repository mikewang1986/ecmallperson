<?php 
return array (
  'version' => '1.0',
  'subject' => '{$site_name}提醒:您有一个新订单需要处理',
  'content' => '<p>
<p>尊敬的{$order.seller_name}:</p>
<p>您的新订单号为{$order.order_sn}，请尽快处理。</p>
<p>总价:￥{$order.order_amount}{$response}<br />备注:{$order.postscript}<br />下单时间:{$mail_send_time}</p>
<p>查看订单详细信息请点击以下链接</p>
<p><a href="{$site_url}/index.php?app=seller_order&amp;act=view&amp;order_id={$order.order_id}">{$site_url}/index.php?app=seller_order&amp;act=view&amp;order_id={$order.order_id}</a></p>
<p>查看您的订单列表管理页请点击以下链接</p>
<p><a href="{$site_url}/index.php?app=seller_order">{$site_url}/index.php?app=seller_order</a></p>
<p>{$site_name}</p>
<p style="text-align: right;">{$mail_send_time}</p>
</p>',
);
?>