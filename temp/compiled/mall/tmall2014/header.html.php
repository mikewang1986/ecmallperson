<?php echo $this->fetch('top.html'); ?>
<div id="header" class="w-full">
    <div class="shop-t w clearfix pb10 mb5 mt5">
        <div class="logo">
            <a href="<?php echo $this->_var['site_url']; ?>" title="<?php echo $this->_var['site_title']; ?>"><img alt="<?php echo $this->_var['site_title']; ?>" src="<?php echo $this->_var['site_logo']; ?>" /></a>
        </div>
        <div class="top-search">
            <div class="top-search-box clearfix">
                <ul class="top-search-tab clearfix">
                    <li id="index" class="current"><span>商品</span></li>
                    <li id="store"><span>店铺</span></li>
                    <li id="groupbuy"><span>团购</span></li>
                </ul>
                <div class="form-fields">
                    <form method="GET" action="<?php echo url('app=search'); ?>">
                        <input type="hidden" name="app" value="search" />
                        <input type="hidden" name="act" value="<?php if ($_GET['act'] == 'store'): ?>store<?php elseif ($_GET['act'] == 'groupbuy'): ?>groupbuy<?php else: ?>index<?php endif; ?>" />
                        <input type="text"   name="keyword" value="<?php echo $_GET['keyword']; ?>" class="keyword <?php if (! $_GET['keyword']): ?>kw_bj <?php if ($_GET['act'] == 'store'): ?>store<?php elseif ($_GET['act'] == 'groupbuy'): ?>groupbuy<?php else: ?>index<?php endif; ?>_bj <?php endif; ?>" />
                        <input type="submit" value="搜索" class="submit" hidefocus="true" />
                    </form>
                </div>
            </div>
            <div class="top-search-keywords">
                <?php $_from = $this->_var['hot_keywords']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'keyword');$this->_foreach['fe_keyword'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_keyword']['total'] > 0):
    foreach ($_from AS $this->_var['keyword']):
        $this->_foreach['fe_keyword']['iteration']++;
?>
                <a <?php if ($this->_foreach['fe_keyword']['iteration'] % 3 == 1): ?>style="color:#c40000;"<?php endif; ?> href="<?php echo url('app=search&keyword=' . urlencode($this->_var['keyword']). ''); ?>"><?php echo $this->_var['keyword']; ?></a>|
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </div>
        </div>
        <div class="header_cart">
            <div class="title clearfix">
                <b></b><a href="<?php echo url('app=cart'); ?>">去购物车结算</a><em></em>
            </div>
            <div class="shoping"><span class="count-cart J_C_T_GoodsKinds"><?php echo $this->_var['cart_goods_kinds']; ?></span></div>
            <div class="cart-list">
                <?php if ($this->_var['carts_top']['cart_items']): ?>
                <div class="goods-list">
                    <h4>最新加入的商品</h4>
                    <?php $_from = $this->_var['carts_top']['cart_items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cart');$this->_foreach['fe_cart'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_cart']['total'] > 0):
    foreach ($_from AS $this->_var['cart']):
        $this->_foreach['fe_cart']['iteration']++;
?>
                    <div <?php if (($this->_foreach['fe_cart']['iteration'] == $this->_foreach['fe_cart']['total'])): ?>style="border:0px;"<?php endif; ?> class="clearfix list" id="cart_goods<?php echo $this->_var['cart']['rec_id']; ?>">
                        <div class="goods-img">
                            <a href="<?php echo url('app=goods&id=' . $this->_var['cart']['goods_id']. ''); ?>" target="_top"><img alt="<?php echo $this->_var['cart']['goods_name']; ?>" src="<?php echo $this->_var['cart']['goods_image']; ?>" width="40" height="40"></a>
                        </div>
                        <div class="goods-title">
                            <a title="<?php echo $this->_var['cart']['goods_name']; ?>" href="<?php echo url('app=goods&id=' . $this->_var['cart']['goods_id']. ''); ?>" target="_top"><?php echo $this->_var['cart']['goods_name']; ?></a>
                        </div>
                        <div class="goods-admin">
                            <div class="mini-cart-count"><strong class="mini-cart-price J_C_T_Price"><?php echo price_format($this->_var['cart']['price']); ?></strong> x <?php echo $this->_var['cart']['quantity']; ?></div>
                            <div class="mini-cart-del"><a href="javascript:;" onclick="drop_cart_item(<?php echo $this->_var['cart']['store_id']; ?>, <?php echo $this->_var['cart']['rec_id']; ?>);">删除</a></div>
                        </div>
                    </div>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </div>
                <div class="total">
                    <span>共<strong class="J_C_T_GoodsKinds"><?php echo $this->_var['cart_goods_kinds']; ?></strong>件商品</span><span>共计<strong class="J_C_T_Amount"><?php echo price_format($this->_var['carts_top']['total']); ?></strong></span><br />
                    <a href="<?php echo url('app=cart'); ?>">去购物车结算</a>
                </div>
                <?php else: ?>
                <div class="nogoods clearfix">
                    <b></b>购物车中还没有商品，赶紧选购吧！
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="w-full mall-nav" <?php if (! $this->_var['index']): ?>style="border-bottom: 3px solid #c40000"<?php endif; ?>>
        <ul class="w clearfix">
            <li class="allcategory float-left <?php if (! $this->_var['index']): ?>in_index<?php endif; ?>">
                <a class="allsort" href="<?php echo url('app=category'); ?>" target="_blank">商品服务分类</a>
                <div class="allcategory-list <?php if (! $this->_var['index']): ?>hidden<?php endif; ?>" area="gcategorys" widget_type="area">
                    <?php $this->display_widgets(array('page'=>'index','area'=>'gcategorys')); ?>
                </div>
            </li>

            <li class="each float-left inline-block"><a  href="<?php echo $this->_var['site_url']; ?>">首页</a></li>
            <?php $_from = $this->_var['navs']['middle']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'nav');if (count($_from)):
    foreach ($_from AS $this->_var['nav']):
?>
            <li class="each float-left inline-block"><a class="<?php if (! $this->_var['index'] && $this->_var['nav']['link'] == $this->_var['current_url']): ?>current<?php endif; ?>" href="<?php echo $this->_var['nav']['link']; ?>"<?php if ($this->_var['nav']['open_new']): ?> target="_blank"<?php endif; ?>><?php echo htmlspecialchars($this->_var['nav']['title']); ?><?php if ($this->_var['nav']['hot'] == 1): ?><span class="absolute block"></span><?php endif; ?></a></li>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </ul>
    </div>
</div>