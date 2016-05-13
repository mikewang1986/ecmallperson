<?php

class deposit_recordModel extends BaseModel
{
    var $table  = 'deposit_record';
    var $prikey = 'record_id';
    var $_name  = 'deposit_record';
	
	/**
     *    生成交易号
     *
     *    @author    psmb
     *    @return    string
     */
    function _gen_trade_sn()
    {
        /* 选择一个随机的方案 */
        mt_srand((double) microtime() * 1000000);
        $tradesn = local_date('YmdHis', gmtime()) . str_pad(mt_rand(1, 99), 2, '0', STR_PAD_LEFT);

        $record = $this->get('tradesn='.$tradesn);
        if (!$record)
        {
            /* 否则就使用这个交易号 */
            return $tradesn;
        }

        /* 如果有重复的，则重新生成 */
        return $this->_gen_trade_sn();
    }
	
}

?>