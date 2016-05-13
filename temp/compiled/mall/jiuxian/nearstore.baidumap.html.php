<?php echo $this->fetch('header.html'); ?>


<link type="text/css" href="<?php echo $this->res_base . "/" . 'ditu/ecmall.css'; ?>" rel="stylesheet"  />
<script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'search_store.js'; ?>" charset="utf-8"></script>
<script type="text/javascript">
//<!CDATA[
$(function (){
	
    var order = '<?php echo $_GET['order']; ?>';
	var css = '';
	
	<?php if ($_GET['order']): ?>
	order_arr = order.split(' ');
	switch (order_arr[1]){
		case 'desc' : 
			css = 'order-down btn-order-cur';
		break;
		case 'asc' :
			css = 'order-up btn-order-cur';
		break;
		default : 
			css = 'order-down-gray';
	}
	$('.btn-order a[ectype='+order_arr[0]+']').attr('class','btn-order-click '+css);
	<?php endif; ?>
	
	$(".btn-order a").click(function(){
		if(this.id==''){
			dropParam('order');// default order
			return false;
		}
		else
		{
			dd = " desc";
			if(order != '') {
				order_arr = order.split(' ');
				if(order_arr[0]==this.id && order_arr[1]=="desc")
					dd = " asc";
				else dd = " desc";
			}
			replaceParam('order', this.id+dd);
			return false;
		}
	});
	
	$('.list-fields li .row_3 a').click(function(){
		var cl=$(this).attr('class');
		if(cl=='expand'){
			$(this).attr('class','fold');	
			$(this).html('pull_goods');
		}else{
			$(this).attr('class','expand');	
			$(this).html('expand_goods');
		}
		$(this).parent().parent().parent('.store-info').next('.store-goods').toggle();
	});
	
	$('.search-by .show-more').click(function(){
		$(this).parent().children().find('.toggle').toggle();
		if($(this).find('span').html()=='展开'){
			$(this).find('span').html('收起');
			$(this).children().children('i').css('background-position','0 -1488px');
		} else {
			$(this).find('span').html('展开');
			$(this).children().children('i').css('background-position','0 -1497px');
		}
	});
	
});

//]]>
</script>
<div id="main" class="w-full">
<div id="page-search-store" class="w mt10 mb10">  
<?php echo $this->fetch('curlocal.html'); ?>


<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=<?php echo $this->_var['baidu_ak']; ?>"></script>

<div class="content">
    <div class="left">
        <div class="module_sidebar">
            <h2><b>店铺分类</b></h2>
            <div class="wrap">
                <div class="wrap_child">
                    <?php $_from = $this->_var['scategorys']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'scategory');if (count($_from)):
    foreach ($_from AS $this->_var['scategory']):
?>
                    <dl class="sidebar_list">
                        <dt class="bg_color1"><a href="<?php echo url('app=nearstore&cate_id=' . $this->_var['scategory']['id']. ''); ?>"><?php echo htmlspecialchars($this->_var['scategory']['value']); ?></a></dt>
                        <?php $_from = $this->_var['scategory']['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'child');if (count($_from)):
    foreach ($_from AS $this->_var['child']):
?>
                        <dd><a href="<?php echo url('app=nearstore&cate_id=' . $this->_var['child']['id']. ''); ?>"><?php echo htmlspecialchars($this->_var['child']['value']); ?></a></dd>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </dl>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="right">
        <div id="allmap" style="margin-top:20px;width:780px;height:800px;"></div>
    </div>
</div>

    
    
    
    
    
    
    
    
    
    
    <script type="text/javascript">
// 百度地图API功能
                var map = new BMap.Map("allmap");

                var point = new BMap.Point(<?php echo $this->_var['member_info']['lng']; ?>, <?php echo $this->_var['member_info']['lat']; ?>);
                map.centerAndZoom(point, 12);

                map.addControl(new BMap.NavigationControl());
                map.enableScrollWheelZoom();                            //启用滚轮放大缩小


                var marker = new BMap.Marker(point);  // 创建标注
                map.addOverlay(marker);              // 将标注添加到地图中
                marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画
                



// 编写自定义函数,创建标注
function addMarker(point,sContent){
    
    
  var marker = new BMap.Marker(point);
  map.addOverlay(marker);
  
  
  

var marker = new BMap.Marker(point);
var infoWindow = new BMap.InfoWindow(sContent);  // 创建信息窗口对象
map.addOverlay(marker);
marker.addEventListener("click", function(){          
   this.openInfoWindow(infoWindow);
   //图片加载完毕重绘infowindow
   document.getElementById('imgDemo').onload = function (){
       infoWindow.redraw();   //防止在网速较慢，图片未加载时，生成的信息框高度比图片的总高度小，导致图片部分被隐藏
   }
});
  
  
  
  
  
  
}

<?php $_from = $this->_var['stores']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'store');if (count($_from)):
    foreach ($_from AS $this->_var['store']):
?>
// 百度地图API功能
var sContent =
"<h4 style='margin:0 0 5px 0;padding:0.2em 0'><a href='<?php echo url('app=store&id=' . $this->_var['store']['store_id']. ''); ?>' target='_blank'><?php echo htmlspecialchars($this->_var['store']['store_name']); ?></a></h4>" + 
"<a href='<?php echo url('app=store&id=' . $this->_var['store']['store_id']. ''); ?>' target='_blank'><img style='float:right;margin:4px' id='imgDemo' src='<?php echo $this->_var['store']['store_logo']; ?>' width='139' height='104' title='<?php echo htmlspecialchars($this->_var['store']['store_name']); ?>'/></a>" + 
"<p style='margin:0;line-height:1.5;font-size:13px;text-indent:2em;width:600px;'>距离：<?php echo $this->_var['store']['juli']; ?>km</p>" + 
<?php if ($this->_var['store']['address']): ?>"<p style='margin:0;line-height:1.5;font-size:13px;text-indent:2em'>位置：<?php echo htmlspecialchars($this->_var['store']['region_name']); ?><?php echo htmlspecialchars($this->_var['store']['address']); ?></p>" + <?php endif; ?>
<?php if ($this->_var['store']['tel']): ?>"<p style='margin:0;line-height:1.5;font-size:13px;text-indent:2em'>电话：<?php echo htmlspecialchars($this->_var['store']['tel']); ?></p>" + <?php endif; ?>
<?php if ($this->_var['store']['im_qq']): ?>"<p style='margin:0;line-height:1.5;font-size:13px;text-indent:2em'>QQ：<?php echo htmlspecialchars($this->_var['store']['im_qq']); ?></p>" + <?php endif; ?>
<?php if ($this->_var['store']['goods_count']): ?>"<p style='margin:0;line-height:1.5;font-size:13px;text-indent:2em'>商品数量：<?php echo htmlspecialchars($this->_var['store']['goods_count']); ?></p>" + <?php endif; ?> 

"</div>";
  var point = new BMap.Point(<?php echo htmlspecialchars($this->_var['store']['lng']); ?>, <?php echo htmlspecialchars($this->_var['store']['lat']); ?>);
  addMarker(point,sContent);
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>



            </script>
    
    

<?php echo $this->fetch('footer.html'); ?>