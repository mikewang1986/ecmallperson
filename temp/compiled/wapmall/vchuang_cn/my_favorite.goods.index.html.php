
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />
<?php echo $this->_var['page_seo']; ?>
<link href="<?php echo $this->res_base . "/" . 'css/common.css'; ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo $this->res_base . "/" . 'css/bookmark.css'; ?>" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'ecmall.js'; ?>" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'member.js'; ?>" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo $this->res_base . "/" . 'js/jquery-1.8.0.min.js'; ?>"></script>


</head>
<body class="gray">
<div class="w320">
    <div class="fixed">
        
        <div class="header header2">
			<a href="<?php echo url('app=buyer_order&act=index'); ?>" class="back2_pre"></a>
            我的收藏
        </div>  
    </div>
  
    <div class="mark"> 
     <ul class="bm_tab">
            <li class="cur"><a href="<?php echo url('app=my_favorite'); ?>">收藏商品</a></li>
            <li><a href="<?php echo url('app=my_favorite&type=store'); ?>">收藏店铺</a></li>
        </ul>
        
        <div class="bm_con">
            <div class="marklist">
                <ul>
				<?php $_from = $this->_var['collect_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['v'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['v']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['v']['iteration']++;
?>
                    <li>
                        <a href="<?php echo url('app=goods&id=' . $this->_var['goods']['goods_id']. ''); ?>"><img src="<?php echo $this->_var['goods']['default_image']; ?>" /></a>
                        <p><?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?></p>
                        <p>价格：<strong><?php echo price_format($this->_var['goods']['price']); ?></strong></p>
                         <p>收藏时间：<?php echo local_date("Y-m-d H:i:s",$this->_var['goods']['add_time']); ?></p>
                        <a href="javascript:drop_confirm('您确定要删除它吗？', 'index.php?app=my_favorite&amp;act=drop&type=goods&item_id=<?php echo $this->_var['goods']['goods_id']; ?>');" class="close"><img src="<?php echo $this->res_base . "/" . 'images/close.jpg'; ?>" style="border:none; width:20px;height:20px;margin:0 0 5px 0;" /></a>
                    </li>
                     <?php endforeach; else: ?>
                     <li>没有符合条件的商品</li>
					 <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </ul>
            </div>
        </div>
   		
        
    </div>
    
    
    
    <div class="page">
      <?php echo $this->fetch('member.page.bottom.html'); ?>
    </div>
</div>
<?php echo $this->fetch('member.footer.html'); ?>
