<?php

/*分类控制器*/
class DazhuanpanApp extends MallbaseApp
{
    
   
	/* 商品分类 */
    function index()
    {
        /* 取得导航 */
        $this->assign('navs', $this->_get_navs());

         $this->_dazhuanpan_mod = &m('dazhuanpan');

        /* 当前位置 */
        $_curlocal=array(
            array(
                'text'  => Lang::get('index'),
                'url'   => 'index.php',
            ),
            array(
                'text'  => Lang::get('mall_dazhuanpan'),
                'url'   => '/dazhuanpan/',
            ),
        );
	  
	 
		$db = &db();
		$sql = "select A.*,B.user_name,C.title ,C.zhizhen from ecm_dazhuanpan_log A left join ecm_member B on A.userid = B.user_id 
		LEFT JOIN ecm_dazhuanpan C ON A.jiangpin_id = C.id where A.is_zhong > 0 order by A.time desc limit 10";
		$zhongjiang_lis = $db -> query($sql);
	
		$i = 0;
		while($row = $db-> fetchrow($zhongjiang_lis))
		{	$zhongjiang_list[$i]['userid']=$row['userid'];
			$zhongjiang_list[$i]['title']=$row['title'];
			$zhongjiang_list[$i]['is_fangfa']=$row['is_fangfa'];
			$zhongjiang_list[$i]['is_zhong']=$row['is_zhong'];
			$zhongjiang_list[$i]['id']=$row['id'];
			$zhongjiang_list[$i]['time']=$row['time'];
			$zhongjiang_list[$i]['user_name']=$row['user_name'];
			$zhongjiang_list[$i]['zhizhen']=$row['zhizhen'];
			$i++;
		}
	
	
	
	    $this->assign('zhongjiang_list',$zhongjiang_list);
        $this->assign('_curlocal',$_curlocal);      
        $this->display('mall_dazhuanpan.html');
		
    }
 
     function xmlh(){
		 
		 
		$userid = $this->visitor->get("user_id");
	    header("Content-type: text/xml");  
		$xml= "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"; 
		$xml.="<root>";
		
		if(empty($userid)){
		$xml.="<jiaodu>0</jiaodu>";
		$xml.="<tishi>对不起 您还没有登陆</tishi>";
		}
		
		if($userid){
			
			$db = &db();
			
			$gailv = rand(1,Conf::get('dazhuanpan_gailv')); 
			$kongzhizhen = Conf::get('kongzhizhen');
			$meizhongtishi = Conf::get('meizhongtishi');
			$xiaohaojifen = Conf::get('dazhuanpan_jifen');
			$huiyuan = $db->getrow("select * from ecm_my_money  where user_id=".$userid);
			$jiangpin = $db->getAll("select * from ecm_dazhuanpan");
			   
			   
			   if($huiyuan['jifen'] < $xiaohaojifen){
					
					$xml.="<jiaodu>0</jiaodu>";
					
					$xml.="<tishi>对不起 您的积分不足</tishi>";
		 		
				  }else{
						
						$jiangping_id = rand(0,count($jiangpin)-1);
						$jiangpin_gailv = $jiangpin[$jiangping_id]['gailv'];
						$jiangpin_num = $jiangpin[$jiangping_id]['num'];
						$jiangpin_title = $jiangpin[$jiangping_id]['title'];
						$jiangpin_zhizhen = $jiangpin[$jiangping_id]['zhizhen'];
						$jiangpin_jid = $jiangpin[$jiangping_id]['id']; 
						if($gailv < $jiangpin_gailv ){	
							
							if($jiangpin_num<1){
								
									$xml.="<jiaodu>".$kongzhizhen."</jiaodu>";
									
									$xml.="<tishi>".$meizhongtishi."</tishi>";		
									
									}else{
										
									$xml.="<jiaodu>".$jiangpin_zhizhen."</jiaodu>";
									
									$xml.="<tishi>恭喜您中了".$jiangpin_title."</tishi>";	
									$zhong = 1;
								}			
								
						
							}else{
								
								$xml.="<jiaodu>".$kongzhizhen."</jiaodu>";
								
								$xml.="<tishi>".$meizhongtishi."</tishi>";	
								
								}
					
				 
						if($zhong == 1){
						$shuliang = $jiangpin_num-1;		
						$time =  strtotime(date("y-m-d h:i:s",time()));//当前时间戳
						$db->query("insert into ecm_dazhuanpan_log(id, userid ,is_zhong, jiangpin_id, is_fangfa, time) values('','$userid', '1' ,'$jiangpin_jid','0','$time')");
						$db->query("UPDATE `ecm_dazhuanpan` SET `num` = $shuliang WHERE `id` = $jiangpin_jid");
						} 
						$quchujifen = $huiyuan['jifen']-$xiaohaojifen;		
						$db->query("UPDATE `ecm_my_money` SET `jifen` = $quchujifen WHERE `user_id` = $userid");		
								
					  
					  }
	   	}
		$xml.="<tiaozhuan></tiaozhuan>";
		$xml.="<tiaozhuanleixing></tiaozhuanleixing>";
		$xml.="</root>";
		 echo  $xml;
		 }
  
		 
		
}

?>