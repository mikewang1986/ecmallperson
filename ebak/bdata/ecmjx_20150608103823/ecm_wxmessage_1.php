<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_wxmessage`;");
E_C("CREATE TABLE `ecm_wxmessage` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `wxid` char(28) NOT NULL,
  `w_message` text NOT NULL,
  `message` text NOT NULL,
  `belong` int(9) unsigned NOT NULL,
  `dateline` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `wxid` (`wxid`)
) ENGINE=MyISAM AUTO_INCREMENT=387 DEFAULT CHARSET=utf8");
E_D("replace into `ecm_wxmessage` values('322','oMVyQtyhAlXkVVatgTA-djD8FNkE','','menu:tianxin100','0','1433599081');");
E_D("replace into `ecm_wxmessage` values('323','oMVyQtyhAlXkVVatgTA-djD8FNkE','','Qrcode','0','1433599894');");
E_D("replace into `ecm_wxmessage` values('324','oMVyQtyhAlXkVVatgTA-djD8FNkE','','Bd','0','1433599895');");
E_D("replace into `ecm_wxmessage` values('325','oMVyQtyhAlXkVVatgTA-djD8FNkE','','menu:zjd','0','1433599907');");
E_D("replace into `ecm_wxmessage` values('326','oMVyQtyhAlXkVVatgTA-djD8FNkE','','menu:tianxin100','0','1433599936');");
E_D("replace into `ecm_wxmessage` values('327','oMVyQtyhAlXkVVatgTA-djD8FNkE','','menber','0','1433605365');");
E_D("replace into `ecm_wxmessage` values('328','oMVyQtyhAlXkVVatgTA-djD8FNkE','','member','0','1433606713');");
E_D("replace into `ecm_wxmessage` values('329','oMVyQtyhAlXkVVatgTA-djD8FNkE','','222','0','1433606928');");
E_D("replace into `ecm_wxmessage` values('330','oMVyQtyhAlXkVVatgTA-djD8FNkE','','quit','0','1433606975');");
E_D("replace into `ecm_wxmessage` values('331','oMVyQtyhAlXkVVatgTA-djD8FNkE','','quit','0','1433607032');");
E_D("replace into `ecm_wxmessage` values('332','oMVyQtyhAlXkVVatgTA-djD8FNkE','','ddcx','0','1433607150');");
E_D("replace into `ecm_wxmessage` values('333','oMVyQtyhAlXkVVatgTA-djD8FNkE','','222','0','1433607417');");
E_D("replace into `ecm_wxmessage` values('334','oMVyQtyhAlXkVVatgTA-djD8FNkE','','member','0','1433607561');");
E_D("replace into `ecm_wxmessage` values('335','oMVyQtyhAlXkVVatgTA-djD8FNkE','','222','0','1433608365');");
E_D("replace into `ecm_wxmessage` values('336','oMVyQtyhAlXkVVatgTA-djD8FNkE','','kdcy','0','1433608446');");
E_D("replace into `ecm_wxmessage` values('337','oMVyQtyhAlXkVVatgTA-djD8FNkE','','member','0','1433610736');");
E_D("replace into `ecm_wxmessage` values('338','oMVyQtyhAlXkVVatgTA-djD8FNkE','','ddcx','0','1433610756');");
E_D("replace into `ecm_wxmessage` values('339','oMVyQtyhAlXkVVatgTA-djD8FNkE','','quit','0','1433610780');");
E_D("replace into `ecm_wxmessage` values('340','oMVyQtyhAlXkVVatgTA-djD8FNkE','','menu:fyzx888','0','1433639679');");
E_D("replace into `ecm_wxmessage` values('341','oMVyQtyhAlXkVVatgTA-djD8FNkE','','menu:fyzx888','0','1433639902');");
E_D("replace into `ecm_wxmessage` values('342','oMVyQtyhAlXkVVatgTA-djD8FNkE','','member','0','1433639957');");
E_D("replace into `ecm_wxmessage` values('343','oMVyQtyhAlXkVVatgTA-djD8FNkE','','menu:fsafdsa','0','1433640177');");
E_D("replace into `ecm_wxmessage` values('344','oMVyQtyhAlXkVVatgTA-djD8FNkE','','vxcb','0','1433640363');");
E_D("replace into `ecm_wxmessage` values('345','oMVyQtyhAlXkVVatgTA-djD8FNkE','','menu:fyzx888','0','1433640376');");
E_D("replace into `ecm_wxmessage` values('346','oMVyQtyhAlXkVVatgTA-djD8FNkE','','微商城','0','1433640431');");
E_D("replace into `ecm_wxmessage` values('347','oMVyQtyhAlXkVVatgTA-djD8FNkE','','微店铺','0','1433640463');");
E_D("replace into `ecm_wxmessage` values('348','oMVyQtyhAlXkVVatgTA-djD8FNkE','','menu:fyzx888','0','1433640704');");
E_D("replace into `ecm_wxmessage` values('349','oMVyQtyhAlXkVVatgTA-djD8FNkE','','menu:fsafdsa','0','1433641041');");
E_D("replace into `ecm_wxmessage` values('350','oMVyQtyhAlXkVVatgTA-djD8FNkE','','menu:fsafdsa','0','1433641387');");
E_D("replace into `ecm_wxmessage` values('351','oMVyQtyhAlXkVVatgTA-djD8FNkE','','Member','0','1433641422');");
E_D("replace into `ecm_wxmessage` values('352','oMVyQtyhAlXkVVatgTA-djD8FNkE','','Member','0','1433641436');");
E_D("replace into `ecm_wxmessage` values('353','oMVyQtyhAlXkVVatgTA-djD8FNkE','','member','0','1433641497');");
E_D("replace into `ecm_wxmessage` values('354','oMVyQtyhAlXkVVatgTA-djD8FNkE','','kdcx','0','1433642209');");
E_D("replace into `ecm_wxmessage` values('355','oMVyQtyhAlXkVVatgTA-djD8FNkE','','ddcx','0','1433642256');");
E_D("replace into `ecm_wxmessage` values('356','oMVyQtyhAlXkVVatgTA-djD8FNkE','','cxye','0','1433642286');");
E_D("replace into `ecm_wxmessage` values('357','oMVyQtyhAlXkVVatgTA-djD8FNkE','','222','0','1433642332');");
E_D("replace into `ecm_wxmessage` values('358','oMVyQtyhAlXkVVatgTA-djD8FNkE','','222','0','1433642390');");
E_D("replace into `ecm_wxmessage` values('359','oMVyQtyhAlXkVVatgTA-djD8FNkE','','ddcx','0','1433642537');");
E_D("replace into `ecm_wxmessage` values('360','oMVyQtyhAlXkVVatgTA-djD8FNkE','','222','0','1433643031');");
E_D("replace into `ecm_wxmessage` values('361','oMVyQtyhAlXkVVatgTA-djD8FNkE','','member','0','1433643091');");
E_D("replace into `ecm_wxmessage` values('362','ohiDjs8eA3BsAMm8lcAUT5UT-s4w','','menu:cxbd','0','1433665125');");
E_D("replace into `ecm_wxmessage` values('363','ohiDjs8eA3BsAMm8lcAUT5UT-s4w','','menu:member','0','1433665141');");
E_D("replace into `ecm_wxmessage` values('364','ohiDjs8eA3BsAMm8lcAUT5UT-s4w','',' 。突然','0','1433666192');");
E_D("replace into `ecm_wxmessage` values('365','ohiDjs8eA3BsAMm8lcAUT5UT-s4w','','menu:member','0','1433666291');");
E_D("replace into `ecm_wxmessage` values('366','ohiDjs8eA3BsAMm8lcAUT5UT-s4w','','menu:cxbd','0','1433666380');");
E_D("replace into `ecm_wxmessage` values('367','ohiDjs8eA3BsAMm8lcAUT5UT-s4w','','menu:member','0','1433666391');");
E_D("replace into `ecm_wxmessage` values('368','ohiDjs8eA3BsAMm8lcAUT5UT-s4w','','menu:member','0','1433666403');");
E_D("replace into `ecm_wxmessage` values('369','ohiDjs8eA3BsAMm8lcAUT5UT-s4w','','menu:member','0','1433666416');");
E_D("replace into `ecm_wxmessage` values('370','ohiDjs8eA3BsAMm8lcAUT5UT-s4w','','quit','0','1433666437');");
E_D("replace into `ecm_wxmessage` values('371','ohiDjs8eA3BsAMm8lcAUT5UT-s4w','','menu:member','0','1433666450');");
E_D("replace into `ecm_wxmessage` values('372','ohiDjs8eA3BsAMm8lcAUT5UT-s4w','','大是大非','0','1433666521');");
E_D("replace into `ecm_wxmessage` values('373','ohiDjs8eA3BsAMm8lcAUT5UT-s4w','','微商城','0','1433666553');");
E_D("replace into `ecm_wxmessage` values('374','ohiDjs8eA3BsAMm8lcAUT5UT-s4w','','微店铺','0','1433666568');");
E_D("replace into `ecm_wxmessage` values('375','ohiDjs8eA3BsAMm8lcAUT5UT-s4w','','menu:ddcx','0','1433666588');");
E_D("replace into `ecm_wxmessage` values('376','ohiDjs8eA3BsAMm8lcAUT5UT-s4w','','menu:cxye','0','1433666590');");
E_D("replace into `ecm_wxmessage` values('377','ohiDjs8eA3BsAMm8lcAUT5UT-s4w','','menu:ddcx','0','1433666598');");
E_D("replace into `ecm_wxmessage` values('378','ohiDjs8eA3BsAMm8lcAUT5UT-s4w','','menu:kdcx','0','1433666611');");
E_D("replace into `ecm_wxmessage` values('379','ohiDjs8eA3BsAMm8lcAUT5UT-s4w','','menu:member','0','1433666636');");
E_D("replace into `ecm_wxmessage` values('380','ohiDjs8eA3BsAMm8lcAUT5UT-s4w','','menu:cxye','0','1433666829');");
E_D("replace into `ecm_wxmessage` values('381','ohiDjs8eA3BsAMm8lcAUT5UT-s4w','','menu:ddcx','0','1433666835');");
E_D("replace into `ecm_wxmessage` values('382','ohiDjs8eA3BsAMm8lcAUT5UT-s4w','','menu:member','0','1433666848');");
E_D("replace into `ecm_wxmessage` values('383','ohiDjs8eA3BsAMm8lcAUT5UT-s4w','','menu:member','0','1433728577');");
E_D("replace into `ecm_wxmessage` values('384','ohiDjs8eA3BsAMm8lcAUT5UT-s4w','','menu:cxye','0','1433730889');");
E_D("replace into `ecm_wxmessage` values('385','ohiDjs8eA3BsAMm8lcAUT5UT-s4w','','menu:kdcx','0','1433730895');");
E_D("replace into `ecm_wxmessage` values('386','ohiDjs8eA3BsAMm8lcAUT5UT-s4w','','menu:member','0','1433730907');");

require("../../inc/footer.php");
?>