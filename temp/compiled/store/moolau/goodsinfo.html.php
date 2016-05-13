<script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'goodsinfo.js'; ?>" charset="utf-8"></script>
<script type="text/javascript">
//<!CDATA[
/* buy */
function buy()
{
	//要登录以后才能把商品加入购物车
	var status='<?php echo $this->_var['visitor']['user_id']; ?>';
	if(status == 0)
	{
		confirm('需要先登陆才能购买商品',window.location.href='<?php echo url('app=member&act=login'); ?>');
		return false;
	}
	//
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
    if (parseInt(quantity) < 1 || isNaN(quantity))
    {
        alert(lang.invalid_quantity);
        return;
    }
    add_to_cart(spec_id, quantity);
}

/* add cart */
function add_to_cart(spec_id, quantity)
{
    var url = SITE_URL + '/index.php?app=cart&act=add';
    $.getJSON(url, {'spec_id':spec_id, 'quantity':quantity}, function(data){
        if (data.done)
        {
            $('.bold_num').text(data.retval.cart.kinds);
            $('.bold_mly').html(price_format(data.retval.cart.amount));
            $('.ware_cen').slideDown('slow');
            setTimeout(slideUp_fn, 5000);
			
        }
        else
        {
            alert(data.msg);
        }
    });
}

/*buy_now*/
function buy_now()
{
    //验证数据
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
    if (parseInt(quantity) < 1 || isNaN(quantity))
    {
        alert(lang.invalid_quantity);
        return;
    }
    buy_now_add_cart(spec_id, quantity);
}

/* add buy_now_add_cart */
function buy_now_add_cart(spec_id, quantity)
{
    var url = SITE_URL + '/index.php?app=cart&act=add';
    $.getJSON(url, {'spec_id':spec_id, 'quantity':quantity}, function(data){
		if (data.done)
        {
			location.href= SITE_URL + '/index.php?app=order&goods=cart&store_id=<?php echo $this->_var['goods']['store_id']; ?>';
        }else{
            alert(data.msg);
        }
    });
}

var specs = new Array();
<?php $_from = $this->_var['goods']['_specs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'spec');if (count($_from)):
    foreach ($_from AS $this->_var['spec']):
?>
<?php if ($this->_var['spec']['is_pro']): ?>
specs.push(new spec(<?php echo $this->_var['spec']['spec_id']; ?>, '<?php echo htmlspecialchars($this->_var['spec']['spec_1']); ?>', '<?php echo htmlspecialchars($this->_var['spec']['spec_2']); ?>', <?php echo $this->_var['spec']['price']; ?>, <?php echo $this->_var['spec']['stock']; ?>,<?php echo $this->_var['spec']['pro_price']; ?>,true));
<?php else: ?>
specs.push(new spec(<?php echo $this->_var['spec']['spec_id']; ?>, '<?php echo htmlspecialchars($this->_var['spec']['spec_1']); ?>', '<?php echo htmlspecialchars($this->_var['spec']['spec_2']); ?>', <?php echo $this->_var['spec']['price']; ?>, <?php echo $this->_var['spec']['stock']; ?>,0,false));
<?php endif; ?>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
var specQty = <?php echo $this->_var['goods']['spec_qty']; ?>;
var defSpec = <?php echo htmlspecialchars($this->_var['goods']['default_spec']); ?>;
var goodsspec = new goodsspec(specs, specQty, defSpec);
//]]>
</script>
<style type="text/css">
.vip_price{display:inline-block;font-style:normal;background-color: #fff5f5;border: 1px solid #fdd;border-radius: 8px;color: #b10000;height: 16px;line-height: 16px;margin: 0 8px 0 0;padding: 0 5px;}
.desc{font-style:normal;}
.ju-desc {border-bottom:1px solid #EFEFEF; border-top:1px solid #EFEFEF; padding: 10px 0;}
.ju-desc p{font-size:14px; line-height:25px; color:#666;}
.ju-desc a{color:#0066CC; font-weight:700; text-decoration:none;}
.promo-price-type{border:1px solid #E3C8BD; color:#B68571;padding:2px 3px 2px 3px; border-radius:2px; font-style:normal}
.promo-price{color:#BB000D; font-size:24px; font-family:Arial,Helvetica,sans-serif; vertical-align:middle; font-weight:700;padding-left:5px;}
.price-del{font-size:15px}
.price-normal{font-family:Arial;color:#FF543A;font-size:16px;font-weight:bold}
sub.two{padding-left:12px; padding-right:12px;}
</style>
<h2 class="ware_title"><?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?></h2>

<div class="ware_info clearfix">
    <div class="ware_pic">
        <div class="big_pic">
            <a href="javascript:;"><span class="jqzoom"><img src="<?php echo ($this->_var['goods']['_images']['0']['thumbnail'] == '') ? $this->_var['default_image'] : $this->_var['goods']['_images']['0']['thumbnail']; ?>" width="310" height="310" jqimg="<?php echo $this->_var['goods']['_images']['0']['image_url']; ?>" /></span></a>
        </div>

        <div class="bottom_btn">
            <!--<a class="collect" href="javascript:collect_goods(<?php echo $this->_var['goods']['goods_id']; ?>);" title="收藏该商品"></a>-->
            <div class="left_btn"></div>
            <div class="right_btn"></div>
            <div class="ware_box">
                <ul>
                    <?php $_from = $this->_var['goods']['_images']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods_image');$this->_foreach['fe_goods_image'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_goods_image']['total'] > 0):
    foreach ($_from AS $this->_var['goods_image']):
        $this->_foreach['fe_goods_image']['iteration']++;
?>
                    <li <?php if (($this->_foreach['fe_goods_image']['iteration'] <= 1)): ?>class="ware_pic_hover"<?php endif; ?> bigimg="<?php echo $this->_var['goods_image']['image_url']; ?>"><img src="<?php echo $this->_var['goods_image']['thumbnail']; ?>" width="40" height="40" /></li>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </ul>
            </div>
        </div>
        <script>
            $(function(){
                var btn_list_li = $("#btn_list > li");
                btn_list_li.hover(function(){
                    $(this).find("ul:not(:animated)").slideDown("fast");
                },function(){
                    $(this).find("ul").slideUp("fast");
                });
            });
        </script>
        <?php if ($this->_var['share']): ?>
        <ul id="btn_list">
            <li id="btn_list1" title="收藏该商品">
                <ul class="drop_down">
                    <?php $_from = $this->_var['share']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
                    <?php if ($this->_var['item']['type'] == 'collect'): ?><li><?php if ($this->_var['item']['logo']): ?><img src="<?php echo $this->_var['item']['logo']; ?>" /><?php endif; ?><a target="_blank" href="<?php echo $this->_var['item']['link']; ?>"><?php echo htmlspecialchars($this->_var['item']['title']); ?></a></li><?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </ul>
            </li>
            <li id="btn_list2" title="分享该商品">
                <ul class="drop_down">
                    <?php $_from = $this->_var['share']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
                    <?php if ($this->_var['item']['type'] == 'share'): ?><li><?php if ($this->_var['item']['logo']): ?><img src="<?php echo $this->_var['item']['logo']; ?>" /><?php endif; ?><a target="_blank" href="<?php echo $this->_var['item']['link']; ?>"><?php echo htmlspecialchars($this->_var['item']['title']); ?></a></li><?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </ul>
            </li>
        </ul>
        <?php endif; ?>
    </div>

    <div class="ware_text">
        <div class="rate">
               <div id="is_pro"<?php if (! $this->_var['goods']['_specs']['0']['is_pro']): ?>style="display:none"<?php endif; ?>>
               		<span>价<sub class="two"></sub>格：</span>
               		<span ectype="goods_price"><del class="price-del"><?php echo price_format($this->_var['goods']['_specs']['0']['price']); ?></del></span><br />
                  	<span>促<sub class="two"></sub>销：</span>
                    <?php if ($this->_var['visitor']['user_id']): ?>
                    <em class="promo-price-type" title="<?php echo $this->_var['goods']['pro_desc']; ?>"><?php echo $this->_var['goods']['pro_name']; ?></em>
                    <span class="promo-price" ectype="goods_pro_price"><?php echo price_format($this->_var['goods']['_specs']['0']['pro_price']); ?></span>
                    <?php else: ?>
                    <em class="promo-price-type" title="<?php echo $this->_var['goods']['pro_desc']; ?>">登录后查看是否享受该优惠</em>
                    <?php endif; ?>
               </div>
               
               <div id="not_pro" <?php if ($this->_var['goods']['_specs']['0']['is_pro']): ?> style="display:none"<?php endif; ?>>
               		<span>价<sub class="two"></sub>格：</span>
                    <span class="price-normal" ectype="goods_price"><?php echo price_format($this->_var['goods']['_specs']['0']['price']); ?></span>
               </div>
               
               
			   
            <span>品<sub class="two"></sub>牌：</span><?php echo htmlspecialchars($this->_var['goods']['brand']); ?><br />
            <span>标签(TAG)：</span><span><?php $_from = $this->_var['goods']['tags']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'tag');if (count($_from)):
    foreach ($_from AS $this->_var['tag']):
?><?php echo $this->_var['tag']; ?>&nbsp;&nbsp;&nbsp;<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?></span><br />
            <span>销售情况：</span><span><?php echo $this->_var['sales_info']; ?><?php echo $this->_var['comments']; ?></span><br />
            <span>所在地区：</span><span><?php echo htmlspecialchars($this->_var['store']['region_name']); ?><br/>
            <?php echo $this->_var['goods']['scan_code']; ?><br/>
            <span style="color:blue;font-weight:bold">微信扫描二维码通过手机购买</span>
        </div>
        <div class="handle">
            <?php if ($this->_var['goods']['spec_qty'] > 0): ?>
            <ul>
                <li class="handle_title"><?php echo htmlspecialchars($this->_var['goods']['spec_name_1']); ?>：</li>
            </ul>
            <?php endif; ?>
            <?php if ($this->_var['goods']['spec_qty'] > 1): ?>
            <ul>
                <li class="handle_title"><?php echo htmlspecialchars($this->_var['goods']['spec_name_2']); ?>：</li>
            </ul>
            <?php endif; ?>
            <ul>
                <li class="handle_title">购买数量：</li>
                <li>
                    <input type="text" class="text width1" name="" id="quantity" value="1" style=" background:#fff;" />
                    件（库存<span class="stock" ectype="goods_stock"><?php echo $this->_var['goods']['_specs']['0']['stock']; ?></span>件）
                </li>
            </ul>
            <?php if ($this->_var['goods']['spec_qty'] > 0): ?>
            <ul>
                <li class="handle_title">您已选择：</li>
                <li class="aggregate" ectype="current_spec"></li>
            </ul>
            <?php endif; ?>
            <div style="clear:both; height:0; display:block; overflow:hidden;"></div>
        </div>
        <script>
			$(function(){
				$('.handle').hover(function(){
					$(this).addClass('handle-hover');
				},function(){
					$(this).removeClass('handle-hover');
				});
			});
		</script>

        <ul class="ware_btn">
            <div class="ware_cen" style="display:none">
                <div class="ware_center">
                    <h1>
                        <span class="dialog_title">商品已成功添加到购物车</span>
                        <span class="close_link" title="关闭" onmouseover="this.className = 'close_hover'" onmouseout="this.className = 'close_link'" onclick="slideUp_fn();"></span>
                    </h1>
                    <div class="ware_cen_btn">
                        <p class="ware_text_p">购物车内共有 <span class="bold_num">3</span> 种商品 共计 <span class="bold_mly">658.00</span></p>
                        <p class="ware_text_btn">
                            <input type="submit" class="btn1" name="" value="查看购物车" onclick="location.href='<?php echo $this->_var['site_url']; ?>/index.php?app=cart'" />
                            <input type="submit" class="btn2" name="" value="继续挑选商品" onclick="$('.ware_cen').css({'display':'none'});" />
                        </p>
                    </div>
                </div>
                <div class="ware_cen_bottom"></div>
            </div>
            <?php if ($this->_var['ju']['state'] == 1 && $this->_var['ju']['status'] == 1): ?>
            <div class="ju-desc">
            	<p>您只有在聚划算页面点击“参团”，才可享受此商品的优惠价格，<a href="<?php echo url('app=ju&act=show&id=' . $this->_var['ju']['group_id']. ''); ?>">点此进入</a></p>
            </div>
            <?php else: ?>
            <li class="btn_c1" title="立刻购买"><a href="javascript:buy_now();"></a></li>
            <li class="btn_c2" title="加入购物车"><a href="javascript:buy();"></a></li>
            <!--<li class="btn_c3" title="收藏该商品"><a href="javascript:collect_goods(<?php echo $this->_var['goods']['goods_id']; ?>);"></a></li>-->
            <?php endif; ?>
        </ul>
    </div>

</div>