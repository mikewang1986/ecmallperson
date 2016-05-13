<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_category_goods`;");
E_C("CREATE TABLE `ecm_category_goods` (
  `cate_id` int(10) unsigned NOT NULL DEFAULT '0',
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`cate_id`,`goods_id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");
E_D("replace into `ecm_category_goods` values('448','1');");
E_D("replace into `ecm_category_goods` values('448','2');");
E_D("replace into `ecm_category_goods` values('448','3');");
E_D("replace into `ecm_category_goods` values('448','4');");
E_D("replace into `ecm_category_goods` values('448','5');");
E_D("replace into `ecm_category_goods` values('448','6');");
E_D("replace into `ecm_category_goods` values('448','7');");
E_D("replace into `ecm_category_goods` values('448','8');");
E_D("replace into `ecm_category_goods` values('448','9');");
E_D("replace into `ecm_category_goods` values('448','10');");
E_D("replace into `ecm_category_goods` values('448','12');");
E_D("replace into `ecm_category_goods` values('448','13');");
E_D("replace into `ecm_category_goods` values('448','14');");
E_D("replace into `ecm_category_goods` values('448','15');");
E_D("replace into `ecm_category_goods` values('448','99');");
E_D("replace into `ecm_category_goods` values('449','16');");
E_D("replace into `ecm_category_goods` values('449','19');");
E_D("replace into `ecm_category_goods` values('449','20');");
E_D("replace into `ecm_category_goods` values('449','21');");
E_D("replace into `ecm_category_goods` values('449','22');");
E_D("replace into `ecm_category_goods` values('449','23');");
E_D("replace into `ecm_category_goods` values('449','24');");
E_D("replace into `ecm_category_goods` values('449','25');");
E_D("replace into `ecm_category_goods` values('450','30');");
E_D("replace into `ecm_category_goods` values('450','31');");
E_D("replace into `ecm_category_goods` values('450','34');");
E_D("replace into `ecm_category_goods` values('450','35');");
E_D("replace into `ecm_category_goods` values('450','36');");
E_D("replace into `ecm_category_goods` values('450','37');");
E_D("replace into `ecm_category_goods` values('451','28');");
E_D("replace into `ecm_category_goods` values('451','29');");
E_D("replace into `ecm_category_goods` values('451','40');");
E_D("replace into `ecm_category_goods` values('451','42');");
E_D("replace into `ecm_category_goods` values('451','43');");
E_D("replace into `ecm_category_goods` values('451','44');");
E_D("replace into `ecm_category_goods` values('451','45');");
E_D("replace into `ecm_category_goods` values('451','46');");
E_D("replace into `ecm_category_goods` values('451','47');");
E_D("replace into `ecm_category_goods` values('451','48');");
E_D("replace into `ecm_category_goods` values('451','49');");
E_D("replace into `ecm_category_goods` values('453','50');");
E_D("replace into `ecm_category_goods` values('453','51');");
E_D("replace into `ecm_category_goods` values('453','52');");
E_D("replace into `ecm_category_goods` values('453','53');");
E_D("replace into `ecm_category_goods` values('453','54');");
E_D("replace into `ecm_category_goods` values('453','55');");
E_D("replace into `ecm_category_goods` values('453','56');");
E_D("replace into `ecm_category_goods` values('453','57');");
E_D("replace into `ecm_category_goods` values('453','59');");
E_D("replace into `ecm_category_goods` values('454','58');");
E_D("replace into `ecm_category_goods` values('454','60');");
E_D("replace into `ecm_category_goods` values('454','61');");
E_D("replace into `ecm_category_goods` values('454','62');");
E_D("replace into `ecm_category_goods` values('454','63');");
E_D("replace into `ecm_category_goods` values('454','64');");
E_D("replace into `ecm_category_goods` values('454','65');");
E_D("replace into `ecm_category_goods` values('454','66');");
E_D("replace into `ecm_category_goods` values('454','67');");
E_D("replace into `ecm_category_goods` values('454','68');");
E_D("replace into `ecm_category_goods` values('454','69');");
E_D("replace into `ecm_category_goods` values('456','81');");
E_D("replace into `ecm_category_goods` values('456','82');");
E_D("replace into `ecm_category_goods` values('456','83');");
E_D("replace into `ecm_category_goods` values('456','85');");
E_D("replace into `ecm_category_goods` values('456','86');");
E_D("replace into `ecm_category_goods` values('456','87');");
E_D("replace into `ecm_category_goods` values('456','88');");
E_D("replace into `ecm_category_goods` values('456','89');");
E_D("replace into `ecm_category_goods` values('456','90');");
E_D("replace into `ecm_category_goods` values('456','93');");
E_D("replace into `ecm_category_goods` values('457','70');");
E_D("replace into `ecm_category_goods` values('457','71');");
E_D("replace into `ecm_category_goods` values('457','72');");
E_D("replace into `ecm_category_goods` values('457','73');");
E_D("replace into `ecm_category_goods` values('457','75');");
E_D("replace into `ecm_category_goods` values('457','76');");
E_D("replace into `ecm_category_goods` values('457','77');");
E_D("replace into `ecm_category_goods` values('457','80');");
E_D("replace into `ecm_category_goods` values('457','100');");
E_D("replace into `ecm_category_goods` values('457','101');");
E_D("replace into `ecm_category_goods` values('457','102');");
E_D("replace into `ecm_category_goods` values('457','103');");
E_D("replace into `ecm_category_goods` values('457','104');");
E_D("replace into `ecm_category_goods` values('457','105');");
E_D("replace into `ecm_category_goods` values('457','106');");
E_D("replace into `ecm_category_goods` values('457','107');");
E_D("replace into `ecm_category_goods` values('457','108');");
E_D("replace into `ecm_category_goods` values('457','109');");
E_D("replace into `ecm_category_goods` values('457','110');");
E_D("replace into `ecm_category_goods` values('457','111');");
E_D("replace into `ecm_category_goods` values('457','112');");
E_D("replace into `ecm_category_goods` values('457','113');");
E_D("replace into `ecm_category_goods` values('457','114');");
E_D("replace into `ecm_category_goods` values('457','115');");
E_D("replace into `ecm_category_goods` values('457','116');");
E_D("replace into `ecm_category_goods` values('459','91');");
E_D("replace into `ecm_category_goods` values('459','92');");
E_D("replace into `ecm_category_goods` values('459','94');");
E_D("replace into `ecm_category_goods` values('459','95');");
E_D("replace into `ecm_category_goods` values('459','96');");
E_D("replace into `ecm_category_goods` values('459','97');");
E_D("replace into `ecm_category_goods` values('459','98');");

require("../../inc/footer.php");
?>