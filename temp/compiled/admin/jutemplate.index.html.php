<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
    <p>活动管理</p>
    <ul class="subnav">
        <li><span>管理</span></li>
        <li><a class="btn1" href="index.php?app=jutemplate&amp;act=add">新增</a></li>
    </ul>
</div>
	<div class="groupbuy">
            <div class="title">
                操作提示：
            </div>
			<ul>
               <li>聚活动列表，可以定义一个时间段让商家报名参加聚活动，如淘宝聚划算里聚首页作为频道，频道里面每天为一期聚活动</li>
               <li>同一个频道里的活动定义的时间段不能重叠</li>
               <li>未发布的活动可以直接删除，进行中和已经结束的活动，删除后该活动下的所有商品信息将被同时删除，务必谨慎</li>
               <li>商家申请参与聚活动的商品，要到活动审核里审核，方可在页面显示</li>
            </ul>
    </div>
<div class="mrightTop">
    <div class="fontl">
        <form method="get">
            <div class="left">
                <input type="hidden" name="app" value="ju" />
                <input type="hidden" name="act" value="index" />
                标题:
                <input class="queryInput" type="text" name="template_name" value="<?php echo htmlspecialchars($this->_var['query']['template_name']); ?>" />
                所属频道:
                <select class="querySelect" id="channel" name="channel">
                <option value="">请选择...</option>
                <?php echo $this->html_options(array('options'=>$this->_var['channel_options'],'selected'=>$_GET['channel'])); ?>
                </select>
                状态:
                <select class="querySelect" id="state" name="state">
                <option value="">请选择...</option>
                <?php echo $this->html_options(array('options'=>$this->_var['state_options'],'selected'=>$_GET['state'])); ?>
                </select>
                <input type="submit" class="formbtn" value="查询" />
            </div>
            <?php if ($this->_var['filtered']): ?>
            <a class="left formbtn1" href="index.php?app=jutemplate">撤销检索</a>
            <?php endif; ?>
        </form>
    </div>
</div>
<div class="tdare">
    <table width="100%" cellspacing="0" class="dataTable">
        <tr class="tatr1">
            <td width="50" class="firstCell"><input type="checkbox" class="checkall" /></td>
            <td align="center">活动名称</td>
            <td align="center">所属频道</td>
            <td align="center">开始时间</td>
            <td align="center">报名截至时间</td>
            <td align="center">结束时间</td>
            <td align="center">状态</td>
            <td class="handler">操作</td>
        </tr>
        <?php $_from = $this->_var['tempaltes_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'template');if (count($_from)):
    foreach ($_from AS $this->_var['template']):
?>
        <tr class="tatr2">
            <td class="firstCell"><input value="<?php echo $this->_var['template']['template_id']; ?>" class='checkitem' type="checkbox" /></td>
            <td align="center"><?php echo $this->_var['template']['template_name']; ?></td>
            <td align="center"><?php echo $this->_var['template']['channel']; ?></td>
            <td align="center"><?php echo local_date("Y-m-d H:i:s",$this->_var['template']['start_time']); ?></td>
            <td align="center"><?php echo local_date("Y-m-d H:i:s",$this->_var['template']['join_end_time']); ?></td>
            <td align="center"><?php echo local_date("Y-m-d H:i:s",$this->_var['template']['end_time']); ?></td>
            <td align="center"><?php echo call_user_func("ju_state",$this->_var['template']['state']); ?></td>
            <td class="handler" style="width:200px;"><a href="index.php?app=jutemplate&amp;act=edit&amp;id=<?php echo $this->_var['template']['template_id']; ?>">编辑</a> | <a name="drop" href="javascript:drop_confirm('如果删除，可能会对涉及该活动的卖家和买家产生影响，您确定要删除吗？', 'index.php?app=jutemplate&amp;act=drop&amp;id=<?php echo $this->_var['template']['template_id']; ?>');">删除</a> | 
            	<a href="index.php?app=ju&amp;act=goods_list&amp;tid=<?php echo $this->_var['template']['template_id']; ?>">审核</a>
            </td>
        </tr>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        <?php if (! $this->_var['tempaltes_list']): ?>
        <tr class="no_data">
            <td colspan="10">没有数据</td>
        </tr>
        <?php endif; ?>
    </table>
    <?php if ($this->_var['tempaltes_list']): ?>
    <div id="dataFuncs">
        <div class="pageLinks">
            <?php echo $this->fetch('page.bottom.html'); ?>
        </div>
        <div id="batchAction" class="left paddingT15">
            &nbsp;&nbsp;
            <input class="formbtn batchButton" type="button" value="删除" name="id" uri="index.php?app=jutemplate&act=drop" presubmit="confirm('如果删除，可能会对涉及该活动的卖家和买家产生影响，您确定要删除吗？');" />
            &nbsp;&nbsp;
        </div>
    </div>
    <div class="clear"></div>
    <?php endif; ?>
</div>
<?php echo $this->fetch('footer.html'); ?>