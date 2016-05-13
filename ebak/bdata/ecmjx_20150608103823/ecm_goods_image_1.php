<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_goods_image`;");
E_C("CREATE TABLE `ecm_goods_image` (
  `image_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0',
  `image_url` varchar(255) NOT NULL DEFAULT '',
  `thumbnail` varchar(255) NOT NULL DEFAULT '',
  `sort_order` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `file_id` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`image_id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=MyISAM AUTO_INCREMENT=156 DEFAULT CHARSET=utf8");
E_D("replace into `ecm_goods_image` values('1','1','data/files/store_2/goods_110/201312262048304586.jpg','data/files/store_2/goods_110/small_201312262048304586.jpg','1','1');");
E_D("replace into `ecm_goods_image` values('2','2','data/files/store_2/goods_198/201312262049586818.jpg','data/files/store_2/goods_198/small_201312262049586818.jpg','1','2');");
E_D("replace into `ecm_goods_image` values('3','3','data/files/store_2/goods_148/201312262052284448.jpg','data/files/store_2/goods_148/small_201312262052284448.jpg','1','3');");
E_D("replace into `ecm_goods_image` values('4','4','data/files/store_2/goods_57/201312262054174988.jpg','data/files/store_2/goods_57/small_201312262054174988.jpg','1','4');");
E_D("replace into `ecm_goods_image` values('5','5','data/files/store_2/goods_99/201312262054594117.jpg','data/files/store_2/goods_99/small_201312262054594117.jpg','1','5');");
E_D("replace into `ecm_goods_image` values('6','6','data/files/store_2/goods_136/201312262055366831.jpg','data/files/store_2/goods_136/small_201312262055366831.jpg','1','6');");
E_D("replace into `ecm_goods_image` values('7','7','data/files/store_2/goods_180/201312262056209107.jpg','data/files/store_2/goods_180/small_201312262056209107.jpg','1','7');");
E_D("replace into `ecm_goods_image` values('8','8','data/files/store_2/goods_63/201312262057435880.jpg','data/files/store_2/goods_63/small_201312262057435880.jpg','1','8');");
E_D("replace into `ecm_goods_image` values('9','9','data/files/store_2/goods_120/201312262058402887.jpg','data/files/store_2/goods_120/small_201312262058402887.jpg','1','9');");
E_D("replace into `ecm_goods_image` values('10','10','data/files/store_2/goods_31/201312262100319871.jpg','data/files/store_2/goods_31/small_201312262100319871.jpg','1','10');");
E_D("replace into `ecm_goods_image` values('11','11','data/files/store_2/goods_75/201312262101158858.jpg','data/files/store_2/goods_75/small_201312262101158858.jpg','1','11');");
E_D("replace into `ecm_goods_image` values('12','12','data/files/store_2/goods_144/201312262102246687.jpg','data/files/store_2/goods_144/small_201312262102246687.jpg','1','12');");
E_D("replace into `ecm_goods_image` values('13','13','data/files/store_2/goods_2/201312262103227833.jpg','data/files/store_2/goods_2/small_201312262103227833.jpg','1','13');");
E_D("replace into `ecm_goods_image` values('14','14','data/files/store_2/goods_77/201312262104371080.jpg','data/files/store_2/goods_77/small_201312262104371080.jpg','1','14');");
E_D("replace into `ecm_goods_image` values('15','15','data/files/store_2/goods_153/201312262105539118.jpg','data/files/store_2/goods_153/small_201312262105539118.jpg','1','15');");
E_D("replace into `ecm_goods_image` values('16','16','data/files/store_2/goods_69/201312262107499378.jpg','data/files/store_2/goods_69/small_201312262107499378.jpg','1','16');");
E_D("replace into `ecm_goods_image` values('17','17','data/files/store_2/goods_129/201312262108507192.jpg','data/files/store_2/goods_129/small_201312262108507192.jpg','1','17');");
E_D("replace into `ecm_goods_image` values('18','17','data/files/store_2/goods_130/201312262108508363.jpg','data/files/store_2/goods_130/small_201312262108508363.jpg','255','18');");
E_D("replace into `ecm_goods_image` values('19','18','data/files/store_2/goods_166/201312262109269656.jpg','data/files/store_2/goods_166/small_201312262109269656.jpg','1','19');");
E_D("replace into `ecm_goods_image` values('20','19','data/files/store_2/goods_28/201312262110282113.jpg','data/files/store_2/goods_28/small_201312262110282113.jpg','1','20');");
E_D("replace into `ecm_goods_image` values('21','20','data/files/store_2/goods_51/201312262110515808.jpg','data/files/store_2/goods_51/small_201312262110515808.jpg','1','21');");
E_D("replace into `ecm_goods_image` values('22','21','data/files/store_2/goods_124/201312262112041198.jpg','data/files/store_2/goods_124/small_201312262112041198.jpg','1','22');");
E_D("replace into `ecm_goods_image` values('23','22','data/files/store_2/goods_6/201312262113269791.jpg','data/files/store_2/goods_6/small_201312262113269791.jpg','1','23');");
E_D("replace into `ecm_goods_image` values('24','23','data/files/store_2/goods_71/201312262114315846.jpg','data/files/store_2/goods_71/small_201312262114315846.jpg','1','24');");
E_D("replace into `ecm_goods_image` values('25','24','data/files/store_2/goods_141/201312262115417011.jpg','data/files/store_2/goods_141/small_201312262115417011.jpg','1','25');");
E_D("replace into `ecm_goods_image` values('26','25','data/files/store_2/goods_3/201312262116433996.jpg','data/files/store_2/goods_3/small_201312262116433996.jpg','1','26');");
E_D("replace into `ecm_goods_image` values('27','26','data/files/store_2/goods_86/201312262118061068.jpg','data/files/store_2/goods_86/small_201312262118061068.jpg','1','27');");
E_D("replace into `ecm_goods_image` values('28','27','data/files/store_2/goods_160/201312262119204138.jpg','data/files/store_2/goods_160/small_201312262119204138.jpg','1','28');");
E_D("replace into `ecm_goods_image` values('29','28','data/files/store_2/goods_92/201312262134527551.jpg','data/files/store_2/goods_92/small_201312262134527551.jpg','1','29');");
E_D("replace into `ecm_goods_image` values('30','29','data/files/store_2/goods_192/201312262136326387.jpg','data/files/store_2/goods_192/small_201312262136326387.jpg','1','30');");
E_D("replace into `ecm_goods_image` values('31','30','data/files/store_2/goods_111/201312262138315559.jpg','data/files/store_2/goods_111/small_201312262138315559.jpg','1','31');");
E_D("replace into `ecm_goods_image` values('32','31','data/files/store_2/goods_189/201312262139497936.jpg','data/files/store_2/goods_189/small_201312262139497936.jpg','1','32');");
E_D("replace into `ecm_goods_image` values('33','32','data/files/store_2/goods_62/201312262141025440.jpg','data/files/store_2/goods_62/small_201312262141025440.jpg','1','33');");
E_D("replace into `ecm_goods_image` values('34','33','data/files/store_2/goods_125/201312262142056946.jpg','data/files/store_2/goods_125/small_201312262142056946.jpg','1','34');");
E_D("replace into `ecm_goods_image` values('35','34','data/files/store_2/goods_185/201312262143054186.jpg','data/files/store_2/goods_185/small_201312262143054186.jpg','1','35');");
E_D("replace into `ecm_goods_image` values('36','35','data/files/store_2/goods_42/201312262144021189.jpg','data/files/store_2/goods_42/small_201312262144021189.jpg','1','36');");
E_D("replace into `ecm_goods_image` values('37','36','data/files/store_2/goods_113/201312262145134866.jpg','data/files/store_2/goods_113/small_201312262145134866.jpg','1','37');");
E_D("replace into `ecm_goods_image` values('38','37','data/files/store_2/goods_7/201312262146474624.jpg','data/files/store_2/goods_7/small_201312262146474624.jpg','1','38');");
E_D("replace into `ecm_goods_image` values('39','38','data/files/store_2/goods_80/201312262148001815.jpg','data/files/store_2/goods_80/small_201312262148001815.jpg','1','39');");
E_D("replace into `ecm_goods_image` values('40','39','data/files/store_2/goods_139/201312262148598688.jpg','data/files/store_2/goods_139/small_201312262148598688.jpg','1','40');");
E_D("replace into `ecm_goods_image` values('41','40','data/files/store_2/goods_95/201312262151359791.jpg','data/files/store_2/goods_95/small_201312262151359791.jpg','1','41');");
E_D("replace into `ecm_goods_image` values('42','41','data/files/store_2/goods_130/201312262152104798.jpg','data/files/store_2/goods_130/small_201312262152104798.jpg','1','42');");
E_D("replace into `ecm_goods_image` values('43','42','data/files/store_2/goods_47/201312262154079508.jpg','data/files/store_2/goods_47/small_201312262154079508.jpg','1','43');");
E_D("replace into `ecm_goods_image` values('44','43','data/files/store_2/goods_93/201312262154537504.jpg','data/files/store_2/goods_93/small_201312262154537504.jpg','1','44');");
E_D("replace into `ecm_goods_image` values('45','44','data/files/store_2/goods_144/201312262155447040.jpg','data/files/store_2/goods_144/small_201312262155447040.jpg','1','45');");
E_D("replace into `ecm_goods_image` values('46','45','data/files/store_2/goods_178/201312262156186146.jpg','data/files/store_2/goods_178/small_201312262156186146.jpg','1','46');");
E_D("replace into `ecm_goods_image` values('47','46','data/files/store_2/goods_11/201312262156516537.jpg','data/files/store_2/goods_11/small_201312262156516537.jpg','1','47');");
E_D("replace into `ecm_goods_image` values('48','47','data/files/store_2/goods_76/201312262157569987.jpg','data/files/store_2/goods_76/small_201312262157569987.jpg','1','48');");
E_D("replace into `ecm_goods_image` values('49','48','data/files/store_2/goods_111/201312262158319438.jpg','data/files/store_2/goods_111/small_201312262158319438.jpg','1','49');");
E_D("replace into `ecm_goods_image` values('50','49','data/files/store_2/goods_162/201312262159227323.jpg','data/files/store_2/goods_162/small_201312262159227323.jpg','1','50');");
E_D("replace into `ecm_goods_image` values('51','50','data/files/store_2/goods_127/201312262205276887.jpg','data/files/store_2/goods_127/small_201312262205276887.jpg','1','51');");
E_D("replace into `ecm_goods_image` values('52','51','data/files/store_2/goods_173/201312262206139520.jpg','data/files/store_2/goods_173/small_201312262206139520.jpg','1','52');");
E_D("replace into `ecm_goods_image` values('53','52','data/files/store_2/goods_72/201312262207528762.jpg','data/files/store_2/goods_72/small_201312262207528762.jpg','1','53');");
E_D("replace into `ecm_goods_image` values('54','53','data/files/store_2/goods_102/201312262208227300.jpg','data/files/store_2/goods_102/small_201312262208227300.jpg','1','54');");
E_D("replace into `ecm_goods_image` values('55','54','data/files/store_2/goods_135/201312262208557042.jpg','data/files/store_2/goods_135/small_201312262208557042.jpg','1','55');");
E_D("replace into `ecm_goods_image` values('56','55','data/files/store_2/goods_176/201312262209361435.jpg','data/files/store_2/goods_176/small_201312262209361435.jpg','1','56');");
E_D("replace into `ecm_goods_image` values('57','56','data/files/store_2/goods_16/201312262210162177.jpg','data/files/store_2/goods_16/small_201312262210162177.jpg','1','57');");
E_D("replace into `ecm_goods_image` values('58','57','data/files/store_2/goods_57/201312262210575290.jpg','data/files/store_2/goods_57/small_201312262210575290.jpg','1','58');");
E_D("replace into `ecm_goods_image` values('59','58','data/files/store_2/goods_106/201312262211467126.jpg','data/files/store_2/goods_106/small_201312262211467126.jpg','1','59');");
E_D("replace into `ecm_goods_image` values('60','59','data/files/store_2/goods_152/201312262212327144.jpg','data/files/store_2/goods_152/small_201312262212327144.jpg','1','60');");
E_D("replace into `ecm_goods_image` values('61','60','data/files/store_2/goods_90/201312262218109004.jpg','data/files/store_2/goods_90/small_201312262218109004.jpg','1','61');");
E_D("replace into `ecm_goods_image` values('62','61','data/files/store_2/goods_114/201312262218342575.jpg','data/files/store_2/goods_114/small_201312262218342575.jpg','1','62');");
E_D("replace into `ecm_goods_image` values('63','62','data/files/store_2/goods_153/201312262219138421.jpg','data/files/store_2/goods_153/small_201312262219138421.jpg','1','63');");
E_D("replace into `ecm_goods_image` values('64','63','data/files/store_2/goods_6/201312262220067431.jpg','data/files/store_2/goods_6/small_201312262220067431.jpg','1','64');");
E_D("replace into `ecm_goods_image` values('65','64','data/files/store_2/goods_41/201312262220415407.jpg','data/files/store_2/goods_41/small_201312262220415407.jpg','1','65');");
E_D("replace into `ecm_goods_image` values('66','65','data/files/store_2/goods_143/201312262222237668.jpg','data/files/store_2/goods_143/small_201312262222237668.jpg','1','66');");
E_D("replace into `ecm_goods_image` values('67','66','data/files/store_2/goods_186/201312262223061143.jpg','data/files/store_2/goods_186/small_201312262223061143.jpg','1','67');");
E_D("replace into `ecm_goods_image` values('68','67','data/files/store_2/goods_26/201312262223464846.jpg','data/files/store_2/goods_26/small_201312262223464846.jpg','1','68');");
E_D("replace into `ecm_goods_image` values('70','68','data/files/store_2/goods_91/201312262224518849.jpg','data/files/store_2/goods_91/small_201312262224518849.jpg','1','70');");
E_D("replace into `ecm_goods_image` values('71','69','data/files/store_2/goods_131/201312262225311490.jpg','data/files/store_2/goods_131/small_201312262225311490.jpg','1','71');");
E_D("replace into `ecm_goods_image` values('72','70','data/files/store_2/goods_195/201312262233156335.jpg','data/files/store_2/goods_195/small_201312262233156335.jpg','1','72');");
E_D("replace into `ecm_goods_image` values('73','71','data/files/store_2/goods_44/201312262234045839.jpg','data/files/store_2/goods_44/small_201312262234045839.jpg','1','73');");
E_D("replace into `ecm_goods_image` values('74','72','data/files/store_2/goods_113/201312262235137180.jpg','data/files/store_2/goods_113/small_201312262235137180.jpg','1','74');");
E_D("replace into `ecm_goods_image` values('75','73','data/files/store_2/goods_142/201312262235429182.jpg','data/files/store_2/goods_142/small_201312262235429182.jpg','1','75');");
E_D("replace into `ecm_goods_image` values('76','74','data/files/store_2/goods_189/201312262236298305.jpg','data/files/store_2/goods_189/small_201312262236298305.jpg','1','76');");
E_D("replace into `ecm_goods_image` values('77','75','data/files/store_2/goods_38/201312262237189780.jpg','data/files/store_2/goods_38/small_201312262237189780.jpg','1','77');");
E_D("replace into `ecm_goods_image` values('78','76','data/files/store_2/goods_98/201312262238182827.jpg','data/files/store_2/goods_98/small_201312262238182827.jpg','1','78');");
E_D("replace into `ecm_goods_image` values('79','77','data/files/store_2/goods_179/201312262239393163.jpg','data/files/store_2/goods_179/small_201312262239393163.jpg','1','79');");
E_D("replace into `ecm_goods_image` values('80','78','data/files/store_2/goods_54/201312262240547284.jpg','data/files/store_2/goods_54/small_201312262240547284.jpg','1','80');");
E_D("replace into `ecm_goods_image` values('81','79','data/files/store_2/goods_97/201312262241379970.jpg','data/files/store_2/goods_97/small_201312262241379970.jpg','1','81');");
E_D("replace into `ecm_goods_image` values('82','80','data/files/store_2/goods_156/201312262242365477.jpg','data/files/store_2/goods_156/small_201312262242365477.jpg','1','82');");
E_D("replace into `ecm_goods_image` values('83','81','data/files/store_2/goods_111/201312262251512164.jpg','data/files/store_2/goods_111/small_201312262251512164.jpg','1','83');");
E_D("replace into `ecm_goods_image` values('84','82','data/files/store_2/goods_9/201312262253293800.jpg','data/files/store_2/goods_9/small_201312262253293800.jpg','1','84');");
E_D("replace into `ecm_goods_image` values('85','83','data/files/store_2/goods_80/201312262254404774.jpg','data/files/store_2/goods_80/small_201312262254404774.jpg','1','85');");
E_D("replace into `ecm_goods_image` values('86','84','data/files/store_2/goods_155/201312262255558436.jpg','data/files/store_2/goods_155/small_201312262255558436.jpg','1','86');");
E_D("replace into `ecm_goods_image` values('87','85','data/files/store_2/goods_6/201312262256466045.jpg','data/files/store_2/goods_6/small_201312262256466045.jpg','1','87');");
E_D("replace into `ecm_goods_image` values('88','86','data/files/store_2/goods_49/201312262257294186.jpg','data/files/store_2/goods_49/small_201312262257294186.jpg','1','88');");
E_D("replace into `ecm_goods_image` values('89','87','data/files/store_2/goods_86/201312262258066317.jpg','data/files/store_2/goods_86/small_201312262258066317.jpg','1','89');");
E_D("replace into `ecm_goods_image` values('90','88','data/files/store_2/goods_124/201312262258442397.jpg','data/files/store_2/goods_124/small_201312262258442397.jpg','1','90');");
E_D("replace into `ecm_goods_image` values('91','89','data/files/store_2/goods_180/201312262259401924.jpg','data/files/store_2/goods_180/small_201312262259401924.jpg','1','91');");
E_D("replace into `ecm_goods_image` values('92','90','data/files/store_2/goods_60/201312262301006712.jpg','data/files/store_2/goods_60/small_201312262301006712.jpg','1','92');");
E_D("replace into `ecm_goods_image` values('93','91','data/files/store_2/goods_155/201312262302356953.jpg','data/files/store_2/goods_155/small_201312262302356953.jpg','1','93');");
E_D("replace into `ecm_goods_image` values('94','92','data/files/store_2/goods_3/201312262303231812.jpg','data/files/store_2/goods_3/small_201312262303231812.jpg','1','94');");
E_D("replace into `ecm_goods_image` values('95','93','data/files/store_2/goods_48/201312262304085587.jpg','data/files/store_2/goods_48/small_201312262304085587.jpg','1','95');");
E_D("replace into `ecm_goods_image` values('96','94','data/files/store_2/goods_93/201312262304537590.jpg','data/files/store_2/goods_93/small_201312262304537590.jpg','1','96');");
E_D("replace into `ecm_goods_image` values('97','95','data/files/store_2/goods_134/201312262305341913.jpg','data/files/store_2/goods_134/small_201312262305341913.jpg','1','97');");
E_D("replace into `ecm_goods_image` values('98','96','data/files/store_2/goods_170/201312262306104597.jpg','data/files/store_2/goods_170/small_201312262306104597.jpg','1','98');");
E_D("replace into `ecm_goods_image` values('99','97','data/files/store_2/goods_27/201312262307078496.jpg','data/files/store_2/goods_27/small_201312262307078496.jpg','1','99');");
E_D("replace into `ecm_goods_image` values('101','98','data/files/store_2/goods_107/201312262308271759.jpg','data/files/store_2/goods_107/small_201312262308271759.jpg','1','101');");
E_D("replace into `ecm_goods_image` values('102','98','data/files/store_2/goods_113/201312262308337745.jpg','data/files/store_2/goods_113/small_201312262308337745.jpg','255','102');");
E_D("replace into `ecm_goods_image` values('103','98','data/files/store_2/goods_154/201312262309145699.jpg','data/files/store_2/goods_154/small_201312262309145699.jpg','255','103');");
E_D("replace into `ecm_goods_image` values('104','99','data/files/store_2/goods_123/201406260258439769.jpg','data/files/store_2/goods_123/small_201406260258439769.jpg','1','104');");
E_D("replace into `ecm_goods_image` values('105','115','data/files/store_2/goods_64/201506061754248535.jpeg','data/files/store_2/goods_64/small_201506061754248535.jpeg','255','106');");
E_D("replace into `ecm_goods_image` values('106','112','data/files/store_2/goods_65/201506061754259924.jpeg','data/files/store_2/goods_65/small_201506061754259924.jpeg','255','107');");
E_D("replace into `ecm_goods_image` values('107','112','data/files/store_2/goods_66/201506061754267351.jpeg','data/files/store_2/goods_66/small_201506061754267351.jpeg','255','108');");
E_D("replace into `ecm_goods_image` values('108','105','data/files/store_2/goods_67/201506061754277798.jpeg','data/files/store_2/goods_67/small_201506061754277798.jpeg','255','109');");
E_D("replace into `ecm_goods_image` values('109','113','data/files/store_2/goods_67/201506061754272687.jpeg','data/files/store_2/goods_67/small_201506061754272687.jpeg','255','110');");
E_D("replace into `ecm_goods_image` values('110','114','data/files/store_2/goods_68/201506061754283634.jpeg','data/files/store_2/goods_68/small_201506061754283634.jpeg','255','111');");
E_D("replace into `ecm_goods_image` values('111','104','data/files/store_2/goods_69/201506061754291150.jpeg','data/files/store_2/goods_69/small_201506061754291150.jpeg','255','112');");
E_D("replace into `ecm_goods_image` values('112','108','data/files/store_2/goods_69/201506061754298397.jpeg','data/files/store_2/goods_69/small_201506061754298397.jpeg','255','113');");
E_D("replace into `ecm_goods_image` values('113','105','data/files/store_2/goods_70/201506061754304561.jpeg','data/files/store_2/goods_70/small_201506061754304561.jpeg','255','114');");
E_D("replace into `ecm_goods_image` values('114','116','data/files/store_2/goods_71/201506061754318235.jpeg','data/files/store_2/goods_71/small_201506061754318235.jpeg','255','115');");
E_D("replace into `ecm_goods_image` values('115','113','data/files/store_2/goods_71/201506061754311394.jpeg','data/files/store_2/goods_71/small_201506061754311394.jpeg','255','116');");
E_D("replace into `ecm_goods_image` values('116','101','data/files/store_2/goods_72/201506061754326776.jpeg','data/files/store_2/goods_72/small_201506061754326776.jpeg','255','117');");
E_D("replace into `ecm_goods_image` values('117','107','data/files/store_2/goods_73/201506061754336940.jpeg','data/files/store_2/goods_73/small_201506061754336940.jpeg','255','118');");
E_D("replace into `ecm_goods_image` values('118','100','data/files/store_2/goods_74/201506061754348714.jpeg','data/files/store_2/goods_74/small_201506061754348714.jpeg','255','119');");
E_D("replace into `ecm_goods_image` values('119','116','data/files/store_2/goods_74/201506061754347405.jpeg','data/files/store_2/goods_74/small_201506061754347405.jpeg','255','120');");
E_D("replace into `ecm_goods_image` values('120','114','data/files/store_2/goods_75/201506061754352280.jpeg','data/files/store_2/goods_75/small_201506061754352280.jpeg','255','121');");
E_D("replace into `ecm_goods_image` values('121','104','data/files/store_2/goods_76/201506061754361372.jpeg','data/files/store_2/goods_76/small_201506061754361372.jpeg','255','122');");
E_D("replace into `ecm_goods_image` values('122','115','data/files/store_2/goods_76/201506061754366574.jpeg','data/files/store_2/goods_76/small_201506061754366574.jpeg','255','123');");
E_D("replace into `ecm_goods_image` values('123','104','data/files/store_2/goods_77/201506061754371795.jpeg','data/files/store_2/goods_77/small_201506061754371795.jpeg','255','124');");
E_D("replace into `ecm_goods_image` values('124','110','data/files/store_2/goods_77/201506061754371716.jpeg','data/files/store_2/goods_77/small_201506061754371716.jpeg','255','125');");
E_D("replace into `ecm_goods_image` values('125','106','data/files/store_2/goods_78/201506061754383476.jpeg','data/files/store_2/goods_78/small_201506061754383476.jpeg','255','126');");
E_D("replace into `ecm_goods_image` values('126','109','data/files/store_2/goods_79/201506061754398213.jpeg','data/files/store_2/goods_79/small_201506061754398213.jpeg','255','127');");
E_D("replace into `ecm_goods_image` values('127','116','data/files/store_2/goods_80/201506061754404053.jpeg','data/files/store_2/goods_80/small_201506061754404053.jpeg','255','128');");
E_D("replace into `ecm_goods_image` values('128','109','data/files/store_2/goods_80/201506061754406027.jpeg','data/files/store_2/goods_80/small_201506061754406027.jpeg','255','129');");
E_D("replace into `ecm_goods_image` values('129','106','data/files/store_2/goods_81/201506061754418516.jpeg','data/files/store_2/goods_81/small_201506061754418516.jpeg','255','130');");
E_D("replace into `ecm_goods_image` values('130','101','data/files/store_2/goods_82/201506061754421930.jpeg','data/files/store_2/goods_82/small_201506061754421930.jpeg','255','131');");
E_D("replace into `ecm_goods_image` values('131','103','data/files/store_2/goods_82/201506061754424757.jpeg','data/files/store_2/goods_82/small_201506061754424757.jpeg','255','132');");
E_D("replace into `ecm_goods_image` values('132','111','data/files/store_2/goods_83/201506061754435377.jpeg','data/files/store_2/goods_83/small_201506061754435377.jpeg','255','133');");
E_D("replace into `ecm_goods_image` values('133','110','data/files/store_2/goods_84/201506061754442370.jpeg','data/files/store_2/goods_84/small_201506061754442370.jpeg','255','134');");
E_D("replace into `ecm_goods_image` values('134','112','data/files/store_2/goods_84/201506061754448989.jpeg','data/files/store_2/goods_84/small_201506061754448989.jpeg','255','135');");
E_D("replace into `ecm_goods_image` values('135','101','data/files/store_2/goods_85/201506061754453078.jpeg','data/files/store_2/goods_85/small_201506061754453078.jpeg','255','136');");
E_D("replace into `ecm_goods_image` values('136','115','data/files/store_2/goods_86/201506061754466109.jpeg','data/files/store_2/goods_86/small_201506061754466109.jpeg','255','137');");
E_D("replace into `ecm_goods_image` values('137','108','data/files/store_2/goods_86/201506061754465370.jpeg','data/files/store_2/goods_86/small_201506061754465370.jpeg','255','138');");
E_D("replace into `ecm_goods_image` values('138','105','data/files/store_2/goods_87/201506061754476685.jpeg','data/files/store_2/goods_87/small_201506061754476685.jpeg','255','139');");
E_D("replace into `ecm_goods_image` values('139','102','data/files/store_2/goods_88/201506061754483950.jpeg','data/files/store_2/goods_88/small_201506061754483950.jpeg','255','140');");
E_D("replace into `ecm_goods_image` values('140','103','data/files/store_2/goods_88/201506061754486673.jpeg','data/files/store_2/goods_88/small_201506061754486673.jpeg','255','141');");
E_D("replace into `ecm_goods_image` values('141','106','data/files/store_2/goods_89/201506061754499518.jpeg','data/files/store_2/goods_89/small_201506061754499518.jpeg','255','142');");
E_D("replace into `ecm_goods_image` values('142','107','data/files/store_2/goods_90/201506061754506687.jpeg','data/files/store_2/goods_90/small_201506061754506687.jpeg','255','143');");
E_D("replace into `ecm_goods_image` values('143','102','data/files/store_2/goods_90/201506061754508596.jpeg','data/files/store_2/goods_90/small_201506061754508596.jpeg','255','144');");
E_D("replace into `ecm_goods_image` values('144','100','data/files/store_2/goods_91/201506061754515107.jpeg','data/files/store_2/goods_91/small_201506061754515107.jpeg','255','145');");
E_D("replace into `ecm_goods_image` values('145','110','data/files/store_2/goods_92/201506061754525725.jpeg','data/files/store_2/goods_92/small_201506061754525725.jpeg','255','146');");
E_D("replace into `ecm_goods_image` values('146','108','data/files/store_2/goods_92/201506061754537249.jpeg','data/files/store_2/goods_92/small_201506061754537249.jpeg','255','147');");
E_D("replace into `ecm_goods_image` values('147','102','data/files/store_2/goods_93/201506061754539883.jpeg','data/files/store_2/goods_93/small_201506061754539883.jpeg','255','148');");
E_D("replace into `ecm_goods_image` values('148','100','data/files/store_2/goods_94/201506061754546723.jpeg','data/files/store_2/goods_94/small_201506061754546723.jpeg','255','149');");
E_D("replace into `ecm_goods_image` values('149','103','data/files/store_2/goods_94/201506061754546441.jpeg','data/files/store_2/goods_94/small_201506061754546441.jpeg','255','150');");
E_D("replace into `ecm_goods_image` values('150','113','data/files/store_2/goods_95/201506061754554445.jpeg','data/files/store_2/goods_95/small_201506061754554445.jpeg','255','151');");
E_D("replace into `ecm_goods_image` values('151','111','data/files/store_2/goods_96/201506061754563409.jpeg','data/files/store_2/goods_96/small_201506061754563409.jpeg','255','152');");
E_D("replace into `ecm_goods_image` values('152','111','data/files/store_2/goods_96/201506061754563774.jpeg','data/files/store_2/goods_96/small_201506061754563774.jpeg','255','153');");
E_D("replace into `ecm_goods_image` values('153','114','data/files/store_2/goods_97/201506061754572425.jpeg','data/files/store_2/goods_97/small_201506061754572425.jpeg','255','154');");
E_D("replace into `ecm_goods_image` values('154','107','data/files/store_2/goods_98/201506061754589295.jpeg','data/files/store_2/goods_98/small_201506061754589295.jpeg','255','155');");
E_D("replace into `ecm_goods_image` values('155','109','data/files/store_2/goods_98/201506061754587284.jpeg','data/files/store_2/goods_98/small_201506061754587284.jpeg','255','156');");

require("../../inc/footer.php");
?>