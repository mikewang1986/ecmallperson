<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="Generator" content="Vmall3.0">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<title> 商品分类</title>
<meta name="description" content="<?php echo $this->_var['page_description']; ?>" />
<meta name="keywords" content="<?php echo $this->_var['page_keywords']; ?>" />
<link rel="stylesheet" href="<?php echo $this->res_base . "/" . 'css/ec_detail.css'; ?>">
<link rel="stylesheet" href="<?php echo $this->res_base . "/" . 'css/style.css'; ?>">
</head>
<body class="category_bg">
<header class="s-header">
<nav>
<h1>类目浏览</h1>
<a href="javascript:history.back(-1)" class="back">返回</a>
</nav>
</header>

<div class="ccontainer">

  
<div class="clist">
     <ul>
	 <?php $_from = $this->_var['gcategorys']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'gcategory');if (count($_from)):
    foreach ($_from AS $this->_var['gcategory']):
?>
      <li class="crow level1">
        <div class="crow_row">   
         <div class="crow_icon">  </div>      
          <div class="crow_title"> <a href="<?php echo url('app=search&cate_id=' . $this->_var['gcategory']['id']. ''); ?>"><?php echo htmlspecialchars($this->_var['gcategory']['value']); ?></a> </div>
          <div class="crow_arrow"><img src="<?php echo $this->res_base . "/" . 'images/crow_arrow.png'; ?>" /></div>
          <div>&nbsp;</div>
        </div>
      </li>
	  
      <ul class="clist clist_sub" style="opacity: 1; display: none; ">
        <li class="crow">
        <?php $_from = $this->_var['gcategory']['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'child');if (count($_from)):
    foreach ($_from AS $this->_var['child']):
?>
         <div class="crow_row">
        <div class="crow_two">
        <div class="crow_title"> 
        <a href="<?php echo url('app=search&cate_id=' . $this->_var['child']['id']. ''); ?>"><?php echo htmlspecialchars($this->_var['child']['value']); ?></a>
        </div>
        </div>
        </div>
        <div class="crow_row">
		<?php $_from = $this->_var['child']['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'child2');if (count($_from)):
    foreach ($_from AS $this->_var['child2']):
?>
        <div class="crow_item"> 
         <a href="<?php echo url('app=search&cate_id=' . $this->_var['child2']['id']. ''); ?>"><?php echo htmlspecialchars($this->_var['child2']['value']); ?></a></div>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        <div class="clear"></div>
        </div>
		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      </li>
      </ul>
     <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </ul>

  </div>
  </div>
<script src="<?php echo $this->res_base . "/" . 'js/zepto.min.js'; ?>"></script>
<script src="<?php echo $this->res_base . "/" . 'js/category.js'; ?>"></script>

<?php echo $this->fetch('footer.html'); ?>