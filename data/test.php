<?php
$file = dirname(__FILIE__).'/data/wx.txt';
echo $file;
log($file,1234);
function log($file,$txt)
{
   $fp =  fopen($file,'ab+');
   fwrite($fp,'-----------'.date('Y-m-d H:i:s').'-----------------');
   fwrite($fp,$txt);
   fwrite($fp,"\r\n\r\n\r\n");
   fclose($fp);
}
echo 'ok';