<?php echo $this->fetch('header.html'); ?>



<script type="text/javascript">

//<!CDATA[

$(function(){

    $(".show_image").mouseover(function(){

        $(this).next("div").show();

    });

    $(".show_image").mouseout(function(){

        $(this).next("div").hide();

    });

});

//]]>

</script>



<div id="rightTop">

  <p>网站设置</p>

  

</div>

<div class="info">

  <form method="post" enctype="multipart/form-data">

    <table class="infoTable">


     
      
      
     
      

      <tr>

        <th class="paddingT15"> <label for="site_name">一级:</label></th>

        <td class="paddingT15 wordSpacing5"><input id="site_name" type="text" name="pasen_0" value="<?php echo $this->_var['setting']['pasen_0']; ?>" class="infoTableInput"/>  % </td>

      </tr>


        <tr>

        <th class="paddingT15"> <label for="site_name">二级:</label></th>

        <td class="paddingT15 wordSpacing5"><input id="site_name" type="text" name="pasen_1" value="<?php echo $this->_var['setting']['pasen_1']; ?>" class="infoTableInput"/>      %   </td>

      </tr>  


        <tr>

        <th class="paddingT15"> <label for="site_name">三级:</label></th>

        <td class="paddingT15 wordSpacing5"><input id="site_name" type="text" name="pasen_2" value="<?php echo $this->_var['setting']['pasen_2']; ?>" class="infoTableInput"/>      %   </td>

      </tr> 
      
           


    
     

      <tr>

        <th></th>

        <td class="ptb20"><input class="formbtn" type="submit" name="Submit" value="提交" />

          <input class="formbtn" type="reset" name="Submit2" value="重置" />        </td>

      </tr>

    </table>

  </form>

</div>

<?php echo $this->fetch('footer.html'); ?>