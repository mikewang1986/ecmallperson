<?php if ($this->_var['page_info']['page_count'] > 1): ?>

<p>��ҳ:</p>
<?php if ($this->_var['page_info']['prev_link']): ?>
<a class="former" href="<?php echo $this->_var['page_info']['prev_link']; ?>"></a>
<?php else: ?>
<span class="former_no"></span>
<?php endif; ?>

<?php if ($this->_var['page_info']['next_link']): ?>
<a class="down" href="<?php echo $this->_var['page_info']['next_link']; ?>">��һҳ</a>
<?php else: ?>
<span class="down_no">��һҳ</span>
<?php endif; ?>

<?php endif; ?>