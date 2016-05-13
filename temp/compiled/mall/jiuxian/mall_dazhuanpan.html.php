<?php echo $this->fetch('header.html'); ?>
<!--[if lte IE 6]>
<style type="text/css">
.ie6_width{width:870px; margin:0 auto; position:relative; z-index:99999; font-size:14px; font-family:"宋体"，arial}  
#ie6-warning{width:870px; margin:50px auto 0; text-indent:14px; background:#FFf; position:absolute;top:0; left:0;line-height:35px; color:#333;padding:0 10px; border:2px solid #0066FF;text-align:center}  
#ie6-warning img{float:right; cursor:pointer; margin-top:10px;} 
#ie6-warning a{text-decoration:none; color:#ff0000;}  
</style>
<div class="ie6_width">
<div id="ie6-warning"> 
<img src="/themes/mall/default/styles/new/images/icox.gif"  width="15" height="13" onclick="closeme();" alt="关闭提示" />您使用的IE浏览器版本过低,安全性低,有可能出现无法登陆或重新登陆的问题,影响网页性能,为更好的浏览本页,建议您将浏览器升级到 <a href="http://www.microsoft.com/china/windows/internet-explorer/ie8howto.aspx" target="_blank">IE8</a> 或使用以下浏览器：<a href="http://www.firefox.com.cn/download/">Firefox</a> / <a href="http://www.google.cn/chrome">Chrome</a> 
</div>  
</div>
<script type="text/javascript">  
function closeme() 
{ 
   var div = document.getElementById("ie6-warning"); 
   div.style.display ="none"; 
} 
function position_fixed(el, eltop, elleft){  

// check if this is IE6  

if(!window.XMLHttpRequest)  

window.onscroll = function(){  

el.style.top = (document.documentElement.scrollTop + eltop)+"px";  

el.style.left = (document.documentElement.scrollLeft + elleft)+"px";  

}  

else el.style.position = "fixed";  

}  

position_fixed(document.getElementById("ie6-warning"),0, 0);  

</script>  

<![endif]-->  

 
<link href="<?php echo $this->res_base . "/" . 'css/zp_index.css'; ?>" rel="stylesheet" type="text/css" />
<div class="yl_fgx_main">
  <div class="marg clearfix">
    <div class="yl_cj_left fl">
      <div class="yl_cj_fx">
        <p>好东西大家分享，赶快告诉你的朋友吧！</p>
        <p>
        <div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare"> <span class="bds_more">分享到：</span> <a class="bds_qzone"></a> <a class="bds_tsina"></a> <a class="bds_tqq"></a> <a class="bds_renren"></a> <a class="bds_t163"></a> <a class="shareCount"></a> </div>
        <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=324849" ></script> 
        <script type="text/javascript" id="bdshell_js"></script> 
        <script type="text/javascript">
                    document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
                    </script> 
        
        </p>
      </div>
      <div class="yl_cj_cyrs">已有<em>21014</em>人参与</div>
      <div class="yl_cj_main">
		 <!--[if !IE]><!-->
		<object data="/Main.swf?aresConfig=app/ares.xml" type="application/x-shockwave-flash" id="roulette" height="407px" width="407px" >
		<!-- <![endif]-->
		<!--[if IE]>
		<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=10,0,0,0" width="407px" height="407px" id="roulette">
		<param name="movie" value="/Main.swf?aresConfig=app/ares.xml" />
		<![endif]-->
			<param name="quality" value="high">
			<param value="always" name="allowScriptAccess">
			<param value="transparent" name="wmode">
			<param value="count=8" name="flashVars">
		</object>
	  </div>
    </div>
    <div class="yl_cj_right fl">
      <div class="yl_zjmd">
        <div class="yl_zjmd_m"> <strong>最新中奖动态</strong> <span><em>奖品</em><i>中奖用户</i><b>中奖时间</b></span>
          <div id="yl_demo" style="overflow:hidden;height:240px;width:286px;">
			
				<ul id="yl_demo1">
                 <?php $_from = $this->_var['zhongjiang_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'val');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['val']):
?>
				 				  <li class="clearfix"><em><?php echo htmlspecialchars($this->_var['val']['title']); ?></em><i><?php echo htmlspecialchars($this->_var['val']['user_name']); ?></i><b><?php echo local_date("Y-m-d",$this->_var['val']['time']); ?></b></li>
                                   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				   
				  				 
				  				</ul>			
				 <ul id="yl_demo2"></ul>
          </div>
        </div>
      </div>
      <div class="yl_cj_hdgz"> <strong>活动规则说明</strong>
        <p>1. 每次抽奖需要消耗<em>100</em>积分，每天不限抽奖次数。</p>
        <p>2. 您可通过"抽奖记录"查询您的中奖信息。</p>
        <p>3. 实物奖励<em>3-5</em>天发放,（注：如未填写收货地址，将不予发放实物奖励）</p>
        <p>4. 以上抽奖规则最终解释权归有啦所有！</p>
      </div>
    </div>
  </div>
</div>
	<script> 
var speed=40 
var demo=document.getElementById("yl_demo"); 
var demo2=document.getElementById("yl_demo2"); 
var demo1=document.getElementById("yl_demo1"); 
demo2.innerHTML=demo1.innerHTML 
function Marquee(){ 
if(demo2.offsetHeight-demo.scrollTop<=0) 
  demo.scrollTop-=demo1.offsetHeight 
else{ 
  demo.scrollTop++ 
} 
} 
var MyMar=setInterval(Marquee,speed) 
demo.onmouseover=function() {clearInterval(MyMar)} 
demo.onmouseout=function() {MyMar=setInterval(Marquee,speed)} 
</script>
<?php echo $this->fetch('footer.html'); ?>
 
