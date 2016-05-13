<?php echo $this->fetch('member.header.html'); ?>
<div class="content">
    <?php echo $this->fetch('member.menu.html'); ?>
    <div id="right">
        <div class="wrap_line margin1">
            <div class="public">
                <div class="information_index">
                    <div class="photo">
                        <p><img src="<?php echo $this->_var['user']['portrait']; ?>" width="120" height="120" alt="" /></p>
                    </div>

                    <div class="info">
                        <h3 class="margin2">
                            <span>欢迎您，<?php echo htmlspecialchars($this->_var['user']['user_name']); ?></span>
                            <a href="<?php echo url('app=member&act=profile'); ?>">编辑个人资料>></a>
                        </h3>
                        
                        <a href="<?php echo url('app=member&act=profile'); ?>">编辑个人资料>></a>
                        推荐好友注册:
						<input type="text" size="44" value="<?php echo $this->_var['site_url']; ?>/index.php?tuijian_id=<?php echo $this->_var['user']['user_id']; ?>">&nbsp; 
						<a  href="<?php echo $this->_var['site_url']; ?>/index.php?tuijian_id=<?php echo $this->_var['user']['user_id']; ?>"> 推荐链接 </a>
                        <table class="width6">
                            <tr>
                                <td>上次登录时间: <?php echo local_date("Y-m-d H:i:s",$this->_var['user']['last_login']); ?></td>
                                <td>
                                <?php if ($this->_var['store']): ?>
                                卖家信用: <a href="<?php echo url('app=store&act=credit&id=' . $this->_var['store']['store_id']. ''); ?>" target="_blank"><?php echo $this->_var['store']['credit_value']; ?></a><?php if ($this->_var['store']['credit_value'] >= 0): ?> <img src="<?php echo $this->_var['store']['credit_image']; ?>" /> <?php endif; ?>
                                <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>上次登录 IP: <?php echo $this->_var['user']['last_ip']; ?></td>
                                <td>
                                <?php if ($this->_var['store']): ?>
                                卖家好评率: <?php echo $this->_var['store']['praise_rate']; ?>%
                                <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                        <p><?php echo sprintf('您有 <em class="red">%s</em> 条短消息，<a href="index.php?app=message&act=newpm">点击查看</a>', $this->_var['new_message']); ?></p>
                        
                        <?php if ($this->_var['wxchqr_info']['qr_path']): ?>
                        <p>
                        我的推广二维码
                        <img width="150" height="150" src="<?php echo $this->_var['wxchqr_info']['qr_path']; ?>"  />
                        <a  target="_blank" href="<?php echo $this->_var['wxchqr_info']['qr_path']; ?>" >查看</a> &nbsp;
                      
                       <a  target="_blank" href="index.php?app=member&act=wxdorp&id=<?php echo $this->_var['wxchqr_info']['qid']; ?>" >删除</a>
                        
                        </p>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
            <div class="wrap_bottom"></div>
        </div>
        <div class="wrap_line margin1">
            <div class="public_index">
                <div class="information_index">
                    <h3 class="title">买家提醒</h3>
                    <?php if ($this->_var['buyer_stat'] && $this->_var['buyer_stat']['sum']): ?>
                    <div class="remind">
                        <dl>
                            <dt>订单提醒</dt>
                            <dd><?php echo sprintf('<a href="index.php?app=buyer_order&type=pending">待付款订单(<em>%s</em>)</a>', $this->_var['buyer_stat']['pending']); ?></dd>
                            <dd><?php echo sprintf('<a href="index.php?app=buyer_order&type=shipped">待确认的订单(<em>%s</em>)</a>', $this->_var['buyer_stat']['shipped']); ?></dd>
                            <dd><?php echo sprintf('<a href="index.php?app=buyer_order&type=finished">待评价的订单(<em>%s</em>)</a>', $this->_var['buyer_stat']['finished']); ?></dd>
                        </dl>
                        <dl>
                            <dt>团购提醒</dt>
                            <dd><?php echo sprintf('<a href="index.php?app=buyer_groupbuy&state=finished">待付款的团购(<em>%s</em>)</a>', $this->_var['buyer_stat']['groupbuy_finished']); ?></dd>
                            <dd><?php echo sprintf('<a href="index.php?app=buyer_groupbuy&state=canceled">已取消的团购(<em>%s</em>)</a>', $this->_var['buyer_stat']['groupbuy_canceled']); ?></dd>
                        </dl>
                        <a href="<?php echo url('app=buyer_order'); ?>" class="btn pos1" title="查看我的订单"><span class="pic1">查看我的订单</span></a>
                    </div>
                    <?php else: ?>
                    <div class="awoke">
                        您目前还没有已生成的订单<br />去<a href="index.php">商城首页</a>，挑选喜爱的商品，体验购物乐趣吧。
                    </div>
                    <?php endif; ?>
                </div>

            </div>
            <div class="wrap_bottom"></div>
        </div>
<?php if ($this->_var['store']): ?>
        <div class="wrap_line">
            <div class="public_index">
                <div class="information_index">
                    <h3 class="title">卖家提醒
                        <p>
                        <span>店铺等级: <?php echo $this->_var['sgrade']['grade_name']; ?></span>
                        <span>有效期: <?php if ($this->_var['sgrade']['add_time']): ?><?php echo sprintf('剩余 %s 天', $this->_var['sgrade']['add_time']); ?><?php else: ?>不限制<?php endif; ?></span>
                        <span>商品发布: <?php echo $this->_var['sgrade']['goods']['used']; ?>/<?php if ($this->_var['sgrade']['goods']['total']): ?><?php echo $this->_var['sgrade']['goods']['total']; ?><?php else: ?>不限制<?php endif; ?></span>
                        <span>空间使用: <?php echo $this->_var['sgrade']['space']['used']; ?>M/<?php if ($this->_var['sgrade']['space']['total']): ?><?php echo $this->_var['sgrade']['space']['total']; ?>M<?php else: ?>不限制<?php endif; ?></span>
                        </p>
                    </h3>
                    <div class="remind">
                        <dl>
                            <dt>订单提醒</dt>
                            <dd><?php echo sprintf('<a href="index.php?app=seller_order&type=submitted">待处理的订单(<em>%s</em>)</a>', $this->_var['seller_stat']['submitted']); ?></dd>
                            <dd><?php echo sprintf('<a href="index.php?app=seller_order&type=accepted">待发货的订单(<em>%s</em>)</a>', $this->_var['seller_stat']['accepted']); ?></dd>
                        </dl>
                        <dl>
                            <dt>团购提醒</dt>
                            <dd><?php echo sprintf('<a href="index.php?app=seller_groupbuy&state=end">待确认的团购(<em>%s</em>)</a>', $this->_var['seller_stat']['groupbuy_end']); ?></dd>
                        </dl>
                        <a href="<?php echo url('app=store&id=' . $this->_var['store']['store_id']. ''); ?>" title="查看我的店铺" target="_blank" class="btn1 pos2"><span class="pic2">查看我的店铺</span></a>
                        <a href="<?php echo url('app=seller_order'); ?>" class="btn pos3" title="管理我的订单"><span class="pic1">管理我的订单</span></a>
                    </div>
                </div>

            </div>
            <div class="wrap_bottom"></div>
        </div>
<?php endif; ?>
<?php if ($this->_var['applying']): ?>
        <div class="wrap_line">
            <div class="public_index">
                <div class="information_index">
                    <h3 class="title">开店提醒</h3>
                    <div class="remind">
                        <dl>
                            <dt>审核状态</dt>
                            <dd><?php echo sprintf('您的店铺正在审核中。你可以：<a href="index.php?app=apply&step=2&id=%s">查看或修改店铺信息</a>', $this->_var['user']['sgrade']); ?></dd>
                        </dl>
                        <a href="index.php?app=apply&step=2&id=<?php echo $this->_var['user']['sgrade']; ?>" title="编辑店铺信息" class="btn1 pos2"><span class="pic2">编辑店铺信息</span></a>
                    </div>
                </div>

            </div>
            <div class="wrap_bottom"></div>
        </div>
<?php endif; ?>
        <div class="clear"></div>
        <div class="adorn_right1"></div>
        <div class="adorn_right2"></div>
        <div class="adorn_right3"></div>
        <div class="adorn_right4"></div>
    </div>
    <div class="clear"></div>
</div>
<?php echo $this->fetch('footer.html'); ?>
