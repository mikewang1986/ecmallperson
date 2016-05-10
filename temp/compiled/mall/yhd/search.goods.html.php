<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'search_goods.js'; ?>" charset="utf-8"></script>
<script type="text/javascript">
var upimg   = '<?php echo $this->res_base . "/" . 'images/up.gif'; ?>';
var downimg = '<?php echo $this->res_base . "/" . 'images/down.gif'; ?>';
imgUping = new Image();
imgUping.src = upimg;
</script>
<div class="ad_banner" area="banner2" widget_type="area">
    <?php $this->display_widgets(array('page'=>'searchgoods','area'=>'banner2')); ?>
</div>
<?php echo $this->fetch('curlocal.html'); ?>
<div class="mainbox">
    <?php if ($this->_var['goods_list']): ?>
    <div class="left" style="overflow:visible;">
    	<div class="ad_sidebar_list" area="right1" widget_type="area">
        <?php $this->display_widgets(array('page'=>'searchgoods','area'=>'right1')); ?>
    	</div>
        <div class="module_sidebar" style="float:left; margin-top:10px; width:193px;">
            <h2><b>��Ʒ����</b></h2>
            <div class="wrap">
                <div class="wrap_child">
                    <div class="side_textlist">
                        <ul ectype="ul_category">
                            <?php $_from = $this->_var['categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'category');$this->_foreach['fe_category'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_category']['total'] > 0):
    foreach ($_from AS $this->_var['category']):
        $this->_foreach['fe_category']['iteration']++;
?>
                            <?php if ($this->_foreach['fe_category']['iteration'] <= 10): ?>
                            <li><a href="javascript:void(0);" id="<?php echo $this->_var['category']['cate_id']; ?>"><?php echo htmlspecialchars($this->_var['category']['cate_name']); ?></a>(<?php echo $this->_var['category']['count']; ?>)</li>
                            <?php else: ?>
                            <li style="display:none"><a href="javascript:void(0);" id="<?php echo $this->_var['category']['cate_id']; ?>"><?php echo htmlspecialchars($this->_var['category']['cate_name']); ?></a></li>
                            <?php endif; ?>
                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        </ul>
                    </div>
                    <?php if ($this->_var['category_count'] > 10): ?>
                    <div class="more"><input type="button" class="brands_btn" value="�鿴ȫ������" id="show_category" /></div>
                    <?php endif; ?>
                </div>
            </div>

            <?php if (! $this->_var['filters']['brand']): ?>
            <h2><b>��Ʒ��</b></h2>
            <div class="wrap">
                <div class="wrap_child">
                    <div class="side_textlist">
                        <ul ectype="ul_brand">
                            <?php $_from = $this->_var['brands']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'row');$this->_foreach['fe_brand'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_brand']['total'] > 0):
    foreach ($_from AS $this->_var['row']):
        $this->_foreach['fe_brand']['iteration']++;
?>
                            <?php if ($this->_foreach['fe_brand']['iteration'] <= 10): ?>
                            <li><a href="javascript:void(0);" title="<?php echo $this->_var['row']['brand']; ?>"><?php echo htmlspecialchars($this->_var['row']['brand']); ?></a> (<?php echo $this->_var['row']['count']; ?>)</li>
                            <?php else: ?>
                            <li style="display:none"><a href="javascript:void(0);" title="<?php echo $this->_var['row']['brand']; ?>"><?php echo htmlspecialchars($this->_var['row']['brand']); ?></a> (<?php echo $this->_var['row']['count']; ?>)</li>
                            <?php endif; ?>
                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        </ul>
                    </div>
                    <?php if ($this->_var['brand_count'] > 10): ?>
                    <div class="more"><input type="button" class="brands_btn" value="�鿴ȫ��Ʒ��" id="show_brand" /></div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

            <h2><b>���۸�</b></h2>
            <div class="wrap">
                <div class="wrap_child">
                    <div class="side_textlist">
                        <ul ectype="ul_price">
                            <?php $_from = $this->_var['price_intervals']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'row');if (count($_from)):
    foreach ($_from AS $this->_var['row']):
?>
                            <li><a href="javascript:void(0);" title="<?php echo $this->_var['row']['min']; ?> - <?php echo $this->_var['row']['max']; ?>"><?php echo price_format($this->_var['row']['min']); ?> - <?php echo price_format($this->_var['row']['max']); ?></a> (<?php echo $this->_var['row']['count']; ?>)</li>
                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                            <li style="display:none"><input type="text" size="5" /> - <input type="text" size="5" /> <input type="button" id="search_by_price" value="�ύ" /></li>
                        </ul>
                    </div>
                    <div class="more"><input type="button" class="brands_btn" value="�Զ���۸�����" id="set_price_interval" /></div>
                </div>
            </div>

            <?php if (! $this->_var['filters']['region_id']): ?>
            <h2><b>������</b></h2>
            <div class="wrap">
                <div class="wrap_child">
                    <div class="side_textlist">
                        <ul ectype="ul_region">
                            <?php $_from = $this->_var['regions']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'row');$this->_foreach['fe_region'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_region']['total'] > 0):
    foreach ($_from AS $this->_var['row']):
        $this->_foreach['fe_region']['iteration']++;
?>
                            <?php if ($this->_foreach['fe_region']['iteration'] <= 10): ?>
                            <li><a href="javascript:void(0);" id="<?php echo $this->_var['row']['region_id']; ?>" title="<?php echo htmlspecialchars($this->_var['row']['region_name']); ?>"><?php echo htmlspecialchars($this->_var['row']['region_name']); ?></a> (<?php echo $this->_var['row']['count']; ?>)</li>
                            <?php else: ?>
                            <li style="display:none"><a href="javascript:void(0);" id="<?php echo $this->_var['row']['region_id']; ?>" title="<?php echo $this->_var['row']['region_name']; ?>"><?php echo htmlspecialchars($this->_var['row']['region_name']); ?></a> (<?php echo $this->_var['row']['count']; ?>)</li>
                            <?php endif; ?>
                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        </ul>
                    </div>
                    <?php if ($this->_var['region_count'] > 10): ?>
                    <div class="more"><input type="button" class="brands_btn" value="�鿴���е���" id="show_region" /></div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <div class="ad_sidebar_list" area="right2" widget_type="area">
        <?php $this->display_widgets(array('page'=>'searchgoods','area'=>'right2')); ?>
    	</div>
    </div>

    <div class="right">
        <div class="module_filter">
            <div class="module_filter_line">
                <div class="contain_list" ectype="dropdown_filter_content" ecvalue="brand">
                	<div class="title">Ʒ��:</div>
                    <ul ectype="ul_brand">
                        <?php $_from = $this->_var['brands']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'row');if (count($_from)):
    foreach ($_from AS $this->_var['row']):
?>
                        <li><a href="javascript:void(0);" title="<?php echo $this->_var['row']['brand']; ?>"><?php echo htmlspecialchars($this->_var['row']['brand']); ?> (<?php echo $this->_var['row']['count']; ?>)</a></li>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </ul>
                </div>
                <div class="contain_list" ectype="dropdown_filter_content" ecvalue="price">
                	<div class="title">�۸�: </div>
                    <ul ectype="ul_price">
                        <?php $_from = $this->_var['price_intervals']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'row');if (count($_from)):
    foreach ($_from AS $this->_var['row']):
?>
                        <li><a href="javascript:void(0);" title="<?php echo $this->_var['row']['min']; ?> - <?php echo $this->_var['row']['max']; ?>"><?php echo price_format($this->_var['row']['min']); ?> - <?php echo price_format($this->_var['row']['max']); ?> (<?php echo $this->_var['row']['count']; ?>)</a></li>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </ul>
                </div>
                <div class="contain_list" ectype="dropdown_filter_content" ecvalue="region">
                	<div class="title">���ڵ���:</div>
                    <ul ectype="ul_region">
                        <?php $_from = $this->_var['regions']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'row');if (count($_from)):
    foreach ($_from AS $this->_var['row']):
?>
                        <li><a href="javascript:void(0);" id="<?php echo $this->_var['row']['region_id']; ?>" title="<?php echo htmlspecialchars($this->_var['row']['region_name']); ?>"><?php echo htmlspecialchars($this->_var['row']['region_name']); ?> (<?php echo $this->_var['row']['count']; ?>)</a></li>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="shop_con_list">
            <h2>
                <div class="ornament1"></div>
                <div class="ornament2"></div>
                <div class="h2_wrap">
                    <div class="table_title">
                        <p class="title">��ʾ:</p>
                        <p class="list_ico" ectype="display_mode" ecvalue="list" title="���б���ʾ"></p>
                        <p class="squares_ico" ectype="display_mode" ecvalue="squares" title="�Է�����ʾ"></p>
                        <p class="line_ico"></p>
                        <p class="title">����:</p>
                        <p><select ectype="order_by"><?php echo $this->html_options(array('options'=>$this->_var['orders'],'selected'=>$_GET['order'])); ?></select></p>
                    </div>
                    <div class="top_page">
                        <?php echo $this->fetch('page.top.html'); ?>
                    </div>
                </div>
            </h2>

            <div class="<?php echo $this->_var['display_mode']; ?>" ectype="current_display_mode">
                <?php if ($this->_var['goods_list']): ?>
                <ul class="list_pic">
                    <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
                    <li>
                        <p><a href="<?php echo url('app=goods&id=' . $this->_var['goods']['goods_id']. ''); ?>" target="_blank"><img src="<?php echo $this->_var['goods']['default_image']; ?>" /></a></p>
                        <h3>
                            <span class="text_link">
                                <span class="depict">
                                    <a href="<?php echo url('app=goods&id=' . $this->_var['goods']['goods_id']. ''); ?>" target="_blank"><?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?></a>
                                </span>
                                <span class="info">
                                    <span>��������: <?php echo htmlspecialchars($this->_var['goods']['store_name']); ?></span>
                                    <span class="fontColor5"><?php echo htmlspecialchars($this->_var['goods']['grade_name']); ?></span>
                                </span>
                            </span>
                            <span class="price"><?php echo price_format($this->_var['goods']['price']); ?></span>
                            <b>����: <?php echo ($this->_var['goods']['sales'] == '') ? '0' : $this->_var['goods']['sales']; ?> �� | <a href="<?php echo url('app=goods&act=comments&id=' . $this->_var['goods']['goods_id']. ''); ?>" target="_blank"><?php echo ($this->_var['goods']['comments'] == '') ? '0' : $this->_var['goods']['comments']; ?> ����</a></b>
                        </h3>
                    </li>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

                    <div class="clear"></div>
                </ul>
                <?php else: ?>
                <div id="no_results">�ܱ�Ǹ! û���ҵ������Ʒ</div>
                <?php endif; ?>
            </div>
        </div>

        <div class="shop_list_page">
            <?php echo $this->fetch('page.bottom.html'); ?>
        </div>
    </div>
    <?php else: ?>
    <div class="module_common">
        <p class="no_info">�ܱ�Ǹ! û���ҵ������Ʒ</p>
    </div>
    <?php endif; ?>
</div>

<?php echo $this->fetch('footer.html'); ?>
