<?php echo $this->fetch('header.html'); ?>

<script type="text/javascript">
/* 替换参数 */
function replaceParam(key, value)
{
    var params = location.search.substr(1).split('&');
    var found  = false;
    for (var i = 0; i < params.length; i++)
    {
        param = params[i];
        arr   = param.split('=');
        pKey  = arr[0];
        if (pKey == 'page')
        {
            params[i] = 'page=1';
        }
        if (pKey == key)
        {
            params[i] = key + '=' + value;
            found = true;
        }
    }
    if (!found)
    {
        value = transform_char(value);
        params.push(key + '=' + value);
    }
    location.assign(SITE_URL + '/index.php?' + params.join('&'));
}

/* 删除参数 */
function dropParam(key)
{
    var params = location.search.substr(1).split('&');
    for (var i = 0; i < params.length; i++)
    {
        param = params[i];
        arr   = param.split('=');
        pKey  = arr[0];
        if (pKey == 'page')
        {
            params[i] = 'page=1';
        }
        if (pKey == key)
        {
            params.splice(i, 1);
        }
    }
    location.assign(SITE_URL + '/index.php?' + params.join('&'));
}

function search_submit()
{
	var conditions = '';
	var start_price = '';
	var end_price = '';
	if($("#search_submit input[name='keyword']").val())
	{
		conditions = '&keyword='+$("#search_submit input[name='keyword']").val();
	}
	if($("#search_submit input[name='start_price']").val())
	{
		start_price = number_format($("#search_submit input[name='start_price']").val(),0);
	}
	if($("#search_submit input[name='end_price']").val())
	{
		end_price   = number_format($("#search_submit input[name='end_price']").val(),0);
	}
	if(start_price && end_price)
	{
		conditions += '&price='+start_price+'-'+end_price;
	}
	location.assign(SITE_URL + '/index.php?app=store&id=<?php echo $this->_var['store']['store_id']; ?>&act=search'+conditions);
}
//<!CDATA[
$(function(){
	
	var order = '<?php echo $_GET['order']; ?>';
	var css = '';
	
	<?php if ($_GET['order']): ?>
	order_arr = order.split(' ');
	switch (order_arr[1]){
		case 'desc' : 
			css = 'down-ico';
		break;
		case 'asc' :
			css = 'up-ico';
		break;
		default : 
			css = 'down-ico';
	}
	$('.shop-filter a#'+order_arr[0]).addClass("select");
	$('.shop-filter a#'+order_arr[0]+' i').attr('class',css);
	<?php endif; ?>
	
	<?php if ($_GET['price']): ?>
	var filter_price = '<?php echo $_GET['price']; ?>';
	filter_price = filter_price.split('-');
	$('input[name="start_price"]').val(number_format(filter_price[0],0));
	$('input[name="end_price"]').val(number_format(filter_price[1],0));
	<?php endif; ?>
	
	$(".shop-filter a").click(function(){
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
});
//]]>
</script>
<div id="page">
<div class="w-full col-1" area="top_ad_area" widget_type="area">
    <?php $this->display_widgets(array('page'=>'index','area'=>'top_ad_area')); ?>
</div>
<div id="content">
    <div id="left">
        <div class="" area="store_left" widget_type="area">
            <?php $this->display_widgets(array('page'=>'search','area'=>'store_left')); ?>
        </div>
    </div>
    <div id="right">
    	<div class="" area="store_right" widget_type="area">
            <?php $this->display_widgets(array('page'=>'search','area'=>'store_right')); ?>
        </div>
        <div class="module_special">
            <!--<h2 class="common_title veins2">
                <div class="ornament1"></div>
                <div class="ornament2"></div>
                <span class="ico1"><span class="ico2"><?php echo htmlspecialchars($this->_var['search_name']); ?></span></span>
            </h2>-->
            <div class="store-search clearfix">
            	<div class="result">
                            共搜索到<span> <?php echo $this->_var['search_count']; ?> </span>个符合条件的商品。
                 </div>
                 <div class="search-form">
                      <form action="index.php" id="search_submit" >
                            <label for="keyword">关键字：</label>
                            <input type="text" name="keyword" value="<?php echo $_GET['keyword']; ?>" class="keyword">&nbsp;&nbsp;
                            <label for="price">价格：</label>
                            <input type="text" id="price1" name="start_price" class="price" value=""> 到
                            <input type="text" id="price2" name="end_price" class="price" value="">
                            <button type="button" class="button" onclick="search_submit()">搜索</button>
                        </form>
                 </div>
            </div>    
            <div class="shop-filter clearfix">
                        <span>排序：</span>
                        <a href="javascript:;" alt="按新品排列" title="按新品排列" <?php if ($_GET['order'] == ''): ?>class="select"<?php endif; ?> id="add_time">新品<i class="down-ico"></i></a>
                        <a href="javascript:;" alt="按销量排列" title="按销量排列" id="sales">销量<i class="down-ico"></i></a>
                        <a href="javascript:;" alt="按人气排列" title="按人气排列" id="views">人气<i class="down-ico"></i></a>
                        <a href="javascript:;" alt="按价格排列" title="按价格排列" id="price">价格<i class="up-ico"></i></a>
                        <a href="javascript:;" alt="按收藏排列" title="按收藏排列" id="collects">收藏<i class="down-ico"></i></a>
                </div>
            <div class="wrap">
                <div class="wrap_child">
                    <?php if ($this->_var['searched_goods']): ?>
                    <div class="major">
                        <ul class="list">
                            <?php $_from = $this->_var['searched_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'sgoods');if (count($_from)):
    foreach ($_from AS $this->_var['sgoods']):
?>
                            <li>
                                <div class="pic"><a href="<?php echo url('app=goods&id=' . $this->_var['sgoods']['goods_id']. ''); ?>" target="_blank"><img src="<?php echo $this->_var['sgoods']['default_image']; ?>" width="180" height="180" /></a></div>
                                <h3><a href="<?php echo url('app=goods&id=' . $this->_var['sgoods']['goods_id']. ''); ?>" target="_blank"><?php echo htmlspecialchars($this->_var['sgoods']['goods_name']); ?></a></h3>
                                <p class="clearfix"><span class="price"><?php echo price_format($this->_var['sgoods']['price']); ?></span><?php if ($this->_var['sgoods']['market_price']): ?><del><?php echo price_format($this->_var['sgoods']['market_price']); ?></del><?php endif; ?></p>
                                <p class="clearfix"><span class="sale">已售：<em><?php echo $this->_var['sgoods']['sales']; ?></em> 件</span><span class="comment">评论(<i><?php echo $this->_var['sgoods']['comments']; ?></i>)</span></p>
                            </li>
                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        </ul>
                    </div>
                    <div style="margin-right:15px;">
                    <?php echo $this->fetch('page.bottom.html'); ?>
                    </div>
                    <?php else: ?>
                    <div class="nothing"><p>很抱歉! 没有找到相关商品</p></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="clear"></div>
</div>
</div>
<?php echo $this->fetch('footer.html'); ?>