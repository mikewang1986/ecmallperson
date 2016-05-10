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
    <?php if ($this->_var['setting']['sitemap_enabled']): ?>
    $('#sitemap_frequency_setting').show();
    <?php endif; ?>
    $('#sitemap_disabled').click(function(){
        $('#sitemap_frequency_setting').hide();
    });
    $('#sitemap_enabled').click(function(){
        $('#sitemap_frequency_setting').show();
    });

    <?php if ($this->_var['setting']['session_type'] == 'memcached'): ?>
    $('#session_memcached').show();
    <?php endif; ?>
    $('#mysql').click(function(){
        $('#session_memcached').hide();
    });
    $('#memcached').click(function(){
        $('#session_memcached').show();
    });

    <?php if ($this->_var['setting']['cache_server'] == 'memcached'): ?>
    $('#cache_memcached').show();
    <?php endif; ?>
    $('#c_default').click(function(){
        $('#cache_memcached').hide();
    });
    $('#c_memcached').click(function(){
        $('#cache_memcached').show();
    });
});
//]]>
</script>

<div id="rightTop">
  <p>��վ����</p>
  <ul class="subnav">
    <li><span>ϵͳ����</span></li>
    <li><a class="btn1" href="index.php?app=setting&amp;act=base_information">������Ϣ</a></li>
    <li><a class="btn1" href="index.php?app=setting&amp;act=email_setting">Email</a></li>
    <li><a class="btn1" href="index.php?app=setting&amp;act=captcha_setting">��֤��</a></li>
    <li><a class="btn1" href="index.php?app=setting&amp;act=store_setting">��������</a></li>
    <li><a class="btn1" href="index.php?app=setting&amp;act=credit_setting">��������</a></li>
    <li><a class="btn1" href="index.php?app=setting&amp;act=subdomain_setting">��������</a></li>
  </ul>
</div>
<div class="info">
  <form method="post" enctype="multipart/form-data">
    <table class="infoTable">
      <tr>
        <th class="paddingT15"><label for="time_zone"> ʱ������:</label></th>
        <td class="paddingT15 wordSpacing5"><select id="time_zone" name="time_zone">
                <?php echo $this->html_options(array('options'=>$this->_var['time_zone'],'selected'=>$this->_var['setting']['time_zone'])); ?>
          </select>
          <span class="grey">����ϵͳʹ�õ�ʱ�����й�Ϊ+8</span>
        </td>
      </tr>
      <tr>
        <th class="paddingT15"><label for="time_format_simple"> ʱ���ʽ���򵥣�:</label></th>
        <td class="paddingT15 wordSpacing5"><input id="time_format_simple" type="text" name="time_format_simple" value="<?php echo $this->_var['setting']['time_format_simple']; ?>" class="infoTableInput"/></td>
      </tr>
      <tr>
        <th class="paddingT15"><label for="time_format_complete"> ʱ���ʽ��������:</label></th>
        <td class="paddingT15 wordSpacing5"><input class="infoTableInput" id="time_format_complete" type="text" name="time_format_complete" value="<?php echo $this->_var['setting']['time_format_complete']; ?>"/></td>
      </tr>
      <tr>
        <th class="paddingT15"><label for="price_format"> ����ʽ:</label></th>
        <td class="paddingT15 wordSpacing5"><input class="infoTableInput" id="price_format" type="text" name="price_format" value="<?php echo $this->_var['setting']['price_format']; ?>"/></td>
      </tr>
<!--      <tr>
        <th class="paddingT15"> URL��д:</th>
        <td class="paddingT15 wordSpacing5"><input id="url_rewrite0" type="radio" name="url_rewrite" <?php if ($this->_var['setting']['url_rewrite'] == 0): ?>checked<?php endif; ?> value="0"/>
          <label for="url_rewrite0">�ر�</label>
          <input id="url_rewrite1" type="radio" name="url_rewrite" <?php if ($this->_var['setting']['url_rewrite'] == 1): ?>checked<?php endif; ?> value="1" />
          <label for="url_rewrite1">����</label>
        </td>
      </tr>
      <tr>
        <th class="paddingT15"><label for="cache_life"> ������ʱ�䣨�룩:</label></th>
        <td class="paddingT15 wordSpacing5"><input class="infoTableInput" id="cache_life" type="text" name="cache_life" value="<?php echo $this->_var['setting']['cache_life']; ?>"/></td>
      </tr>-->
      <tr>
        <th class="paddingT15"> <label for="default_goods_image">Ĭ����ƷͼƬ:</label></th>
        <td class="paddingT15 wordSpacing5"><input class="infoTableFile" id="default_goods_image" type="file" name="default_goods_image" />
          <?php if ($this->_var['setting']['default_goods_image']): ?>
          <img class="show_image" src="<?php echo $this->res_base . "/" . 'style/images/right.gif'; ?>" />
          <div style="position:absolute; display:none"><img src="<?php echo $this->_var['site_url']; ?>/<?php echo $this->_var['setting']['default_goods_image']; ?>?<?php echo $this->_var['random_number']; ?>" /></div>
          <?php endif; ?></td>
      </tr>
      <tr>
        <th class="paddingT15"> <label for="default_store_logo">Ĭ�ϵ��̱�־:</label></th>
        <td class="paddingT15 wordSpacing5"><input class="infoTableFile" id="default_store_logo" type="file" name="default_store_logo" />
          <?php if ($this->_var['setting']['default_store_logo']): ?>
          <img class="show_image" src="<?php echo $this->res_base . "/" . 'style/images/right.gif'; ?>" />
          <div style="position:absolute; display:none"><img src="<?php echo $this->_var['site_url']; ?>/<?php echo $this->_var['setting']['default_store_logo']; ?>?<?php echo $this->_var['random_number']; ?>" /></div>
          <?php endif; ?></td>
      </tr>
      <tr>
        <th class="paddingT15"> <label for="default_user_portrait">Ĭ�ϻ�Աͷ��:</label></th>
        <td class="paddingT15 wordSpacing5"><input class="infoTableFile" id="default_user_portrait" type="file" name="default_user_portrait" />
          <?php if ($this->_var['setting']['default_user_portrait']): ?>
          <img class="show_image" src="<?php echo $this->res_base . "/" . 'style/images/right.gif'; ?>" />
          <div style="position:absolute; display:none"><img src="<?php echo $this->_var['site_url']; ?>/<?php echo $this->_var['setting']['default_user_portrait']; ?>?<?php echo $this->_var['random_number']; ?>" /></div>
          <?php endif; ?></td>
      </tr>
      <?php if ($this->_var['feed_enabled']): ?>
      <tr>
        <th class="paddingT15"> <label for="default_feed_config">Ĭ�ϸ��˶�̬����:</label></th>
        <td class="paddingT15 wordSpacing5">
            <?php $_from = $this->_var['feed_items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('_fi', '_fn');if (count($_from)):
    foreach ($_from AS $this->_var['_fi'] => $this->_var['_fn']):
?>
            <input type="checkbox" id="feed_<?php echo $this->_var['_fi']; ?>" name="default_feed_config[<?php echo $this->_var['_fi']; ?>]" value="1" <?php if ($this->_var['default_feed_config'][$this->_var['_fi']]): ?> checked="true"<?php endif; ?> /><label for="feed_<?php echo $this->_var['_fi']; ?>"><?php echo $this->_var['_fn']; ?></label>&nbsp;
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </td>
      </tr>
      <?php endif; ?>
      <tr>
        <th class="paddingT15"> <label for="statistics_code">����ͳ�ƴ���:</label></th>
        <td class="paddingT15 wordSpacing5"><textarea name="statistics_code" id="statistics_code"><?php echo htmlspecialchars($this->_var['setting']['statistics_code']); ?></textarea></td>
      </tr>
<!--      <tr>
        <th class="paddingT15">��ʾ��Ʒ������:</th>
        <td><input id="disaplay_sales_volume0" type="radio" name="disaplay_sales_volume" <?php if ($this->_var['setting']['disaplay_sales_volume'] == 0): ?>checked<?php endif; ?> value="0" />
          <label for="disaplay_sales_volume0">�ر�</label>
          <input id="disaplay_sales_volume1" type="radio" name="disaplay_sales_volume" <?php if ($this->_var['setting']['disaplay_sales_volume'] == 1): ?>checked<?php endif; ?> value="1" />
          <label for="disaplay_sales_volume1">����</label>
        </td>
      </tr>-->
      <tr>
        <th class="paddingT15">�����ο���ѯ:</th>
        <td class="paddingT15"><input id="guest_comment_disabled" type="radio" name="guest_comment" <?php if (! $this->_var['setting']['guest_comment']): ?>checked<?php endif; ?> value="0" />
          <label for="guest_comment_disabled">��</label>
          <input type="radio" id="guest_comment_enable" name="guest_comment" <?php if ($this->_var['setting']['guest_comment']): ?>checked<?php endif; ?> value="1" />
          <label for="guest_comment_enable">��</label>&nbsp;&nbsp;&nbsp;&nbsp;
          <span class="grey"></span>
        </td>
      </tr>
      <tr>
        <th class="paddingT15">����α��̬:</th>
        <td class="paddingT15"><input id="rewrite_disabled" type="radio" name="rewrite_enabled" <?php if (! $this->_var['setting']['rewrite_enabled']): ?>checked<?php endif; ?> value="0" />
          <label for="rewrite_disabled">��</label>
          <input type="radio" id="rewrite_enabled" name="rewrite_enabled" <?php if ($this->_var['setting']['rewrite_enabled']): ?>checked<?php endif; ?> value="1" />
          <label for="rewrite_enabled">��</label>&nbsp;&nbsp;&nbsp;&nbsp;
          <span class="grey">����α��̬��������SEO��������URL�Ŀɶ���</span>
        </td>
      </tr>
      <tr>
        <th class="paddingT15">����Sitemap:</th>
        <td class="paddingT15"><input id="sitemap_disabled" type="radio" name="sitemap_enabled" <?php if (! $this->_var['setting']['sitemap_enabled']): ?>checked<?php endif; ?> value="0" />
          <label for="sitemap_disabled">��</label>
          <input type="radio" id="sitemap_enabled" name="sitemap_enabled" <?php if ($this->_var['setting']['sitemap_enabled']): ?>checked<?php endif; ?> value="1" />
          <label for="sitemap_enabled">��</label>&nbsp;&nbsp;&nbsp;&nbsp;
          <span class="grey">����sitemaps.org��Э�飬֧�ֵ�����������Google, Yahoo!, MSN, �ύ��ַΪ:������վ���ʵ�ַ/index.php?app=sitemap</span>
        </td>
      </tr>
      <tr id="sitemap_frequency_setting" style="display:none">
        <th class="paddingT15">
            ��������(Сʱ):
        </th>
        <td class="paddingT15">
            <input type="text" name="sitemap_frequency" value="<?php echo $this->_var['setting']['sitemap_frequency']; ?>" />
        </td>
      </tr>
      <tr>
        <th class="paddingT15">Session����:</th>
        <td class="paddingT15"><input id="mysql" type="radio" name="session_type" <?php if ($this->_var['setting']['session_type'] == 'mysql'): ?>checked<?php endif; ?> value="mysql" />
          <label for="mysql">Mysql</label>
          <input type="radio" id="memcached" name="session_type" <?php if ($this->_var['setting']['session_type'] == 'memcached'): ?>checked<?php endif; ?> value="memcached" />
          <label for="memcached">Memcahced</label>&nbsp;&nbsp;&nbsp;&nbsp;
          <span class="grey">Session�������ͣ����ѡ��Memcached��������ϵͳ�谲װ���ú�Memcached����������PHP������Ҫ֧��Memcahce��չ</span>
        </td>
      </tr>
      <tr id="session_memcached" style="display:none">
        <th class="paddingT15">
            Memcached����(for session):
        </th>
        <td class="paddingT15">
            <input type="text" name="session_memcached" value="<?php echo $this->_var['setting']['session_memcached']; ?>" />
            <span class="grey">�洢Session���ݵ�Memcached������(��127.0.0.1:11211)</span>
        </td>
      </tr>


      <tr>
        <th class="paddingT15">�������:</th>
        <td class="paddingT15"><input id="c_default" type="radio" name="cache_server" <?php if ($this->_var['setting']['cache_server'] == 'default'): ?>checked<?php endif; ?> value="default" />
          <label for="c_default">File</label>
          <input type="radio" id="c_memcached" name="cache_server" <?php if ($this->_var['setting']['cache_server'] == 'memcached'): ?>checked<?php endif; ?> value="memcached" />
          <label for="c_memcached">Memcahce</label>&nbsp;&nbsp;&nbsp;&nbsp;
          <span class="grey">����������ͣ����ѡ��Memcached��������ϵͳ�谲װ���ú�Memcached����������PHP������Ҫ֧��Memcahce��չ</span>
        </td>
      </tr>
      <tr id="cache_memcached" style="display:none">
        <th class="paddingT15">
            Memcached����(for cache):
        </th>
        <td class="paddingT15">
            <input type="text" name="cache_memcached" value="<?php echo $this->_var['setting']['cache_memcached']; ?>" />
            <span class="grey">�洢�������ݵ�Memcached������(��127.0.0.1:11212)</span>
        </td>
      </tr>


      <tr>
        <th class="paddingT15">��Ʒ�״�:</th>
        <td class="paddingT15"><input id="radar_disabled" type="radio" name="enable_radar" <?php if (! $this->_var['setting']['enable_radar']): ?>checked<?php endif; ?> value="0" />
          <label for="radar_disabled">��</label>
          <input type="radio" id="enable_radar" name="enable_radar" <?php if ($this->_var['setting']['enable_radar']): ?>checked<?php endif; ?> value="1" />
          <label for="enable_radar">��</label>&nbsp;&nbsp;&nbsp;&nbsp;
          <span class="grey">��Ʒ�״���������鱨֮��</span>
        </td>
      </tr>
      <tr>
        <th></th>
        <td class="ptb20"><input class="formbtn" type="submit" name="Submit" value="�ύ" />
          <input class="formbtn" type="reset" name="Submit2" value="����" />
        </td>
      </tr>
    </table>
  </form>
</div>
<?php echo $this->fetch('footer.html'); ?>
