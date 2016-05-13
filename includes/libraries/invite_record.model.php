<?php

/* 邀请记录 */
class Invite_recordModel extends BaseModel
{
    var $table  = 'invite_record';
    var $prikey = 'id';
    var $_name  = 'invite_record';
    
	function get_repeat_cord($ip,$invite_id)
	{
		$sql = "select * from ecm_invite_record where invite_id=".$invite_id." and user_ip='".$ip."'";
		return $this->db->getAll($sql);
	}
	
	function get_count_byid($invite_id)
	{
		$sql = "select count(*) from ecm_invite_record where invite_id=".$invite_id;
		return $this->db->getOne($sql);
	}
}
?>