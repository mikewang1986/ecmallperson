<?php echo $this->fetch('header.html'); ?>
<div class="w320">
    <table style="width: 100%">
        <?php $_from = $this->_var['sgrades']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'sgrade');if (count($_from)):
    foreach ($_from AS $this->_var['sgrade']):
?>
        <tr>
            <th><?php echo $this->_var['sgrade']['grade_name']; ?></th>
            <td>
                <p>需要审核: <span class="fontColor1"><?php if ($this->_var['sgrade']['need_confirm']): ?>是<?php else: ?>否<?php endif; ?></span></p>
            </td>
            <td><a href="<?php echo url('app=apply&step=2&id=' . $this->_var['sgrade']['grade_id']. ''); ?>" class="white_btn" style="padding: 5px 2%;
                   margin: 0 2% 0 0;
                   width: 96%;
                   text-align: center;
                   display: inline-block;
                   cursor: pointer;">立即开店</a></td>
        </tr>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </table>
</div>
<?php echo $this->fetch('footer.html'); ?>
