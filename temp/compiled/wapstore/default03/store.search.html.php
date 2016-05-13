
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black" />
        <?php echo $this->_var['page_seo']; ?>
        <link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'css/index.css'; ?>">
        <link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'css/common.css'; ?>">
        <link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'css/flexslider.css'; ?>">
        <script type="text/javascript" src="<?php echo $this->res_base . "/" . 'js/jquery-1.8.0.min.js'; ?>" charset="utf-8"></script>
        <script type="text/javascript" src="<?php echo $this->res_base . "/" . 'js/jquery.flexslider.js'; ?>" charset="utf-8"></script>
        <script type="text/javascript" src="<?php echo $this->res_base . "/" . 'js/sub_menu.js'; ?>" charset="utf-8"></script>

        <script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'ecmall.js'; ?>" charset="utf-8"></script>

    </head>

    <style>
        .banner{height:40px;margin: 35px auto 0;padding: 5px 0;}
    </style>
    <body>

        <?php echo $this->fetch('header.html'); ?>
        
        <div class="banner">   
            <div class="lo_sh">
                <a href="<?php echo url('app=store&id=' . $this->_var['store']['store_id']. ''); ?>" class="logo"><img style="width:66px;" src="<?php echo $this->_var['store']['store_logo']; ?>"></a>     

                <form  class="searchBar" id="" name="" method="get" action="index.php">  
                    <input type="hidden" name="app" value="store" />
                    <input type="hidden" name="act" value="search" />
                    <input type="hidden" name="id" value="<?php echo $this->_var['store']['store_id']; ?>" />
                    <input type="text" name="keyword" placeholder="搜搜看吧" class="search_text" /><input type="submit" value="" class="search_btn" />
                </form>
            </div>

        </div>

        <div class="paixu">
            <span class="red_btn">排序</span>
            <a href="index.php?app=store&act=search&id=<?php echo $this->_var['store']['store_id']; ?>&keyword=<?php echo $this->_var['keyword']; ?>&cate_id=<?php echo $this->_var['cate_id']; ?>&order=sales" class="white_btn <?php if ($this->_var['sort'] == '4'): ?>cur<?php endif; ?>">销量<i></i></a>
            <a href="index.php?app=store&act=search&id=<?php echo $this->_var['store']['store_id']; ?>&keyword=<?php echo $this->_var['keyword']; ?>&cate_id=<?php echo $this->_var['cate_id']; ?>&order=add_time" class="white_btn <?php if ($this->_var['sort'] == '1'): ?>cur<?php endif; ?>">新品<i></i></a>
            <a href="index.php?app=store&act=search&id=<?php echo $this->_var['store']['store_id']; ?>&keyword=<?php echo $this->_var['keyword']; ?>&cate_id=<?php echo $this->_var['cate_id']; ?>&order=price" class="white_btn <?php if ($this->_var['sort'] == '2'): ?>cur<?php endif; ?>">价格<i></i></a>
            <a href="index.php?app=store&act=search&id=<?php echo $this->_var['store']['store_id']; ?>&keyword=<?php echo $this->_var['keyword']; ?>&cate_id=<?php echo $this->_var['cate_id']; ?>&order=views" class="white_btn <?php if ($this->_var['sort'] == '3'): ?>cur<?php endif; ?>">人气<i></i></a>
        </div>
        
        <div class="lists lists1">
            <ul>
                <?php if ($this->_var['searched_goods']): ?>
                <?php $_from = $this->_var['searched_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'sgoods');if (count($_from)):
    foreach ($_from AS $this->_var['sgoods']):
?>
                <a href="<?php echo url('app=goods&id=' . $this->_var['sgoods']['goods_id']. ''); ?>">
                    <li>
                        <img src="<?php echo $this->_var['sgoods']['default_image']; ?>" />
                        <p><?php echo htmlspecialchars($this->_var['sgoods']['goods_name']); ?></p>
                        <span><?php echo price_format($this->_var['sgoods']['price']); ?></span>
                    </li>
                </a>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                <?php else: ?>
                <div style="padding:50px 60px; text-align:center;background:#fff;margin:5px 5px 0;">很抱歉! 没有找到相关商品</div>
                <?php endif; ?>
            </ul>
        </div>

        
        <div class="page">
            <?php echo $this->fetch('page.bottom.html'); ?>
        </div>
        <?php echo $this->fetch('footer.html'); ?>
    </body>
</html>