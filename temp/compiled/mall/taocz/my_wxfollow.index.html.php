<?php echo $this->fetch('member.header.html'); ?>
<div class="content">
    <?php echo $this->fetch('member.menu.html'); ?>
    <div id="right">
        <?php echo $this->fetch('member.submenu.html'); ?>

        <div class="wrap">
            <link href="<?php echo $this->res_base . "/" . 'weixin/css/dingcan/css2.css'; ?>" rel="stylesheet" type="text/css" />
            <div class="public_index table1">
                <div class="content-right" style="padding-top:20px;">
                </div>
                <div class="showimg" style="display:none">
                    <div class="stit">
                        <span>上传图片</span>
                        <a href="javascript:zsc_close();"><img src="<?php echo $this->res_base . "/" . 'weixin/images/dingcan/addpageup_06.jpg'; ?>" /></a>
                    </div>
                    <div class="sup">
                        <input type="button" value="上传图片" class="uploadbtn"/>
                        <form action="<?php echo url('app=my_wxkeyword&act=ajaxupload'); ?>" method="post" id="zsc_myform" enctype="multipart/form-data" target="yframe">
                            <input type="file" value="上传图片" class="uploadbtn" style="position:absolute; top:75px; left:20px; filter:alpha(pacity=0);opacity:0; z-index:999;" onchange="zsc_upload()" name="image" />大小不超过1M ，仅限png,jpeg,jpg
                            <input type="hidden" name="sub" value="submit" /> 
                        </form>
                        <iframe name="yframe" src="<?php echo url('app=my_wxkeyword&act=ajaxupload'); ?>" style="border:none; display:none;"></iframe>
                    </div>
                    <div class="imgbox">
                   
                    </div>
                    <div class="sbottom"><input type="button" class="submit" id="zsc_surebtn" /></div>
                     
                    <span class="loadsubmit">正在上传...</span>
                </div>
                <div class="zhe" style="display:none"></div>
            </div>
            <script type="text/javascript" src="<?php echo $this->res_base . "/" . 'weixin/js/dingcan/jquery-1.8.3.min.js'; ?>"></script>
            <script type="text/javascript" src="<?php echo $this->res_base . "/" . 'weixin/js/dingcan/addfollows.js'; ?>"  charset="utf-8"></script>
            <script>
				$(function(){
					  $('#menu2_autoreply').show();
					  $('.arrow_img_autoreply').attr('src', '<?php echo $this->res_base . "/" . 'weixin/images/dingcan/index_20.png'; ?>');
					  $('#zsc_keySet').css("backgroundColor","#D9DDDE");
				  });
			</script>
            <iframe name="pop_warning" style="display:none;"></iframe>
            
        </div>
    </div>
    <div class="clear"></div>
</div>
<?php echo $this->fetch('footer.html'); ?>