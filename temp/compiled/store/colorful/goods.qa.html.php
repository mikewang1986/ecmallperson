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
        <a name="module">
        <ul class="user_menu clearfix">
            <li><a href="<?php echo url('app=goods&id=' . $this->_var['goods']['goods_id']. ''); ?>#module">商品详情</a></li>
            <li><a href="<?php echo url('app=goods&act=comments&id=' . $this->_var['goods']['goods_id']. ''); ?>#module">商品评论</a></li>
            <li><a href="<?php echo url('app=goods&act=saleslog&id=' . $this->_var['goods']['goods_id']. ''); ?>#module">销售记录</a></li>
            <li class="active"><a  href="<?php echo url('app=goods&act=qa&id=' . $this->_var['goods']['goods_id']. ''); ?>#module">产品咨询</a></li>
        </ul>
        <div class="module_currency">
            <script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'jquery.plugins/jquery.validate.js'; ?>" charset="utf-8"></script>
			<script type="text/javascript">
            $(function(){
                $('#message').validate({
                    errorPlacement: function(error, element){
                        var _message_box = $(element).parent().find('.field_message');
                        _message_box.find('.field_notice').hide();
                        _message_box.parent().append(error);
                    },
                    rules : {
                        content : {
                            required : true,
                            byteRange : [0,255,'<?php echo $this->_var['charset']; ?>']
                        }
                    },
                    messages : {
                        content : {
                            required : '内容不能为空',
                            byteRange: '您最多可输入255个字符'
                        }
                    }
                });
            })
            </script>
            
            <div class="message">
                <?php $_from = $this->_var['qa_info']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'qainfo');if (count($_from)):
    foreach ($_from AS $this->_var['qainfo']):
?>
                <div class="<?php echo $this->cycle(array('values'=>'message_text2,message_text2 bg1')); ?>">
                    <dl class="leave_word">
                        <dt>咨询内容: </dt>
                        <dd><?php echo nl2br(htmlspecialchars($this->_var['qainfo']['question_content'])); ?></dd>
                        <p>
                            <span class="name"><?php if ($this->_var['qainfo']['user_name']): ?><?php echo $this->_var['qainfo']['user_name']; ?><?php else: ?>游客<?php endif; ?>
                            </span>
                        </p>
                        <dd>
                            <p><?php echo local_date("Y-m-d H:i:s",$this->_var['qainfo']['time_post']); ?></p>
                        </dd>
                    </dl>
                    <?php if ($this->_var['qainfo']['reply_content']): ?>
                    <dl class="revert_to">
                        <dt>店主回复: </dt>
                        <dd><?php echo nl2br(htmlspecialchars($this->_var['qainfo']['reply_content'])); ?></dd>
                        <p>
                            <span class="date"><?php echo local_date("Y-m-d H:i:s",$this->_var['qainfo']['time_reply']); ?></span>
                        </p>
                    </dl>
                    <?php endif; ?>
                </div>
                <?php endforeach; else: ?>
                <div class="<?php echo $this->cycle(array('values'=>'message_text2,message_text2 bg1')); ?>">
                    <span class="light">没有符合条件的记录</span>
                </div>
                <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </div>
            <?php if ($this->_var['qa_info']): ?><?php echo $this->fetch('page.bottom.html'); ?><?php endif; ?>
            <div class="clear"></div>
            <?php if ($_GET['app'] == 'groupbuy' && $this->_var['group']['ican']['ask'] || $_GET['app'] == 'goods'): ?>
            <div class="fill_in">
                <form method="post" id="message" action="index.php?app=<?php echo $_GET['app']; ?><?php if ($_GET['act']): ?>&amp;act=<?php echo $_GET['act']; ?><?php elseif ($_GET['app'] == 'goods'): ?>&amp;act=qa<?php endif; ?>&amp;id=<?php echo $_GET['id']; ?>">
                <p> <span class="desc">我要咨询: </span><textarea name="content"></textarea><span class="field_message"><span class="field_notice"></span></span></p>
                <p>
                    <?php if (! $this->_var['guest_comment_enable'] && ! $this->_var['visitor']['user_id']): ?>
                        您需要先&nbsp;[<a href="index.php?app=member&act=login">登录</a>]&nbsp;后才可以发布咨询
                    <?php else: ?>
                    <span>电子信箱: </span>
                    <span><input type="text" class="text" name="email" value="<?php echo $this->_var['email']; ?>" /></span>
                    <?php if ($this->_var['captcha']): ?>
                    <span>验证码: </span>
                    <span><input type="text" class="text" name="captcha" /></span>
                    <span><a href="javascript:change_captcha($('#captcha'));"><img id="captcha" class="captcha" src="index.php?app=captcha&amp;<?php echo $this->_var['random_number']; ?>" /></a></span>
                    <?php endif; ?>
                    <?php if ($_SESSION['user_info']): ?>
                    <span><label><input type="checkbox" name="hide_name" value="hide" /> 匿名发表</label></span>
                    <?php endif; ?>
                    <input type="submit" value="发布咨询" name="qa" />
                    <!--<input type="hidden" value="<?php echo $_GET['id']; ?>" name="goods_id" />
                    <input type="hidden" value="ask" name="type" />-->
                    <?php endif; ?>
                </p>
                </form>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php echo $this->fetch('footer.html'); ?>