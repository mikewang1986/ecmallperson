<?php if ($this->_var['page_info']['page_count'] > 1): ?>
<div class="page">
  <div class="flip_over">��ҳ: </div>
  <?php if ($this->_var['page_info']['prev_link']): ?>
  <a class="former" href="<?php echo $this->_var['page_info']['prev_link']; ?>"></a>
  <?php else: ?>
  <span class="formerNull"></span>
  <?php endif; ?>
  <?php if ($this->_var['page_info']['next_link']): ?>
  <a class="down" href="<?php echo $this->_var['page_info']['next_link']; ?>">��һҳ</a>
  <?php else: ?>
  <span class="downNull">��һҳ</span>
  <?php endif; ?>
</div>
<?php endif; ?>
