
    <div class="kucont"><img src="/themes/mall/xiaomi/images/foot-banner.jpg" /></div>

    <div class="kucont">
        <div class="foot2">
            <p class="footpics">
			<img src="/themes/mall/xiaomi/images/foot1.jpg" />
			<img src="/themes/mall/xiaomi/images/foot2.jpg" />
			<img src="/themes/mall/xiaomi/images/foot3.jpg" />
			<img src="/themes/mall/xiaomi/images/foot4.jpg" />
			</p>
            <div class="clearfix"></div>
            <p>Copyright © 2015 琪琦网购微信商城 版权所有 <?php if ($this->_var['icp_number']): ?><?php echo $this->_var['icp_number']; ?><?php endif; ?> <?php echo $this->_var['statistics_code']; ?></p>
        </div>
    </div>



<div class="serv" style=" z-index:999;">
	<a href="http://wpa.qq.com/msgrd?v=1&uin=540616918&site=琪琦网购微信商城&menu=yes" target="_blank"><img src="/themes/mall/xiaomi/images/serv.jpg"></a>
	<span>在线咨询</span>
	<img src="/themes/mall/xiaomi/images/qr.jpg">
	<span>扫码关注微信</span>
</div>



<script src="/themes/mall/xiaomi/js/jquery.scrollToTop.min.js"></script>
    <a href="#top" id="toTop"></a>
    <script type="text/javascript">
            $(function() {
                $("#toTop").scrollToTop(400);
            });		
</script>
<?php if ($this->_var['index']): ?>
<script type="text/javascript">
function addFavorite2() {
    var a="<?php echo $this->_var['site_url']; ?>",b="<?php echo $this->_var['site_title']; ?>";document.all?window.external.AddFavorite(a,b):window.sidebar&&window.sidebar.addPanel?window.sidebar.addPanel(b,a,""):alert("\u60a8\u7684\u6d4f\u89c8\u5668\u4e0d\u652f\u6301\uff0c\u8bf7\u6309\u0063\u0074\u0072\u006c\u002b\u0064\u6536\u85cf\uff01"),createCookie("_fv","1",30,"/;domain=<?php echo $this->_var['site_url']; ?>")
}
</script>
<?php endif; ?>
</body>
</html>