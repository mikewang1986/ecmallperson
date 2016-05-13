<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<style type="text/css">
body, html,#allmap {width: 100%;height: 100%;overflow: hidden;margin:0;}
</style>
        <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=ZVVzW4tNokwGNt2P13ps8gz4"></script>
        <title>周边店铺</title>
    </head>
    <body>
        <div id="allmap"></div>
    </body>
</html>

<script type="text/javascript">

// 百度地图API功能
var map = new BMap.Map("allmap");
var point = new BMap.Point(116.331398,39.897445);
map.centerAndZoom(point,16);

var geolocation = new BMap.Geolocation();
geolocation.getCurrentPosition(function(r){
    if(this.getStatus() == BMAP_STATUS_SUCCESS){
        var mk = new BMap.Marker(r.point);
        map.addOverlay(mk);
        map.panTo(r.point);
//        alert('您的位置：'+r.point.lng+','+r.point.lat);
    }
    else {
        alert('failed'+this.getStatus());
    }        
},{enableHighAccuracy: true})








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
<?php if ($this->_var['store']['im_qq']): ?>"<p style='margin:0;line-height:1.5;font-size:13px;text-indent:2em'>电话：<?php echo htmlspecialchars($this->_var['store']['im_qq']); ?></p>" + <?php endif; ?>
<?php if ($this->_var['store']['goods_count']): ?>"<p style='margin:0;line-height:1.5;font-size:13px;text-indent:2em'>商品数量：<?php echo htmlspecialchars($this->_var['store']['goods_count']); ?></p>" + <?php endif; ?> 

"</div>";
var point = new BMap.Point(<?php echo htmlspecialchars($this->_var['store']['lng']); ?>, <?php echo htmlspecialchars($this->_var['store']['lat']); ?>);
addMarker(point,sContent);
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>










</script>











