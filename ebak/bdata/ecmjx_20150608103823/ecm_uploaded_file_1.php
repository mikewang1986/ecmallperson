<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_uploaded_file`;");
E_C("CREATE TABLE `ecm_uploaded_file` (
  `file_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(10) unsigned NOT NULL DEFAULT '0',
  `file_type` varchar(60) NOT NULL DEFAULT '',
  `file_size` int(10) unsigned NOT NULL DEFAULT '0',
  `file_name` varchar(255) NOT NULL DEFAULT '',
  `file_path` varchar(255) NOT NULL DEFAULT '',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  `belong` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `item_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`file_id`),
  KEY `store_id` (`store_id`)
) ENGINE=MyISAM AUTO_INCREMENT=157 DEFAULT CHARSET=utf8");
E_D("replace into `ecm_uploaded_file` values('1','2','image/jpeg','24997','11.jpg','data/files/store_2/goods_110/201312262048304586.jpg','1388033310','2','1');");
E_D("replace into `ecm_uploaded_file` values('2','2','image/jpeg','20215','1.jpg','data/files/store_2/goods_198/201312262049586818.jpg','1388033398','2','2');");
E_D("replace into `ecm_uploaded_file` values('3','2','image/jpeg','10477','2.jpg','data/files/store_2/goods_148/201312262052284448.jpg','1388033548','2','3');");
E_D("replace into `ecm_uploaded_file` values('4','2','image/jpeg','30595','17.jpg','data/files/store_2/goods_57/201312262054174988.jpg','1388033657','2','4');");
E_D("replace into `ecm_uploaded_file` values('5','2','image/jpeg','26733','4.jpg','data/files/store_2/goods_99/201312262054594117.jpg','1388033699','2','5');");
E_D("replace into `ecm_uploaded_file` values('6','2','image/jpeg','23051','5.jpg','data/files/store_2/goods_136/201312262055366831.jpg','1388033736','2','6');");
E_D("replace into `ecm_uploaded_file` values('7','2','image/jpeg','19535','6.jpg','data/files/store_2/goods_180/201312262056209107.jpg','1388033780','2','7');");
E_D("replace into `ecm_uploaded_file` values('8','2','image/jpeg','23943','18.jpg','data/files/store_2/goods_63/201312262057435880.jpg','1388033863','2','8');");
E_D("replace into `ecm_uploaded_file` values('9','2','image/jpeg','28884','19.jpg','data/files/store_2/goods_120/201312262058402887.jpg','1388033920','2','9');");
E_D("replace into `ecm_uploaded_file` values('10','2','image/jpeg','27780','20.jpg','data/files/store_2/goods_31/201312262100319871.jpg','1388034031','2','10');");
E_D("replace into `ecm_uploaded_file` values('11','2','image/jpeg','23463','21.jpg','data/files/store_2/goods_75/201312262101158858.jpg','1388034075','2','11');");
E_D("replace into `ecm_uploaded_file` values('12','2','image/jpeg','34652','22.jpg','data/files/store_2/goods_144/201312262102246687.jpg','1388034144','2','12');");
E_D("replace into `ecm_uploaded_file` values('13','2','image/jpeg','36655','23.jpg','data/files/store_2/goods_2/201312262103227833.jpg','1388034202','2','13');");
E_D("replace into `ecm_uploaded_file` values('14','2','image/jpeg','45682','24.jpg','data/files/store_2/goods_77/201312262104371080.jpg','1388034277','2','14');");
E_D("replace into `ecm_uploaded_file` values('15','2','image/jpeg','22513','25.jpg','data/files/store_2/goods_153/201312262105539118.jpg','1388034353','2','15');");
E_D("replace into `ecm_uploaded_file` values('16','2','image/jpeg','7528','11.jpg','data/files/store_2/goods_69/201312262107499378.jpg','1388034469','2','16');");
E_D("replace into `ecm_uploaded_file` values('17','2','image/jpeg','8244','7.jpg','data/files/store_2/goods_129/201312262108507192.jpg','1388034530','2','17');");
E_D("replace into `ecm_uploaded_file` values('18','2','image/jpeg','8244','12.jpg','data/files/store_2/goods_130/201312262108508363.jpg','1388034530','2','17');");
E_D("replace into `ecm_uploaded_file` values('19','2','image/jpeg','3882','1.jpg','data/files/store_2/goods_166/201312262109269656.jpg','1388034566','2','18');");
E_D("replace into `ecm_uploaded_file` values('20','2','image/jpeg','5181','13.jpg','data/files/store_2/goods_28/201312262110282113.jpg','1388034628','2','19');");
E_D("replace into `ecm_uploaded_file` values('21','2','image/jpeg','5409','10.jpg','data/files/store_2/goods_51/201312262110515808.jpg','1388034651','2','20');");
E_D("replace into `ecm_uploaded_file` values('22','2','image/jpeg','12915','4.jpg','data/files/store_2/goods_124/201312262112041198.jpg','1388034724','2','21');");
E_D("replace into `ecm_uploaded_file` values('23','2','image/jpeg','3722','14.jpg','data/files/store_2/goods_6/201312262113269791.jpg','1388034806','2','22');");
E_D("replace into `ecm_uploaded_file` values('24','2','image/jpeg','4298','15.jpg','data/files/store_2/goods_71/201312262114315846.jpg','1388034871','2','23');");
E_D("replace into `ecm_uploaded_file` values('25','2','image/jpeg','4214','16.jpg','data/files/store_2/goods_141/201312262115417011.jpg','1388034941','2','24');");
E_D("replace into `ecm_uploaded_file` values('26','2','image/jpeg','3175','17.jpg','data/files/store_2/goods_3/201312262116433996.jpg','1388035003','2','25');");
E_D("replace into `ecm_uploaded_file` values('27','2','image/jpeg','3183','18.jpg','data/files/store_2/goods_86/201312262118061068.jpg','1388035086','2','26');");
E_D("replace into `ecm_uploaded_file` values('28','2','image/jpeg','3738','20.jpg','data/files/store_2/goods_160/201312262119204138.jpg','1388035160','2','27');");
E_D("replace into `ecm_uploaded_file` values('29','2','image/jpeg','22614','1.jpg','data/files/store_2/goods_92/201312262134527551.jpg','1388036092','2','28');");
E_D("replace into `ecm_uploaded_file` values('30','2','image/jpeg','4651','2.jpg','data/files/store_2/goods_192/201312262136326387.jpg','1388036192','2','29');");
E_D("replace into `ecm_uploaded_file` values('31','2','image/jpeg','5193','3.jpg','data/files/store_2/goods_111/201312262138315559.jpg','1388036311','2','30');");
E_D("replace into `ecm_uploaded_file` values('32','2','image/jpeg','7813','4.jpg','data/files/store_2/goods_189/201312262139497936.jpg','1388036389','2','31');");
E_D("replace into `ecm_uploaded_file` values('33','2','image/jpeg','7482','5.jpg','data/files/store_2/goods_62/201312262141025440.jpg','1388036462','2','32');");
E_D("replace into `ecm_uploaded_file` values('34','2','image/jpeg','8243','6.jpg','data/files/store_2/goods_125/201312262142056946.jpg','1388036525','2','33');");
E_D("replace into `ecm_uploaded_file` values('35','2','image/jpeg','3963','7.jpg','data/files/store_2/goods_185/201312262143054186.jpg','1388036585','2','34');");
E_D("replace into `ecm_uploaded_file` values('36','2','image/jpeg','5256','8.jpg','data/files/store_2/goods_42/201312262144021189.jpg','1388036642','2','35');");
E_D("replace into `ecm_uploaded_file` values('37','2','image/jpeg','6068','9.jpg','data/files/store_2/goods_113/201312262145134866.jpg','1388036713','2','36');");
E_D("replace into `ecm_uploaded_file` values('38','2','image/jpeg','8551','10.jpg','data/files/store_2/goods_7/201312262146474624.jpg','1388036807','2','37');");
E_D("replace into `ecm_uploaded_file` values('39','2','image/jpeg','7321','11.jpg','data/files/store_2/goods_80/201312262148001815.jpg','1388036880','2','38');");
E_D("replace into `ecm_uploaded_file` values('40','2','image/jpeg','7458','12.jpg','data/files/store_2/goods_139/201312262148598688.jpg','1388036939','2','39');");
E_D("replace into `ecm_uploaded_file` values('41','2','image/jpeg','6194','1.jpg','data/files/store_2/goods_95/201312262151359791.jpg','1388037095','2','40');");
E_D("replace into `ecm_uploaded_file` values('42','2','image/jpeg','6490','2.jpg','data/files/store_2/goods_130/201312262152104798.jpg','1388037130','2','41');");
E_D("replace into `ecm_uploaded_file` values('43','2','image/jpeg','5413','10.jpg','data/files/store_2/goods_47/201312262154079508.jpg','1388037247','2','42');");
E_D("replace into `ecm_uploaded_file` values('44','2','image/jpeg','3838','9.jpg','data/files/store_2/goods_93/201312262154537504.jpg','1388037293','2','43');");
E_D("replace into `ecm_uploaded_file` values('45','2','image/jpeg','6404','8.jpg','data/files/store_2/goods_144/201312262155447040.jpg','1388037344','2','44');");
E_D("replace into `ecm_uploaded_file` values('46','2','image/jpeg','4834','7.jpg','data/files/store_2/goods_178/201312262156186146.jpg','1388037378','2','45');");
E_D("replace into `ecm_uploaded_file` values('47','2','image/jpeg','3554','6.jpg','data/files/store_2/goods_11/201312262156516537.jpg','1388037411','2','46');");
E_D("replace into `ecm_uploaded_file` values('48','2','image/jpeg','4718','5.jpg','data/files/store_2/goods_76/201312262157569987.jpg','1388037476','2','47');");
E_D("replace into `ecm_uploaded_file` values('49','2','image/jpeg','7169','4.jpg','data/files/store_2/goods_111/201312262158319438.jpg','1388037511','2','48');");
E_D("replace into `ecm_uploaded_file` values('50','2','image/jpeg','7562','3.jpg','data/files/store_2/goods_162/201312262159227323.jpg','1388037562','2','49');");
E_D("replace into `ecm_uploaded_file` values('51','2','image/jpeg','3459','1.jpg','data/files/store_2/goods_127/201312262205276887.jpg','1388037927','2','50');");
E_D("replace into `ecm_uploaded_file` values('52','2','image/jpeg','4313','2.jpg','data/files/store_2/goods_173/201312262206139520.jpg','1388037973','2','51');");
E_D("replace into `ecm_uploaded_file` values('53','2','image/jpeg','5663','10.jpg','data/files/store_2/goods_72/201312262207528762.jpg','1388038072','2','52');");
E_D("replace into `ecm_uploaded_file` values('54','2','image/jpeg','3133','8.jpg','data/files/store_2/goods_102/201312262208227300.jpg','1388038102','2','53');");
E_D("replace into `ecm_uploaded_file` values('55','2','image/jpeg','4162','7.jpg','data/files/store_2/goods_135/201312262208557042.jpg','1388038135','2','54');");
E_D("replace into `ecm_uploaded_file` values('56','2','image/jpeg','4026','6.jpg','data/files/store_2/goods_176/201312262209361435.jpg','1388038176','2','55');");
E_D("replace into `ecm_uploaded_file` values('57','2','image/jpeg','3616','5.jpg','data/files/store_2/goods_16/201312262210162177.jpg','1388038216','2','56');");
E_D("replace into `ecm_uploaded_file` values('58','2','image/jpeg','3215','4.jpg','data/files/store_2/goods_57/201312262210575290.jpg','1388038257','2','57');");
E_D("replace into `ecm_uploaded_file` values('59','2','image/jpeg','4460','3.jpg','data/files/store_2/goods_106/201312262211467126.jpg','1388038306','2','58');");
E_D("replace into `ecm_uploaded_file` values('60','2','image/jpeg','4313','2.jpg','data/files/store_2/goods_152/201312262212327144.jpg','1388038352','2','59');");
E_D("replace into `ecm_uploaded_file` values('61','2','image/jpeg','2805','13.jpg','data/files/store_2/goods_90/201312262218109004.jpg','1388038690','2','60');");
E_D("replace into `ecm_uploaded_file` values('62','2','image/jpeg','3275','12.jpg','data/files/store_2/goods_114/201312262218342575.jpg','1388038714','2','61');");
E_D("replace into `ecm_uploaded_file` values('63','2','image/jpeg','3669','11.jpg','data/files/store_2/goods_153/201312262219138421.jpg','1388038753','2','62');");
E_D("replace into `ecm_uploaded_file` values('64','2','image/jpeg','4071','10.jpg','data/files/store_2/goods_6/201312262220067431.jpg','1388038806','2','63');");
E_D("replace into `ecm_uploaded_file` values('65','2','image/jpeg','5055','9.jpg','data/files/store_2/goods_41/201312262220415407.jpg','1388038841','2','64');");
E_D("replace into `ecm_uploaded_file` values('66','2','image/jpeg','5600','8.jpg','data/files/store_2/goods_143/201312262222237668.jpg','1388038943','2','65');");
E_D("replace into `ecm_uploaded_file` values('67','2','image/jpeg','6940','7.jpg','data/files/store_2/goods_186/201312262223061143.jpg','1388038986','2','66');");
E_D("replace into `ecm_uploaded_file` values('68','2','image/jpeg','2975','4.jpg','data/files/store_2/goods_26/201312262223464846.jpg','1388039026','2','67');");
E_D("replace into `ecm_uploaded_file` values('70','2','image/jpeg','7663','2.jpg','data/files/store_2/goods_91/201312262224518849.jpg','1388039091','2','68');");
E_D("replace into `ecm_uploaded_file` values('71','2','image/jpeg','20600','1.jpg','data/files/store_2/goods_131/201312262225311490.jpg','1388039131','2','69');");
E_D("replace into `ecm_uploaded_file` values('72','2','image/jpeg','5494','14.jpg','data/files/store_2/goods_195/201312262233156335.jpg','1388039595','2','70');");
E_D("replace into `ecm_uploaded_file` values('73','2','image/jpeg','4568','13.jpg','data/files/store_2/goods_44/201312262234045839.jpg','1388039644','2','71');");
E_D("replace into `ecm_uploaded_file` values('74','2','image/jpeg','4815','15.jpg','data/files/store_2/goods_113/201312262235137180.jpg','1388039713','2','72');");
E_D("replace into `ecm_uploaded_file` values('75','2','image/jpeg','7724','12.jpg','data/files/store_2/goods_142/201312262235429182.jpg','1388039742','2','73');");
E_D("replace into `ecm_uploaded_file` values('76','2','image/jpeg','5780','11.jpg','data/files/store_2/goods_189/201312262236298305.jpg','1388039789','2','74');");
E_D("replace into `ecm_uploaded_file` values('77','2','image/jpeg','4531','10.jpg','data/files/store_2/goods_38/201312262237189780.jpg','1388039838','2','75');");
E_D("replace into `ecm_uploaded_file` values('78','2','image/jpeg','5618','9.jpg','data/files/store_2/goods_98/201312262238182827.jpg','1388039898','2','76');");
E_D("replace into `ecm_uploaded_file` values('79','2','image/jpeg','5837','8.jpg','data/files/store_2/goods_179/201312262239393163.jpg','1388039979','2','77');");
E_D("replace into `ecm_uploaded_file` values('80','2','image/jpeg','6297','7.jpg','data/files/store_2/goods_54/201312262240547284.jpg','1388040054','2','78');");
E_D("replace into `ecm_uploaded_file` values('81','2','image/jpeg','8033','5.jpg','data/files/store_2/goods_97/201312262241379970.jpg','1388040097','2','79');");
E_D("replace into `ecm_uploaded_file` values('82','2','image/jpeg','18566','3.jpg','data/files/store_2/goods_156/201312262242365477.jpg','1388040156','2','80');");
E_D("replace into `ecm_uploaded_file` values('83','2','image/jpeg','4161','1.jpg','data/files/store_2/goods_111/201312262251512164.jpg','1388040711','2','81');");
E_D("replace into `ecm_uploaded_file` values('84','2','image/jpeg','3634','2.jpg','data/files/store_2/goods_9/201312262253293800.jpg','1388040809','2','82');");
E_D("replace into `ecm_uploaded_file` values('85','2','image/jpeg','4660','3.jpg','data/files/store_2/goods_80/201312262254404774.jpg','1388040880','2','83');");
E_D("replace into `ecm_uploaded_file` values('86','2','image/jpeg','3408','4.jpg','data/files/store_2/goods_155/201312262255558436.jpg','1388040955','2','84');");
E_D("replace into `ecm_uploaded_file` values('87','2','image/jpeg','3648','6.jpg','data/files/store_2/goods_6/201312262256466045.jpg','1388041006','2','85');");
E_D("replace into `ecm_uploaded_file` values('88','2','image/jpeg','5751','5.jpg','data/files/store_2/goods_49/201312262257294186.jpg','1388041049','2','86');");
E_D("replace into `ecm_uploaded_file` values('89','2','image/jpeg','5358','7.jpg','data/files/store_2/goods_86/201312262258066317.jpg','1388041086','2','87');");
E_D("replace into `ecm_uploaded_file` values('90','2','image/jpeg','3272','8.jpg','data/files/store_2/goods_124/201312262258442397.jpg','1388041124','2','88');");
E_D("replace into `ecm_uploaded_file` values('91','2','image/jpeg','4355','9.jpg','data/files/store_2/goods_180/201312262259401924.jpg','1388041180','2','89');");
E_D("replace into `ecm_uploaded_file` values('92','2','image/jpeg','5002','19.jpg','data/files/store_2/goods_60/201312262301006712.jpg','1388041260','2','90');");
E_D("replace into `ecm_uploaded_file` values('93','2','image/jpeg','4741','11.jpg','data/files/store_2/goods_155/201312262302356953.jpg','1388041355','2','91');");
E_D("replace into `ecm_uploaded_file` values('94','2','image/jpeg','3574','12.jpg','data/files/store_2/goods_3/201312262303231812.jpg','1388041403','2','92');");
E_D("replace into `ecm_uploaded_file` values('95','2','image/jpeg','4538','13.jpg','data/files/store_2/goods_48/201312262304085587.jpg','1388041448','2','93');");
E_D("replace into `ecm_uploaded_file` values('96','2','image/jpeg','4219','14.jpg','data/files/store_2/goods_93/201312262304537590.jpg','1388041493','2','94');");
E_D("replace into `ecm_uploaded_file` values('97','2','image/jpeg','5472','15.jpg','data/files/store_2/goods_134/201312262305341913.jpg','1388041534','2','95');");
E_D("replace into `ecm_uploaded_file` values('98','2','image/jpeg','4271','16.jpg','data/files/store_2/goods_170/201312262306104597.jpg','1388041570','2','96');");
E_D("replace into `ecm_uploaded_file` values('99','2','image/jpeg','4039','17.jpg','data/files/store_2/goods_27/201312262307078496.jpg','1388041627','2','97');");
E_D("replace into `ecm_uploaded_file` values('101','2','image/jpeg','4000','20.jpg','data/files/store_2/goods_107/201312262308271759.jpg','1388041707','2','98');");
E_D("replace into `ecm_uploaded_file` values('102','2','image/jpeg','3351','18.jpg','data/files/store_2/goods_113/201312262308337745.jpg','1388041713','2','98');");
E_D("replace into `ecm_uploaded_file` values('103','2','image/jpeg','4201','21.jpg','data/files/store_2/goods_154/201312262309145699.jpg','1388041754','2','98');");
E_D("replace into `ecm_uploaded_file` values('104','2','image/jpeg','40204','mallad_01.jpg','data/files/store_2/goods_123/201406260258439769.jpg','1403693923','2','99');");
E_D("replace into `ecm_uploaded_file` values('106','2','image/jpeg','94112','1f26f4a1dac07fcdcd5ae4b8acddc99.jpeg','data/files/store_2/goods_64/201506061754248535.jpeg','1433555664','2','115');");
E_D("replace into `ecm_uploaded_file` values('107','2','image/jpeg','118578','3a1990acfc68aba230b72d5a6520136.jpeg','data/files/store_2/goods_65/201506061754259924.jpeg','1433555665','2','112');");
E_D("replace into `ecm_uploaded_file` values('108','2','image/jpeg','135268','3db5fcfee0b446069889afb28cb06e9.jpeg','data/files/store_2/goods_66/201506061754267351.jpeg','1433555666','2','112');");
E_D("replace into `ecm_uploaded_file` values('109','2','image/jpeg','156258','3fb412ef6885375107eb087dfbac533.jpeg','data/files/store_2/goods_67/201506061754277798.jpeg','1433555667','2','105');");
E_D("replace into `ecm_uploaded_file` values('110','2','image/jpeg','230260','4bb8c2b56457e092e699d6bd10fffcc.jpeg','data/files/store_2/goods_67/201506061754272687.jpeg','1433555667','2','113');");
E_D("replace into `ecm_uploaded_file` values('111','2','image/jpeg','73701','4ed2ab6b50a581a06fe4877eb67b609.jpeg','data/files/store_2/goods_68/201506061754283634.jpeg','1433555668','2','114');");
E_D("replace into `ecm_uploaded_file` values('112','2','image/jpeg','83956','6eec404c63b4a93a145d34d2dfd1598.jpeg','data/files/store_2/goods_69/201506061754291150.jpeg','1433555669','2','104');");
E_D("replace into `ecm_uploaded_file` values('113','2','image/jpeg','174788','6f289a7e2eba3ac124aa0e1e6068056.jpeg','data/files/store_2/goods_69/201506061754298397.jpeg','1433555669','2','108');");
E_D("replace into `ecm_uploaded_file` values('114','2','image/jpeg','124849','8a31f7eff056ea36557b8d46b567ca1.jpeg','data/files/store_2/goods_70/201506061754304561.jpeg','1433555670','2','105');");
E_D("replace into `ecm_uploaded_file` values('115','2','image/jpeg','178983','8abeaa88e127802563af43e29b7aa14.jpeg','data/files/store_2/goods_71/201506061754318235.jpeg','1433555671','2','116');");
E_D("replace into `ecm_uploaded_file` values('116','2','image/jpeg','288953','8e29c2779ad648fee7ef2922cc29aec.jpeg','data/files/store_2/goods_71/201506061754311394.jpeg','1433555671','2','113');");
E_D("replace into `ecm_uploaded_file` values('117','2','image/jpeg','128168','9bd74cab85f5ff4d8d8e04dff7c4828.jpeg','data/files/store_2/goods_72/201506061754326776.jpeg','1433555672','2','101');");
E_D("replace into `ecm_uploaded_file` values('118','2','image/jpeg','125629','10e523dd4785f33de5076c4d920dcc2.jpeg','data/files/store_2/goods_73/201506061754336940.jpeg','1433555673','2','107');");
E_D("replace into `ecm_uploaded_file` values('119','2','image/jpeg','108673','11a8e47ac7b32dbd9c88f675d63d3b1.jpeg','data/files/store_2/goods_74/201506061754348714.jpeg','1433555674','2','100');");
E_D("replace into `ecm_uploaded_file` values('120','2','image/jpeg','164524','17e0b275adb80f1978b6cef15966c13.jpeg','data/files/store_2/goods_74/201506061754347405.jpeg','1433555674','2','116');");
E_D("replace into `ecm_uploaded_file` values('121','2','image/jpeg','54537','28ceeb0d82d4ae523069da3c09fb926.jpeg','data/files/store_2/goods_75/201506061754352280.jpeg','1433555675','2','114');");
E_D("replace into `ecm_uploaded_file` values('122','2','image/jpeg','94783','31ffd7b67c97d8f78d15cdeec273ba5.jpeg','data/files/store_2/goods_76/201506061754361372.jpeg','1433555676','2','104');");
E_D("replace into `ecm_uploaded_file` values('123','2','image/jpeg','132436','44ec8559a5591b8f166e9b16653e36d.jpeg','data/files/store_2/goods_76/201506061754366574.jpeg','1433555676','2','115');");
E_D("replace into `ecm_uploaded_file` values('124','2','image/jpeg','104091','62d9a569f65b1fddf02099f24a134a9.jpeg','data/files/store_2/goods_77/201506061754371795.jpeg','1433555677','2','104');");
E_D("replace into `ecm_uploaded_file` values('125','2','image/jpeg','243219','159ee9e9f4e65bd57bebe6997dbf2ff.jpeg','data/files/store_2/goods_77/201506061754371716.jpeg','1433555678','2','110');");
E_D("replace into `ecm_uploaded_file` values('126','2','image/jpeg','160092','460e5d1ff276c94605799af64d34a37.jpeg','data/files/store_2/goods_78/201506061754383476.jpeg','1433555678','2','106');");
E_D("replace into `ecm_uploaded_file` values('127','2','image/jpeg','39399','760c1481b43a2380e75f0ad3252c4ac.jpeg','data/files/store_2/goods_79/201506061754398213.jpeg','1433555679','2','109');");
E_D("replace into `ecm_uploaded_file` values('128','2','image/jpeg','172913','884f92d82a75e3b6f64184e7429b73c.jpeg','data/files/store_2/goods_80/201506061754404053.jpeg','1433555680','2','116');");
E_D("replace into `ecm_uploaded_file` values('129','2','image/jpeg','40766','887ce7dfdd44d0058e782e454c75165.jpeg','data/files/store_2/goods_80/201506061754406027.jpeg','1433555680','2','109');");
E_D("replace into `ecm_uploaded_file` values('130','2','image/jpeg','119099','1660f6ae669b2657745efa9337e8386.jpeg','data/files/store_2/goods_81/201506061754418516.jpeg','1433555681','2','106');");
E_D("replace into `ecm_uploaded_file` values('131','2','image/jpeg','139781','4404bc564a45ac739af8e01b308b830.jpeg','data/files/store_2/goods_82/201506061754421930.jpeg','1433555682','2','101');");
E_D("replace into `ecm_uploaded_file` values('132','2','image/jpeg','24247','6694de4a9581ff24400f38a82790d4b.jpeg','data/files/store_2/goods_82/201506061754424757.jpeg','1433555682','2','103');");
E_D("replace into `ecm_uploaded_file` values('133','2','image/jpeg','289115','8820c181ccf840080d0f41de17235fb.jpeg','data/files/store_2/goods_83/201506061754435377.jpeg','1433555683','2','111');");
E_D("replace into `ecm_uploaded_file` values('134','2','image/jpeg','310395','8884c42052f88d8325a4dc5af74e4e6.jpeg','data/files/store_2/goods_84/201506061754442370.jpeg','1433555684','2','110');");
E_D("replace into `ecm_uploaded_file` values('135','2','image/jpeg','158094','67630dbfb199a8cabe8d6bbd9f8e59d.jpeg','data/files/store_2/goods_84/201506061754448989.jpeg','1433555684','2','112');");
E_D("replace into `ecm_uploaded_file` values('136','2','image/jpeg','115849','90697a8e7752f40f473b52e60407c98.jpeg','data/files/store_2/goods_85/201506061754453078.jpeg','1433555685','2','101');");
E_D("replace into `ecm_uploaded_file` values('137','2','image/jpeg','79970','62616584178de334cae5ead42d31ff6.jpeg','data/files/store_2/goods_86/201506061754466109.jpeg','1433555686','2','115');");
E_D("replace into `ecm_uploaded_file` values('138','2','image/jpeg','125695','466262961781af919f42c2a646bf2dd.jpeg','data/files/store_2/goods_86/201506061754465370.jpeg','1433555686','2','108');");
E_D("replace into `ecm_uploaded_file` values('139','2','image/jpeg','160007','a89a8d41cd0a11a2cfbe736370d55b2.jpeg','data/files/store_2/goods_87/201506061754476685.jpeg','1433555687','2','105');");
E_D("replace into `ecm_uploaded_file` values('140','2','image/jpeg','160143','a687601f6d3d2269ca697b477a58a41.jpeg','data/files/store_2/goods_88/201506061754483950.jpeg','1433555688','2','102');");
E_D("replace into `ecm_uploaded_file` values('141','2','image/jpeg','37674','b374888337838b2ec28bdc3a5570d75.jpeg','data/files/store_2/goods_88/201506061754486673.jpeg','1433555688','2','103');");
E_D("replace into `ecm_uploaded_file` values('142','2','image/jpeg','183849','bde3c3b07fc5e1edcf708abcdcad0d5.jpeg','data/files/store_2/goods_89/201506061754499518.jpeg','1433555689','2','106');");
E_D("replace into `ecm_uploaded_file` values('143','2','image/jpeg','140050','cd4a64ae58f93a4e68813aee4553eb6.jpeg','data/files/store_2/goods_90/201506061754506687.jpeg','1433555690','2','107');");
E_D("replace into `ecm_uploaded_file` values('144','2','image/jpeg','147544','cda429d11e899f726e198fc12165d88.jpeg','data/files/store_2/goods_90/201506061754508596.jpeg','1433555690','2','102');");
E_D("replace into `ecm_uploaded_file` values('145','2','image/jpeg','121817','d60a9013330c83308e025c75d3aa5fe.jpeg','data/files/store_2/goods_91/201506061754515107.jpeg','1433555691','2','100');");
E_D("replace into `ecm_uploaded_file` values('146','2','image/jpeg','314244','d77aafec07e3e93286753b9aea4fd96.jpeg','data/files/store_2/goods_92/201506061754525725.jpeg','1433555692','2','110');");
E_D("replace into `ecm_uploaded_file` values('147','2','image/jpeg','88287','d31706ef4995f9a841ee9f2db999d75.jpeg','data/files/store_2/goods_92/201506061754537249.jpeg','1433555693','2','108');");
E_D("replace into `ecm_uploaded_file` values('148','2','image/jpeg','79122','de4ecb8e75dd3a2e920ffcd5e3b71ab.jpeg','data/files/store_2/goods_93/201506061754539883.jpeg','1433555693','2','102');");
E_D("replace into `ecm_uploaded_file` values('149','2','image/jpeg','150989','e5d9a3c3784b1f331017408dfea0dc4.jpeg','data/files/store_2/goods_94/201506061754546723.jpeg','1433555694','2','100');");
E_D("replace into `ecm_uploaded_file` values('150','2','image/jpeg','36068','e9b3fa4317b08b48f8163f9dbe84bdc.jpeg','data/files/store_2/goods_94/201506061754546441.jpeg','1433555694','2','103');");
E_D("replace into `ecm_uploaded_file` values('151','2','image/jpeg','369253','e87edb052ff7e918625cd68f804ab0a.jpeg','data/files/store_2/goods_95/201506061754554445.jpeg','1433555695','2','113');");
E_D("replace into `ecm_uploaded_file` values('152','2','image/jpeg','287597','ea22390d756be34058082c6d5ccc1ba.jpeg','data/files/store_2/goods_96/201506061754563409.jpeg','1433555696','2','111');");
E_D("replace into `ecm_uploaded_file` values('153','2','image/jpeg','306010','eb84d1a6c248e6ea488b5fe2776b3a6.jpeg','data/files/store_2/goods_96/201506061754563774.jpeg','1433555696','2','111');");
E_D("replace into `ecm_uploaded_file` values('154','2','image/jpeg','45354','f2dbfa75116a4706d685a1de0e61688.jpeg','data/files/store_2/goods_97/201506061754572425.jpeg','1433555697','2','114');");
E_D("replace into `ecm_uploaded_file` values('155','2','image/jpeg','130855','fa1bf7f4aaaa701be1c3956eecbf954.jpeg','data/files/store_2/goods_98/201506061754589295.jpeg','1433555698','2','107');");
E_D("replace into `ecm_uploaded_file` values('156','2','image/jpeg','41382','fbd3c21ad94aca503833f6a6de585f8.jpeg','data/files/store_2/goods_98/201506061754587284.jpeg','1433555698','2','109');");

require("../../inc/footer.php");
?>