<style>
#footer {width:980px; margin:auto; text-align:left;}
#footer a{color: #666666;text-decoration:none;outline:none;}
#footer a:hover{text-decoration:underline;}
#footer .footertop{background: url(themes/mall/yhd/styles/default/images/index_repeatbg.png) repeat-x scroll 0 -183px transparent;height: 149px;margin: 0 auto;padding: 5px;width: 970px;}
#footer .footertop .nav{height: 25px;line-height: 25px; color:#fff; padding-left:10px;}
#footer .footertop .nav a{color:#fff;}
#footer .footertop .nav a:hover{color:#ff6600; text-decoration:underline;}
#footer .footertop .quicklink{width:970px; height:124px;}
#footer .footertop .quicklink .quicklinkbox {float: left;height: 115px;margin-right: 20px;margin-top: 9px;width: 140px;}
#footer .footertop .quicklink .quicklinkbox .quicklinkboxtitle {border-bottom: 1px solid #CCCCCC; color: #666666;font-size: 16px;font-weight: bold;height: 27px;}
#footer .footertop .quicklink .quicklinkbox ul li{line-height:20px;}
.footerbanner{height: 52px;  margin: 10px auto 0; text-align: center; width: 685px;}
.footerbanner ul li {display: block; float: left; height: 52px; margin-left: 10px; width: 215px;}
.map {height: 25px; line-height: 25px; margin-top: 5px; width: 980px;}
.map ul {height: 25px; text-align: center; width: auto;}
.map ul li {display:inline;}
.copyright{text-align:center;}
.footerbanner2 {height: 31px; margin-top: 10px; width: 980px;}
.footerbanner2 ul {height: 31px; text-align: center;  width: 980px;}
.footerbanner2 ul li {display: inline; height: 31px; margin-left: 10px; width: 91px;}
</style>
<div id="footer">
	<div class="footertop">
		<div class="nav"> 
            ��վ������ <a href="index.php">��ҳ</a>
        	<?php $_from = $this->_var['navs']['footer']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'nav');if (count($_from)):
    foreach ($_from AS $this->_var['nav']):
?>
        	| <a href="<?php echo $this->_var['nav']['link']; ?>"<?php if ($this->_var['nav']['open_new']): ?> target="_blank"<?php endif; ?>><?php echo htmlspecialchars($this->_var['nav']['title']); ?></a>
        	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            <div class="clr"></div>
        </div>  
    	<div class="quicklink">
         	<div class="quicklinkbox">
               <div class="quicklinkboxtitle">���ͷ�Χ</div>
                        <ul>
                        <li>
	                        	<a href="http://www.psmoban.com" target="_blank">�Ϻ�</a>&nbsp;|&nbsp;
	                        	<a href="http://www.psmoban.com">����</a>&nbsp;|&nbsp;
	                        	<a href="http://www.psmoban.com">��������</a>
                        </li>
                        		<li><a href="http://www.psmoban.com" target="_blank">���ͷ���ȡ��׼</a></li>
                        </ul> 
                  </div>
                    <div class="quicklinkbox">
                      <div class="quicklinkboxtitle">����˵��</div>
                        <ul>
                        		<li><a href="http://www.psmoban.com/" target="_blank">���ʽ</a></li>
                        		<li><a href="http://www.psmoban.com/" target="_blank">����Э��</a></li>
                        </ul>
                    </div>
                    <div class="quicklinkbox">
                      <div class="quicklinkboxtitle">�ҵĶ���</div>
                        <ul>
                        		<li><a href="http://www.psmoban.com/" target="_blank">��ѯ����</a></li>
                        		<li><a href="http://www.psmoban.com/" target="_blank">����¶���</a></li>
                        </ul>
                    </div>
                    <div class="quicklinkbox">
                      <div class="quicklinkboxtitle">�ۺ����</div>
                        <ul>
                        		<li><a href="http://www.psmoban.com/" target="_blank">�˻���ԭ��</a></li>
                            	<li><a href="http://bbs.yihaodian.com" target="_blank">1�ŵ���̳</a></li>
                        </ul>
                    </div>
                    <div class="quicklinkbox">
                      <div class="quicklinkboxtitle">��Ҫ����</div>
                        <ul>
                        <li><a href="http://www.psmoban.com/" target="_blank">��������</a></li>
                        		<li><a href="http://www.psmoban.com/" target="_blank">��������</a></li>
                        		<li><a href="http://www.psmoban.com" target="_blank">��ϵ�ͷ���Ա</a></li>
                        <li><a href="http://www.psmoban.com" target="_blank">����ȯʹ��˵��</a></li>
                        </ul>
                    </div>
 					<div class="quicklinkbox">
                      <div class="quicklinkboxtitle">�̼���פ</div>
                        <ul>
                        	<li><a href="http://www.psmoban.com" target="_blank">������פ</a></li>
                            <li><a href="http://www.psmoban.com" target="_blank">��פ�ȵ�����</a></li>
                        </ul>
                    </div>  
                </div>
    </div>
    <div class="footerbanner">
         <ul>
		            <li><a href="http://www.unn114.com"><img src="ads/footer_pic_01.gif"></a></li>
		            <li><a href="http://www.unn114.com/buy/" target="_blank"><img src="ads/footer_pic_02.gif"></a></li>
		            <li><a href="http://idc.unn114.com" target="_blank"><img src="ads/footer_pic_03.gif"></a></li>
         </ul>
     </div>
     <div>
		<div class="map">
          <ul>
            <li>
              <a target="_blank" href="http://www.unn114.com">����1�ŵ�</a>
            </li>
              |
            <li>
              <a target="_blank" href="http://www.unn114.com">���ǵ��Ŷ�</a>
            </li>
              |
            <li>
              <a target="_blank" href="http://union.yihaodian.com/">��վ����</a>
            </li>
              |
            <li>
              <a target="_blank" href="http://www.gooxao.com/">����Ӣ��</a>
            </li>
              |
            <li>
              <a target="_blank" href="http://www.adminbuy.cn">ý�屨��</a>
            </li>
              |
            <li>
              <a target="_blank" href="http://www.gooxao.com/">���˱�׼</a>
            </li>
              |
            <li>
              <a target="_blank" href="http://supplier.yihaodian.com/">�����Ϊ��Ӧ��</a>
            </li>
          </ul>
        </div>
        
    	<div class="copyright"> Copyright &copy; 2011 ˷�ݹ���  All Rights Reserved</br>
		���쵥λ��˷�������׹�洫ý���޹�˾ </br>
����ά����˷������һ����Ƽ����޹�˾</br>
��ַ��˷�����񸣶����м�����Ժ������200��</br>
�ͷ����ߣ� 0349-2286022 6888818 18634939888 ���棺0349-2280751</br>
������ߣ�400-622-0031</br>
<a href="http://www.miibeian.gov.cn/" target="_blank" >��ICP��11001339��</a></div>
    </div>
	
    <div class="footerbanner2">
         <ul>
		     <li><a target="_blank" href="http://www.unn114.com"><img src="ads/footer_pic_09.gif"></a></li>
			 <li><a target="_blank" href="http://creditcard.pingan.com/index.shtml"><img src="ads/footer_pic_04.gif"></a></li>
			 <li><a href="https://www.alipay.com/aip/aip_validate_list.htm?trustId=AIP10038885" target="_blank" rel="nofollow"><img src="ads/footer_pic_05.gif"></a></li>
			 <li><a href="http://www.ectrustprc.org.cn/certificate.id/certificateb.php?id=20088493" target="_blank" rel="nofollow"><img src="ads/footer_pic_06.gif"></a></li>
			 <li><a href="http://www.315online.com.cn/member/315080105.html" target="_blank" rel="nofollow"><img src="ads/footer_pic_07.gif"></a></li>
		     <li><a target="_blank" href="https://ss.cnnic.cn/verifyseal.dll?sn=2011030900100006964&amp;ct=df&amp;pa=708274"><img src="ads/footer_cnnic.jpg"></a></li>
         </ul>
    </div>
</div>
<?php echo $this->_var['async_sendmail']; ?>
</body>
</html>