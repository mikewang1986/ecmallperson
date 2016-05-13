<?php echo $this->fetch('header.html'); ?>
<style type="text/css">
.w{width:1200px;margin:auto;}
.float-left {float: left;}
.clearfix:after {content: '20';display: block;overflow: hidden;height: 0;clear: both;}
.mb10{margin-bottom:10px;}
.mt10{margin-top:10px;}
a {color: #333;text-decoration:none;}
.search-type{border-bottom: 2px solid #EE3000;width:100%;height:28px;}
.search-type .btn-type a{display:block;float:left;height: 27px;line-height: 27px;font-size: 14px;padding:0px 20px;background: url('<?php echo $this->res_base . "/" . 'images/T1sHDgXkpeXXb0v4jv-150-450.png'; ?>') 0px -30px;background-repeat: no-repeat;border:1px solid #CCC;border-bottom:0;}
.search-type .btn-type a.current{background:#EE3000;border:1px solid #EE3000;color: white;font-weight: bold;border-bottom:0;}
#page-search-promotion .search-by{border:1px solid #D7D7D7;}
#page-search-promotion .search-by ul li{padding:5px 0px;border-bottom:1px dashed #D7D7D7;width:1198px;}
#page-search-promotion .search-by ul li h3{float:left;white-space: nowrap;font-size:12px;color: #333;margin-right:20px;font-weight:bold;background: url('<?php echo $this->res_base . "/" . 'images/index_sprites.gif'; ?>') -246px -9px no-repeat;padding:3px 10px 3px 0px;margin-left:20px;}
#page-search-promotion .search-by ul li a{float:left;display:block;font-size: 12px;margin-right:10px;color:#333;padding:3px 5px;}
#page-search-promotion .search-by ul li a:hover{background:#FEDED8;color:#780C00;}
#page-search-promotion .search-by ul li a.act{background:#C00;color:#FFF;}
#page-search-promotion .search-by ul li input{height:21px;width:150px;border:1px solid #D7D7D7;}
#page-search-promotion .search-by ul li button{height:23px;width:50px;margin-left:5px;}
#page-search-promotion .group-list ul{width:100%;padding-top:10px;padding-bottom:10px;}
#page-search-promotion .group-list li{float:left;width:286px;position:relative;border:1px #ccc solid;margin-right:16px;_margin-right:13px;_margin-bottom:20px;}
#page-search-promotion .group-list li:hover,#page-search-promotion .group-list .hover{border:1px #EE3000 solid}
#page-search-promotion .group-list .rec_ico{background:url('<?php echo $this->res_base . "/" . 'images/group_rec.gif'; ?>') no-repeat;width:40px; height:40px; position:absolute;right:-1px;top:-1px;}
#page-search-promotion .group-list .desc{padding:8px; height:40px; line-height:20px; overflow:hidden}
#page-search-promotion .group-list .desc a{font-size:14px;font-weight:bold;color:#333}
#page-search-promotion .group-list .desc a:hover{color:#EE3000; text-decoration:underline}
#page-search-promotion .group-list .pic{padding:9px;padding-top:0;}
#page-search-promotion .group-list .pic img{width:270px;height:200px;}
#page-search-promotion .group-list .buy{background:#EE3000; height:35px; font-weight:bold;line-height:35px;text-align:left;padding-left:10px; position:relative;color:#fff;font-size:16px}
#page-search-promotion .group-list .buy .price{font-family:Arial; font-weight:bold;font-size:26px;color:#fff;margin-right:20px;}
#page-search-promotion .group-list .buy a{ display:inline-block; position:absolute;right:10px;top:2px; background:url('<?php echo $this->res_base . "/" . 'images/index_sprite.gif'; ?>') no-repeat;width:75px; height:30px; overflow:hidden}
#page-search-promotion .group-list .extra{height:40px; line-height:40px; position:relative; overflow:hidden}
#page-search-promotion .group-list .extra .gray-bg{position:absolute;right:0;bottom:-13px;width:125px; height:12px; background:url(themes/mall/skin//images/index_sprites.gif) no-repeat right bottom; overflow:hidden;}
#page-search-promotion .group-list .extra span{margin-left:8px;}
#page-search-promotion .group-list .extra strong{color:#527A18;font-size:16px;margin-right:2px;}
#page-search-promotion .group-list .extra b{font-size:16px;color:#EE3000;margin-right:2px;}
</style>
<div id="main" class="w-full">
	<div id="page-search-promotion" class="w mt10 mb20">
		<?php echo $this->fetch('curlocal.html'); ?>
		<div class="w mt10">
			<div class="search-type clearfix">
				<div class="float-left btn-type">
					<a href="javascript:;" class="current">促销商品列表</a>
				</div>
				<?php echo $this->fetch('page.top.html'); ?>                              
			</div>
			<div class="group-list mt10 mb10 clearfix">
          		<ul class="clearfix">
                 	<?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['fe_goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_goods']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['fe_goods']['iteration']++;
?>
                 	<li class="item mb20" <?php if ($this->_foreach['fe_goods']['iteration'] % 4 == 0): ?> style="margin-right:0"<?php endif; ?>>
                 		<div class="desc"><a target="_blank" href="<?php echo url('app=goods&id=' . $this->_var['goods']['goods_id']. ''); ?>"><?php echo sub_str(htmlspecialchars($this->_var['goods']['goods_name']),60); ?></a></div>
                 		<div class="pic"><a target="_blank" href="<?php echo url('app=goods&id=' . $this->_var['goods']['goods_id']. ''); ?>"><img src="<?php echo $this->_var['goods']['default_image']; ?>" alt="<?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?>" /></a></div>
                    	<div class="buy"><span class="price"><?php echo price_format($this->_var['goods']['pro_price']); ?></span><del><?php echo $this->_var['goods']['price']; ?></del><a href="<?php echo url('app=goods&id=' . $this->_var['goods']['goods_id']. ''); ?>"></a></div>
                 	</li>
                 	<?php endforeach; else: ?>
                 	<div>没有促销商品</div>
                 	<?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
              	</ul>
				<?php echo $this->fetch('page.bottom.html'); ?>
       		</div>    
  		</div>
	</div>
</div>
<?php echo $this->fetch('footer.html'); ?>