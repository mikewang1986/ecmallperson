

<script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'goodsinfo.js'; ?>" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'ecmall.js'; ?>" charset="utf-8"></script>
<script type="text/javascript">
//<!CDATA[
    /* buy */
    function buy()
    {
        if (goodsspec.getSpec() == null)
        {
            alert(lang.select_specs);
            return;
        }
        var spec_id = goodsspec.getSpec().id;

        var quantity = $("#quantity").val();
        if (quantity == '')
        {
            alert(lang.input_quantity);
            return;
        }
        if (parseInt(quantity) < 1)
        {
            alert(lang.invalid_quantity);
            return;
        }

        add_to_cart(spec_id, quantity);
    }

    /* add cart */
    function add_to_cart(spec_id, quantity)
    {
        var url = 'index.php?app=cart&act=add';

        $.getJSON(url, {'spec_id': spec_id, 'quantity': quantity}, function(data) {
            if (data.done)
            {
                $('.bold_num').text(data.retval.cart.kinds);
                $('.bold_mly').html(price_format(data.retval.cart.amount));
                $(".buynow .msg").slideDown().delay(5000).slideUp();
                // $('.msg').slideDown('slow');
                // setTimeout(slideUp_fn, 5000);
            }
            else
            {
                alert(data.msg);
            }
        });
    }

    function to_shop()
    {
        if (goodsspec.getSpec() == null)
        {
            alert(lang.select_specs);
            return;
        }
        var spec_id = goodsspec.getSpec().id;

        var quantity = $("#quantity").val();
        if (quantity == '')
        {
            alert(lang.input_quantity);
            return;
        }
        if (parseInt(quantity) < 1)
        {
            alert(lang.invalid_quantity);
            return;
        }

        add_to_shop(spec_id, quantity);
    }
    function add_to_shop(spec_id, quantity)
    {
        var url = 'index.php?app=cart&act=add';

        $.getJSON(url, {'spec_id': spec_id, 'quantity': quantity}, function(data) {
            if (data.done)
            {
                window.location.href = 'index.php?app=cart';
                // $('.bold_num').text(data.retval.cart.kinds);
                // $('.bold_mly').html(price_format(data.retval.cart.amount));
                // $(".buynow .msg").slideDown().delay(5000).slideUp();
            }
            else
            {
                alert(data.msg);
            }
        });
    }



var specs = new Array();
<?php $_from = $this->_var['goods']['_specs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'spec');if (count($_from)):
    foreach ($_from AS $this->_var['spec']):
?>
specs.push(new spec(<?php echo $this->_var['spec']['spec_id']; ?>, '<?php echo htmlspecialchars($this->_var['spec']['spec_1']); ?>', '<?php echo htmlspecialchars($this->_var['spec']['spec_2']); ?>', <?php echo $this->_var['spec']['price']; ?>, <?php echo $this->_var['spec']['stock']; ?>));
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
var specQty = <?php echo $this->_var['goods']['spec_qty']; ?>;
var defSpec = <?php echo htmlspecialchars($this->_var['goods']['default_spec']); ?>;
var goodsspec = new goodsspec(specs, specQty, defSpec);
//]]>
</script>
<div class="detail_img">
    <div id="slider" class="slider" >
        <ul id="sliderlist" class="sliderlist" >
            <?php $_from = $this->_var['goods']['_images']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods_image');$this->_foreach['fe_goods_image'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_goods_image']['total'] > 0):
    foreach ($_from AS $this->_var['goods_image']):
        $this->_foreach['fe_goods_image']['iteration']++;
?>
            <li><img src="<?php echo $this->_var['goods_image']['thumbnail']; ?>"></li>

            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </ul>
    </div>
    <script type="text/javascript">
        var t2 = new TouchSlider({id: 'sliderlist', speed: 600, timeout: 3000, before: function(index) {
            }});
    </script>
    <div class="fav">
        <a href="javascript:collect_goods(<?php echo $this->_var['goods']['goods_id']; ?>);">
            <img src="<?php echo $this->res_base . "/" . 'images/favorite.png'; ?>"/><span>收藏</span>
        </a>
    </div>
    <p class="line"></p>
</div>

<div class="detail_tit">
    <p><?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?></p>
    <p>品牌: <?php echo htmlspecialchars($this->_var['goods']['brand']); ?></p>
    <?php if (( $this->_var['goods']['pro_type'] == 'ugrade' && $this->_var['visitor']['user_id'] ) || $this->_var['goods']['pro_type'] != 'ugrade'): ?>
    <?php if ($this->_var['goods']['_specs']['0']['pro_price'] | price != 0): ?>
    <p>价格：<span ectype="goods_price"><del class="price-del"><?php echo price_format($this->_var['goods']['_specs']['0']['price']); ?></del></span></p>
    <p>促销：<em class="promo-price-type" title="<?php echo $this->_var['goods']['pro_desc']; ?>"><?php echo $this->_var['goods']['pro_name']; ?></em>
    <strong ectype="goods_price"><?php echo price_format($this->_var['goods']['_specs']['0']['pro_price']); ?></strong>
    <?php else: ?>
    <p>价格：<strong ectype="goods_price"><?php echo price_format($this->_var['goods']['_specs']['0']['price']); ?></strong></p>
    <?php endif; ?>
    <?php else: ?>
    <p>价格：<strong ectype="goods_price"><?php echo price_format($this->_var['goods']['_specs']['0']['price']); ?></strong></p>
    <em class="promo-price-type" title="<?php echo $this->_var['goods']['pro_desc']; ?>">登录查看您是否享有会员价</em>
    <?php endif; ?></p>
    <p>销量：<?php echo $this->_var['sales_info']; ?><?php echo $this->_var['comments']; ?></p>
    <p><span>所在地区：<?php echo htmlspecialchars($this->_var['store']['region_name']); ?></span></p>
    <?php if ($this->_var['shipping']): ?>
    <p>物流运费：
        <?php $_from = $this->_var['shipping']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'shippings');if (count($_from)):
    foreach ($_from AS $this->_var['shippings']):
?>
        <span><?php echo $this->_var['shippings']['shipping_name']; ?>：¥<?php echo $this->_var['shippings']['first_price']; ?></span>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </p>
    <?php endif; ?>
	<p>在线客服: <?php echo htmlspecialchars($this->_var['store']['tel']); ?> <a href="tel:<?php echo htmlspecialchars($this->_var['store']['tel']); ?>"><img src="<?php echo $this->res_base . "/" . 'images/tel.jpg'; ?>"></a>
<?php if ($this->_var['store']['im_qq']): ?><a href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo htmlspecialchars($this->_var['store']['im_qq']); ?>&amp;site=<?php echo htmlspecialchars($this->_var['store']['store_name']); ?>&amp;menu=yes" target="_blank"><img src="http://wpa.qq.com/pa?p=1:<?php echo htmlspecialchars($this->_var['store']['im_qq']); ?>:4" alt="QQ"></a> <?php endif; ?> <?php if ($this->_var['store']['im_ww']): ?><a target="_blank" href="http://amos.im.alisoft.com/msg.aw?v=2&uid=<?php echo urlencode($this->_var['store']['im_ww']); ?>&site=cntaobao&s=2&charset=<?php echo $this->_var['charset']; ?>" ><img border="0" src="http://amos.im.alisoft.com/online.aw?v=2&uid=<?php echo urlencode($this->_var['store']['im_ww']); ?>&site=cntaobao&s=2&charset=<?php echo $this->_var['charset']; ?>" alt="Wang Wang" /></a><?php endif; ?></p>
</div>

<div class="detail_size">
    <div class="size_con">
        <div class="handle">
            <?php if ($this->_var['goods']['spec_qty'] > 0): ?>
            <ul>
                <li class="handle_title"><?php echo htmlspecialchars($this->_var['goods']['spec_name_1']); ?>: </li><br />
            </ul>
            <?php endif; ?>
            <?php if ($this->_var['goods']['spec_qty'] > 1): ?>
            <ul>
                <li class="handle_title"><?php echo htmlspecialchars($this->_var['goods']['spec_name_2']); ?>: </li>
            </ul>
            <?php endif; ?>
            <ul class="quantity">
                <li class="handle_title">购买数量: </li>
                <li>
                    <input type="text" class="text width1" name="" id="quantity" value="1" />
                    件 （库存<span class="stock" ectype="goods_stock"><?php echo $this->_var['goods']['_specs']['0']['stock']; ?></span>件）
                </li>
            </ul>
            <?php if ($this->_var['goods']['spec_qty'] > 0): ?>
            <ul class="selected">
                <li class="handle_title">您已选择: </li>
                <li class="aggregate" ectype="current_spec"></li>
            </ul>
            <?php endif; ?>
        </div>
    </div>
    <div class="buynow">
        <a href="javascript:to_shop();" class="buy">立即购买</a><a href="javascript:buy();" class="add">加入购物车</a>
        <div class="msg" style="display:none;">
            <p><b></b>购物车内共有<span class="bold_num"></span>种商品 共计 <span class="bold_mly" style="color:#8D0303;"></span>！</p>
            <a href="<?php echo url('app=cart'); ?>" class="white_btn">查看购物车</a>
            <a  onclick="$('.msg').css({'display': 'none'});" class="white_btn">继续购物</a>
        </div>
    </div>

</div>