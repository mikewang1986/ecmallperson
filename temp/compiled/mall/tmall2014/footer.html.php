<div id="footer" class="w-full">
    <div id="footer">
        <div class="ensure">
            <a></a>
            <a></a>
            <a></a>
            <a></a>
        </div>
        <div class="tmall-desc">
            <dl id="tmall-beginner"> 
                <dt>购物指南</dt>
                <dd>
                    <a href="index.php?app=article&act=view&article_id=6" target="_blank">怎么购物</a>
                    <a href="index.php?app=article&act=view&article_id=7" target="_blank">积分说明</a>
                    <a href="index.php?app=article&act=view&article_id=8" target="_blank">如何维权</a>
                    <a href="index.php?app=article&act=view&article_id=9" target="_blank">优惠劵使用</a>
                </dd>
            </dl>
            <dl id="tmall-safe">
                <dt>支付帮助</dt>
                <dd>
                    <a href="index.php?app=article&act=view&article_id=10" target="_blank">付款方式</a>
                    <a href="index.php?app=article&act=view&article_id=11" target="_blank">发票说明</a>
                    <a href="index.php?app=article&act=view&article_id=12" target="_blank">货到付款</a>
                    <a href="index.php?app=article&act=view&article_id=13" target="_blank">在线支付</a>
                </dd>
            </dl>
            <dl class="tmall-payment">
                <dt>消费保障</dt>
                <dd>
                    <a href="index.php?app=article&act=view&article_id=14" target="_blank">服务承诺</a>
                    <a href="index.php?app=article&act=view&article_id=15" target="_blank">配送说明</a>
                    <a href="index.php?app=article&act=view&article_id=16" target="_blank">售后上门</a>
                    <a href="index.php?app=article&act=view&article_id=17" target="_blank">买差赔付</a>
                    <a href="index.php?app=article&act=view&article_id=18" target="_blank">退换货说明</a>
                    <a href="index.php?app=article&act=view&article_id=19" target="_blank">退款政策</a>
                    <a href="index.php?app=article&act=view&article_id=20" target="_blank">退换货流程</a>
                </dd>
            </dl>
            <dl class="tmall-seller">
                <dt>商家服务</dt>
                <dd>
                    <a href="index.php?app=article&act=view&article_id=23" target="_blank">商家服务说明</a>
                    <a href="index.php?app=article&act=view&article_id=24" target="_blank">我要开店</a>
                    <a href="index.php?app=article&act=view&article_id=25" target="_blank">商家后台</a>
                    <div id="J_MerchantContainer"></div>
                </dd>
            </dl>
            <dl class="tmall-mobile">
                <dt>手机天猫</dt>
                <dd>
                    <a class="join">
                        <img src="http://gtms02.alicdn.com/tps/i2/TB1eYKSFpXXXXXCaVXXp4tRZFXX-105-105.jpg" width="105" height="105" alt="手机天猫"></a>
                </dd> 
            </dl>
        </div>
        <div class="footer-info">
            <div class="tmall-intro">
                <p id="tmall-info">
                    <a href="#">关于天猫</a>
                    <a href="#">帮助中心</a>
                    <a href="#">诚聘英才</a>
                    <a href="#">联系我们</a>
                    <a href="#">网站合作</a>
                    <a href="#">版权说明</a> 
                    廉正举报邮箱：lianzheng@taobao.com 
                </p>
                <p id="other-link">
                    <a href="#">阿里巴巴集团</a>| 
                    <a href="#">淘宝网</a> | 
                    <a href="#">天猫</a> | 
                    <a href="#">聚划算</a> | 
                    <a href="#">全球速卖通</a> | 
                    <a href="#">阿里巴巴国际交易市场</a>| 
                    <a href="#">1688</a> | 
                    <a href="#">阿里妈妈</a> | 
                    <a href="#">阿里云计算</a> | 
                    <a href="#">云OS</a> | 
                    <a href="#">万网</a> | 
                    <a href="#">淘宝旅行</a> | 
                    <a href="//www.alipay.com">支付宝</a>
                </p>
            </div>
            <div class="tmall-copyright">
                <span>增值电信业务经营许可证：<a data-spm-protocol="i" href="#">浙B2-888888</a></span>
                <span>网络文化经营许可证：<a href="#">浙网文[2012]88888号</a></span>
                互联网医疗保健信息服务 审核同意书 浙 卫网审【2014】6号<br>互联网药品信息服务资质证书编号：浙-（经营性）-2012-8888 
                <b>© 2003-2014 TMALL.COM 版权所有</b>
                <a style="display:block;width:36px;padding-top:10px;" target="_blank" href="#">
                    <img src="http://gtms01.alicdn.com/tps/i1/TB1L25iFFXXXXXcbpXXgBrbGpXX-36-36.png">
                </a>
            </div>
        </div>
    </div>








    <div class="mui-mbar-tabs clearfix">
        <div class="mui-mbar-tabs-mask ">
            <div class="mui-mbar-tab mui-mbar-tab-cart" style="top: 150px;">
                <div class="mui-mbar-tab-logo mui-mbar-tab-logo-cart"></div>
                <div class="mui-mbar-tab-txt"><a href="<?php echo url('app=cart'); ?>">购物车</a></div>
                <div class="mui-mbar-tab-sup">
                    <div class="mui-mbar-tab-sup-bg">
                        <div class="mui-mbar-tab-sup-bd"><?php echo $this->_var['cart_goods_kinds']; ?></div>
                    </div>
                </div>
            </div>
            <div class="mui-mbar-tab mui-mbar-tab-asset" style="top: 300px;">
                <div class="mui-mbar-tab-logo mui-mbar-tab-logo-asset"></div>
                <div class="mui-mbar-tab-tip" style="right: 35px;  display: none;">
                    <a href="<?php echo url('app=member'); ?>">我的资产</a>
                    <div class="mui-mbar-arr mui-mbar-tab-tip-arr">◆</div>
                </div>
            </div>
            <div class="mui-mbar-tab mui-mbar-tab-brand" style="top: 350px;">
                <div class="mui-mbar-tab-logo mui-mbar-tab-logo-brand"></div>
                <div class="mui-mbar-tab-tip" style="right: 35px;  display: none;">
                    <a href="<?php echo url('app=member'); ?>">我关注的品牌</a>
                    <div class="mui-mbar-arr mui-mbar-tab-tip-arr">◆</div>
                </div>
            </div>
            <div class="mui-mbar-tab mui-mbar-tab-foot" style="top: 400px;">
                <div class="mui-mbar-tab-logo mui-mbar-tab-logo-foot"></div>
                <div class="mui-mbar-tab-tip" style="right: 35px;  display: none;">
                    <a href="<?php echo url('app=member'); ?>">我看过的</a>
                    <div class="mui-mbar-arr mui-mbar-tab-tip-arr">◆</div>
                </div>
            </div>
            <div class="mui-mbar-tab mui-mbar-tab-favor" style="top: 450px;">
                <div class="mui-mbar-tab-logo mui-mbar-tab-logo-favor"></div>
                <div class="mui-mbar-tab-tip" style="right: 35px;  display: none;">
                    <a href="<?php echo url('app=member'); ?>">我看过的</a>
                    <div class="mui-mbar-arr mui-mbar-tab-tip-arr">◆</div>
                </div>
            </div>
            <div class="mui-mbar-tab mui-mbar-tab-top" style="bottom: 200px;" id="gotop">
                <div class="mui-mbar-tab-logo mui-mbar-tab-logo-top"></div>
                <div class="mui-mbar-tab-tip" style="right: 35px;  display: none;">
                    <a href="javascript:void(0)">返回顶部</a>
                    <div class="mui-mbar-arr mui-mbar-tab-tip-arr">◆</div>
                </div>
            </div>
            <div class="mui-mbar-tab mui-mbar-tab-qrcode" style="bottom: 250px;">
                <div class="mui-mbar-tab-logo mui-mbar-tab-logo-qrcode"></div>
                <div class="mui-mbar-tab-tip mui-mbarp-qrcode-tip" style="right: 35px;  display: none;">
                    <div class="mui-mbarp-qrcode-hd">
                        <img src="http://gtms03.alicdn.com/tps/i3/T1uu15FBxXXXamNNre-140-140.png" width="140" height="140">
                    </div>
                    <div class="mui-mbarp-qrcode-bd"><img src="http://gtms03.alicdn.com/tps/i3/T1OLK7FpdXXXbb5hfb-145-14.png"></div>
                </div>
            </div>
            <div class="mui-mbar-tab mui-mbar-tab-ue" style="bottom: 300px;">
                <div class="mui-mbar-tab-logo mui-mbar-tab-logo-ue"></div>
                <div class="mui-mbar-tab-tip" style="right: 35px;  display: none;">
                    <a href="#">用户反馈</a>
                    <div class="mui-mbar-arr mui-mbar-tab-tip-arr">◆</div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function() {
            var screen_height = window.screen.height;
            $(".mui-mbar-tabs-mask").css("height", screen_height);
            $('.mui-mbar-tab').hover(function() {
                $(this).addClass("mui-mbar-tab-hover");
                $(this).find('.mui-mbar-tab-tip').fadeIn(500);
            }, function() {
                $(this).removeClass("mui-mbar-tab-hover");
                $(this).find('.mui-mbar-tab-tip').fadeOut(500);
            });
        });

    </script>



</div>
</body>
</html>