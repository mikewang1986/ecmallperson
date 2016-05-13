<?php echo $this->fetch('header.html'); ?>
<div class="w-full col-1" area="top_ad_area" widget_type="area">
    <?php $this->display_widgets(array('page'=>'index','area'=>'top_ad_area')); ?>
</div>
<div class="w clearfix mt10">
    <div class="info-left">
        <?php echo $this->fetch('goodsinfo.html'); ?>
    </div>
    <div class="info-right">
    	<div class="user">
            <h2><?php echo htmlspecialchars($this->_var['store']['store_name']); ?></h2>
            <div class="user_data">
                <p>
                    <span>店主: </span><?php echo htmlspecialchars($this->_var['store']['store_owner']['user_name']); ?>
                    <a target="_blank" href="<?php echo url('app=message&act=send&to_id=' . htmlspecialchars($this->_var['store']['store_owner']['user_id']). ''); ?>"><img src="<?php echo $this->res_base . "/" . 'images/web_mail.gif'; ?>" alt="发站内信" /></a>
                </p>
                <p>
                    <span>信用度: </span><span class="fontColor1"><?php echo $this->_var['store']['credit_value']; ?></span>
                    <?php if ($this->_var['store']['credit_value'] >= 0): ?><img src="<?php echo $this->_var['store']['credit_image']; ?>" alt="" /><?php endif; ?>
                </p>
                <p>店铺等级: <?php echo $this->_var['store']['sgrade']; ?></p>
                <p>商品数量: <?php echo $this->_var['store']['goods_count']; ?></p>
                <p>所在地区: <?php echo htmlspecialchars($this->_var['store']['region_name']); ?></p>
                <p>创店时间: <?php echo local_date("Y-m-d",$this->_var['store']['add_time']); ?></p>
                <?php if ($this->_var['store']['certifications']): ?>
                <p>
                    <span>认证: </span>
                    <span>
                        <?php $_from = $this->_var['store']['certifications']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cert');if (count($_from)):
    foreach ($_from AS $this->_var['cert']):
?>
                        <?php if ($this->_var['cert'] == "autonym"): ?>
                        <a href="<?php echo url('app=article&act=system&code=cert_autonym'); ?>" target="_blank" title="实名认证"><img src="<?php echo $this->res_base . "/" . 'images/cert_autonym.gif'; ?>" /></a>
                        <?php elseif ($this->_var['cert'] == "material"): ?>
                        <a href="<?php echo url('app=article&act=system&code=cert_material'); ?>" target="_blank" title="实体店铺"><img src="<?php echo $this->res_base . "/" . 'images/cert_material.gif'; ?>" /></a>
                        <?php endif; ?>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </span>
                </p>
                <?php endif; ?>
                <?php if ($this->_var['store']['address']): ?>
                <p>详细地址: <?php echo htmlspecialchars($this->_var['store']['address']); ?></p>
                <?php endif; ?>
                <?php if ($this->_var['store']['tel']): ?>
                <p>联系电话: <?php echo htmlspecialchars($this->_var['store']['tel']); ?></p>
                <?php endif; ?>
                <?php if ($this->_var['store']['im_qq'] || $this->_var['store']['im_ww'] || $this->_var['store']['im_msn']): ?>
                <p>
                    <?php if ($this->_var['store']['im_qq']): ?>
                    <a href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo htmlspecialchars($this->_var['store']['im_qq']); ?>&amp;site=<?php echo htmlspecialchars($this->_var['store']['store_name']); ?>&amp;menu=yes" target="_blank"><img src="http://wpa.qq.com/pa?p=1:<?php echo htmlspecialchars($this->_var['store']['im_qq']); ?>:4" alt="QQ"></a>
                    <?php endif; ?>
                    <?php if ($this->_var['store']['im_ww']): ?>
                    <a target="_blank" href="http://amos.im.alisoft.com/msg.aw?v=2&uid=<?php echo urlencode($this->_var['store']['im_ww']); ?>&site=cntaobao&s=2&charset=<?php echo $this->_var['charset']; ?>" ><img border="0" src="http://amos.im.alisoft.com/online.aw?v=2&uid=<?php echo urlencode($this->_var['store']['im_ww']); ?>&site=cntaobao&s=2&charset=<?php echo $this->_var['charset']; ?>" alt="Wang Wang" /></a>
                    <?php endif; ?>
                    <?php if ($this->_var['store']['im_msn']): ?>
                    <a target="_blank" href="http://settings.messenger.live.com/Conversation/IMMe.aspx?invitee=<?php echo htmlspecialchars($this->_var['store']['im_msn']); ?>"><img src="http://messenger.services.live.com/users/<?php echo htmlspecialchars($this->_var['store']['im_msn']); ?>/presenceimage/" alt="status" /></a>
                    <?php endif; ?>
                </p>
                <?php endif; ?>
            </div>
            <div class="shop-other">
            	<a target="_blank" href="<?php echo url('app=store&id=' . $this->_var['store']['store_id']. ''); ?>">进入店铺</a>
    			<a href="javascript:collect_store(<?php echo $this->_var['store']['store_id']; ?>)">收藏店铺</a>
    		</div>
            <div class="clear"></div>
        </div>
    </div>
</div>
<div id="content" class="clearfix">
    <div id="left">
        <div class="" area="store_left" widget_type="area">
            <?php $this->display_widgets(array('page'=>'goodsinfo','area'=>'store_left')); ?>
        </div>
		 <?php if ($_GET['app'] == "goods"): ?>
        <div class="history">
            <div class="title">浏览历史</div>
            <ul>
                        <?php $_from = $this->_var['goods_history']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'gh_goods');if (count($_from)):
    foreach ($_from AS $this->_var['gh_goods']):
?>
                        <li><a href="<?php echo url('app=goods&id=' . $this->_var['gh_goods']['goods_id']. ''); ?>"><img src="<?php echo $this->_var['gh_goods']['default_image']; ?>" width="50" height="50" alt="<?php echo htmlspecialchars(sub_str($this->_var['gh_goods']['goods_name'],20)); ?>" title="<?php echo htmlspecialchars($this->_var['gh_goods']['goods_name']); ?>" /></a></li>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
             </ul>
        </div>
        <?php endif; ?>
    </div>

    <div id="right">
        <a name="module"></a>
        <ul class="user_menu clearfix">
            <li class="active"><a  href="<?php echo url('app=goods&id=' . $this->_var['goods']['goods_id']. ''); ?>#module">商品详情</a></li>
            <li><a href="<?php echo url('app=goods&act=comments&id=' . $this->_var['goods']['goods_id']. ''); ?>#module">商品评论</a></li>
            <li><a href="<?php echo url('app=goods&act=saleslog&id=' . $this->_var['goods']['goods_id']. ''); ?>#module">销售记录</a></li>
            <li><a href="<?php echo url('app=goods&act=qa&id=' . $this->_var['goods']['goods_id']. ''); ?>#module">产品咨询</a></li>
        </ul>

        <div class="option_box">
            
            <?php if ($this->_var['props']): ?>
            <div style="background:#F5F5F5;margin-bottom:20px;margin-top:10px;border:1px #E2E2E2 solid;">
               <?php $_from = $this->_var['props']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'prop');if (count($_from)):
    foreach ($_from AS $this->_var['prop']):
?>
               <div style="float:left;width:32%;padding:5px; height:20px; line-height:20px;background:#F5F5F5">
                  <?php echo $this->_var['prop']['name']; ?>：<?php echo $this->_var['prop']['value']; ?>
               </div>
               <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
               <div style="clear:both;height:0; display:block; overflow:hidden"></div>
            </div>
            <?php endif; ?>
            
        
            <div class="default"><?php echo html_filter($this->_var['goods']['description']); ?></div>
        </div>
        <?php if ($this->_var['goods']['related_info']['count'] > 0): ?>
        <div class="module_currency">
            <h2 class="common_title veins1">
                <div class="ornament1"></div>
                <div class="ornament2"></div>
                <span class="ico1"><span class="ico2">相关信息(TAG相关)</span></span>
            </h2>
            <dl class="related_list">
                <?php $_from = $this->_var['goods']['related_info']['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'app_data');if (count($_from)):
    foreach ($_from AS $this->_var['app_data']):
?>
                <?php if ($this->_var['app_data']['data'] && $this->_var['app_data']['app_type'] != 'ECMALL'): ?>
                <dt><a href="<?php echo $this->_var['app_data']['app_url']; ?>"><?php echo $this->_var['app_data']['app_name']; ?></a></dt>
                <?php $_from = $this->_var['app_data']['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
                <dd><?php echo $this->_var['item']; ?></dd>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </dl>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php echo $this->fetch('footer.html'); ?>
