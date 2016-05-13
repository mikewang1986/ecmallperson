<?php echo $this->fetch('member.header.html'); ?>
<style>
.information .info table{width :auto;}
</style>
<div class="content">
  <div class="totline"></div>
  <div class="botline"></div>
  <?php echo $this->fetch('member.menu.html'); ?>
  <div id="right"> <?php echo $this->fetch('member.submenu.html'); ?>
    
    <div class="wrap">
      <div class="public">
      
     
        <form method="post"  id="register_form">
        
        <div class="closec" style="margin-left:50px;">
      
       <?php echo $this->html_radios(array('name'=>'is_affter','options'=>$this->_var['is_fenxiao'],'checked'=>$this->_var['store_info']['is_affter'])); ?>
      
      
      </div>
      <br />
      
      
      <table>
          <tr class="line tr_bgcolor">
            <th align="center">推荐人级别</th>
            <th align="center">现金分成百分比</th>
          </tr>
          <tr class="line_bold">
            <td align="center">1 </td>
            <td align="center"><input type="text"  name="pasen_1" value="<?php echo $this->_var['row']['0']; ?>"  />% </td>
          <tr>
          <tr class="line_bold">
            <td align="center">2</td>
            <td align="center"><input type="text"  name="pasen_2" value="<?php echo $this->_var['row']['1']; ?>"  />% </td>
          <tr>
          <tr class="line_bold">
            <td align="center">3</td>
            <td align="center"><input type="text"  name="pasen_3" value="<?php echo $this->_var['row']['2']; ?>"  />% </td>
          <tr>
            <td colspan="5" class="member_no_records padding6"> <div class="issuance"><input type="submit" class="btn" value="提交" /></div></td>
          </tr>
        </table>
        </form>
        
      
      </div>
      </div>

        <div class="clear"></div>
        <div class="adorn_right1"></div>
        <div class="adorn_right2"></div>
        <div class="adorn_right3"></div>
        <div class="adorn_right4"></div>
    </div>
    <div class="clear"></div>
</div>
<?php echo $this->fetch('footer.html'); ?>