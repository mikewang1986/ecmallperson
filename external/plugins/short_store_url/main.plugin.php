<?php

/**
 * ���̵�ַ��д���
 *
 * @return  array
 */
class Short_store_urlPlugin extends BasePlugin
{
    function execute()
    {
        if (defined('IN_BACKEND') && IN_BACKEND === true)
        {
            return; // ��̨����ִ��
        }
        elseif($store_id = intval(current(array_keys($_GET))))
        {
            header('location:index.php?app=store&id=' . $store_id);
        }
    }
}

?>