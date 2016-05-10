<?php echo $this->fetch('header.html'); ?>
<link href="<?php echo $this->res_base . "/" . 'css/ecmall.css'; ?>" rel="stylesheet" type="text/css" />
<script src="<?php echo $this->res_base . "/" . 'js/jquery.js'; ?>"></script>
<script src="<?php echo $this->res_base . "/" . 'js/nav.js'; ?>"></script>
<script src="<?php echo $this->res_base . "/" . 'js/select.js'; ?>"></script>
<div class="mainbox">
    <div class="module_common">
        <h2><b class="set_up_shop" title="SHOP REGISTRATION��Ҫ����"></b></h2>
        <div class="wrap">
            <div class="wrap_child">

                <div class="module_new_shop">

                    <div class="chart">
                        <div class="pos_x1 bg_a2" title="1. ѡ���������"></div>
                        <div class="pos_x2 bg_b1" title="2. ��д�����͵�����Ϣ"></div>
                        <div class="pos_x3 bg_c" title="3. ���"></div>
                    </div>

                    <div class="grade_shop">
                        <table>
                        <?php $_from = $this->_var['sgrades']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'sgrade');if (count($_from)):
    foreach ($_from AS $this->_var['sgrade']):
?>
                            <tr>
                                <th><?php echo $this->_var['sgrade']['grade_name']; ?></th>
                                <td class="padding1 width5">
                                    <p>��Ʒ��: <span class="fontColor1"><?php echo $this->_var['sgrade']['goods_limit']; ?></span></p>
                                    <p>�ϴ��ռ�(MB): <span class="fontColor1"><?php echo $this->_var['sgrade']['space_limit']; ?></span></p>
                                    <p>ģ����: <span class="fontColor1"><?php echo $this->_var['sgrade']['skin_limit']; ?></span></p>
                                    <p>�շѱ�׼: <span class="fontColor2"><?php echo $this->_var['sgrade']['charge']; ?></span></p>
                                    <p>��Ҫ���: <span class="fontColor1"><?php if ($this->_var['sgrade']['need_confirm']): ?>��<?php else: ?>��<?php endif; ?></span></p>
                                </td>
                                <td class="width4">
                                    <table>
                                        <tr>
                                            <td>���ӹ���: </td>
                                            <td>
                                            <?php $_from = $this->_var['sgrade']['functions']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('k', 'functions');$this->_foreach['v'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['v']['total'] > 0):
    foreach ($_from AS $this->_var['k'] => $this->_var['functions']):
        $this->_foreach['v']['iteration']++;
?>
                                                <?php if ($this->_var['domain'] && $this->_var['k'] == 'subdomain'): ?>
                                                    <span class="fontColor1">��������</span>
                                                <?php else: ?>
                                                    <span class="fontColor1"><?php echo $this->_var['lang'][$this->_var['k']]; ?></span>
                                                <?php endif; ?>
                                                <?php if (! ($this->_foreach['v']['iteration'] == $this->_foreach['v']['total'])): ?>
                                                    <br />
                                                <?php endif; ?>
                                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td class="width6 padding2"><?php echo $this->_var['sgrade']['description']; ?></td>
                                <td><a href="<?php echo url('app=apply&step=2&id=' . $this->_var['sgrade']['grade_id']. ''); ?>" class="shop_btn">��������</a></td>
                            </tr>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>

</div>
<?php echo $this->fetch('footer.html'); ?>
