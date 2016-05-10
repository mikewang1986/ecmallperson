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
                            <span>��ӭ����<?php echo htmlspecialchars($this->_var['user']['user_name']); ?></span>
                            <a href="<?php echo url('app=member&act=profile'); ?>">�༭��������>></a>
                        </h3>
                        <table class="width6">
                            <tr>
                                <td>�ϴε�¼ʱ��: <?php echo local_date("Y-m-d H:i:s",$this->_var['user']['last_login']); ?></td>
                                <td>
                                <?php if ($this->_var['store']): ?>
                                ��������: <a href="<?php echo url('app=store&act=credit&id=' . $this->_var['store']['store_id']. ''); ?>" target="_blank"><?php echo $this->_var['store']['credit_value']; ?></a><?php if ($this->_var['store']['credit_value'] >= 0): ?> <img src="<?php echo $this->_var['store']['credit_image']; ?>" /> <?php endif; ?>
                                <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>�ϴε�¼ IP: <?php echo $this->_var['user']['last_ip']; ?></td>
                                <td>
                                <?php if ($this->_var['store']): ?>
                                ���Һ�����: <?php echo $this->_var['store']['praise_rate']; ?>%
                                <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                        <p><?php echo sprintf('���� <span class="red">%s</span> ������Ϣ��<a href="index.php?app=message&act=newpm">����鿴</a>', $this->_var['new_message']); ?></p>
                    </div>
                </div>

            </div>
            <div class="wrap_bottom"></div>
        </div>
        <div class="wrap_line margin1">
            <div class="public_index">
                <div class="information_index">
                    <h3 class="title">�������</h3>
                    <?php if ($this->_var['buyer_stat'] && $this->_var['buyer_stat']['sum']): ?>
                    <div class="remind">
                        <dl>
                            <dt>��������</dt>
                            <dd><?php echo sprintf('���� <span class="red">%s</span> ��������Ķ������뾡�쵽��<a href="index.php?app=buyer_order&type=pending">�������</a>���и���', $this->_var['buyer_stat']['pending']); ?></dd>
                            <dd><?php echo sprintf('���� <span class="red">%s</span> �����������ѷ������ȴ�����ȷ�ϣ��뾡�쵽��<a href="index.php?app=buyer_order&type=shipped">�ѷ�������</a>����ȷ��', $this->_var['buyer_stat']['shipped']); ?></dd>
                            <dd><?php echo sprintf('���� <span class="red">%s</span> ��������û�����ۣ��뾡�쵽��<a href="index.php?app=buyer_order&type=finished">����ɶ���</a>����ȷ��', $this->_var['buyer_stat']['finished']); ?></dd>
                        </dl>
                        <dl>
                            <dt>�Ź�����</dt>
                            <dd><?php echo sprintf('���� <span class="red">%s</span> ���μӵ��Ź������ɣ��뾡�쵽��<a href="index.php?app=buyer_groupbuy&state=finished">����ɵ��Ź�</a>���й���', $this->_var['buyer_stat']['groupbuy_finished']); ?></dd>
                            <dd><?php echo sprintf('���� <span class="red">%s</span> ���μӵ��Ź���ѱ�ȡ�����鿴��<a href="index.php?app=buyer_groupbuy&state=canceled">��ȡ�����Ź�</a>��', $this->_var['buyer_stat']['groupbuy_canceled']); ?></dd>
                        </dl>
                        <a href="<?php echo url('app=buyer_order'); ?>" class="btn pos1" title="�鿴�ҵĶ���"><span class="pic1">�鿴�ҵĶ���</span></a>
                    </div>
                    <?php else: ?>
                    <div class="awoke">
                        ��Ŀǰ��û�������ɵĶ���<br />ȥ<a href="index.php">�̳���ҳ</a>����ѡϲ������Ʒ�����鹺����Ȥ�ɡ�
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
                    <h3 class="title">��������
                        <p>
                        <span>���̵ȼ�: <?php echo $this->_var['sgrade']['grade_name']; ?></span>
                        <span>��Ч��: <?php if ($this->_var['sgrade']['add_time']): ?><?php echo sprintf('ʣ�� %s ��', $this->_var['sgrade']['add_time']); ?><?php else: ?>������<?php endif; ?></span>
                        <span>��Ʒ����: <?php echo $this->_var['sgrade']['goods']['used']; ?>/<?php if ($this->_var['sgrade']['goods']['total']): ?><?php echo $this->_var['sgrade']['goods']['total']; ?><?php else: ?>������<?php endif; ?></span>
                        <span>�ռ�ʹ��: <?php echo $this->_var['sgrade']['space']['used']; ?>M/<?php if ($this->_var['sgrade']['space']['total']): ?><?php echo $this->_var['sgrade']['space']['total']; ?>M<?php else: ?>������<?php endif; ?></span>
                        </p>
                    </h3>
                    <div class="remind">
                        <dl>
                            <dt>��������</dt>
                            <dd><?php echo sprintf('���� <span class="red">%s</span> ��������Ķ������뾡�쵽��<a href="index.php?app=seller_order&type=submitted">���ύ����</a>���д���', $this->_var['seller_stat']['submitted']); ?></dd>
                            <dd><?php echo sprintf('���� <span class="red">%s</span> ���������Ķ������뾡�쵽��<a href="index.php?app=seller_order&type=accepted">����������</a>���д���', $this->_var['seller_stat']['accepted']); ?></dd>
                        </dl>
                        <dl>
                            <dt>�Ź�����</dt>
                            <dd><?php echo sprintf('���� <span class="red">%s</span> ��������Ź���ѽ������뾡�쵽��<a href="index.php?app=seller_groupbuy&state=end">�ѽ������Ź�</a>����ȷ�����', $this->_var['seller_stat']['groupbuy_end']); ?></dd>
                        </dl>
                        <a href="<?php echo url('app=store&id=' . $this->_var['store']['store_id']. ''); ?>" title="�鿴�ҵĵ���" target="_blank" class="btn1 pos2"><span class="pic2">�鿴�ҵĵ���</span></a>
                        <a href="<?php echo url('app=seller_order'); ?>" class="btn pos3" title="�����ҵĶ���"><span class="pic1">�����ҵĶ���</span></a>
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
                    <h3 class="title">��������</h3>
                    <div class="remind">
                        <dl>
                            <dt>���״̬</dt>
                            <dd><?php echo sprintf('���ĵ�����������С������<a href="index.php?app=apply&step=2&id=%s">�鿴���޸ĵ�����Ϣ</a>', $this->_var['user']['sgrade']); ?></dd>
                        </dl>
                        <a href="index.php?app=apply&step=2&id=<?php echo $this->_var['user']['sgrade']; ?>" title="�༭������Ϣ" class="btn1 pos2"><span class="pic2">�༭������Ϣ</span></a>
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
