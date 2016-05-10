<?php echo $this->fetch('header.html'); ?>
<div class="content-all">
    <div class="left" area="top_left" widget_type="area">
        <?php $this->display_widgets(array('page'=>'index','area'=>'top_left')); ?>
    </div>

    <div class="right">
    	<div area="ads" widget_type="area">
            <?php $this->display_widgets(array('page'=>'index','area'=>'ads')); ?>
        </div>
        
        <div class="main">
            <div class="module_middle" area="cycle_image" widget_type="area">
                <?php $this->display_widgets(array('page'=>'index','area'=>'cycle_image')); ?>
            </div>

            <div class="side" area="sales" widget_type="area">
                <?php $this->display_widgets(array('page'=>'index','area'=>'sales')); ?>
            </div>
        </div>
    </div>
</div>
<div class="ad_banner" area="banner" widget_type="area">
    <?php $this->display_widgets(array('page'=>'index','area'=>'banner')); ?>
</div>

<?php echo $this->fetch('footer.html'); ?>