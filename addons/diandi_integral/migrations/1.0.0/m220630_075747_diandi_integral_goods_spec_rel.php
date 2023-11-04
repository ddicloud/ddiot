<?php

use yii\db\Migration;

class m220630_075747_diandi_integral_goods_spec_rel extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_integral_goods_spec_rel}}', [
            'id' => "int(11) unsigned NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL COMMENT '商户id'",
            'bloc_id' => "int(11) NULL COMMENT '公司id'",
            'goods_id' => "int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品id'",
            'thumb' => "varchar(255) NULL COMMENT '商品图片'",
            'spec_id' => "int(11) unsigned NOT NULL DEFAULT '0' COMMENT '属性id'",
            'spec_value_id' => "int(11) unsigned NOT NULL DEFAULT '0' COMMENT '属性值组合id'",
            'create_time' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'spec_item_show' => "int(11) NULL DEFAULT '0'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'37','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'6','thumb'=>'202003/03/7a10093f-6af4-31d7-b965-315c7dd6d200.jpg','spec_id'=>'185','spec_value_id'=>'5','create_time'=>'1583182485','spec_item_show'=>'0']);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'38','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'6','thumb'=>'202003/03/3644d417-8cbe-3a40-af72-798278e1b867.jpg','spec_id'=>'185','spec_value_id'=>'21','create_time'=>'1583182485','spec_item_show'=>'0']);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'39','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'6','thumb'=>'202003/03/fee2cf42-6492-3019-9d16-5b6aba2fe15e.jpg','spec_id'=>'186','spec_value_id'=>'8','create_time'=>'1583182485','spec_item_show'=>'0']);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'40','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'6','thumb'=>'202003/03/787c07d4-3293-3854-a03c-3c9f77e936bd.jpg','spec_id'=>'186','spec_value_id'=>'22','create_time'=>'1583182485','spec_item_show'=>'0']);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'73','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'7','thumb'=>'202003/03/e5e33531-d6ed-3faa-b9a1-e2d4859912a5.jpg','spec_id'=>'192','spec_value_id'=>'23','create_time'=>'1583232005','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'74','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'7','thumb'=>'202003/03/78735517-61d4-3c86-a5fd-2cebb3878a63.jpg','spec_id'=>'192','spec_value_id'=>'24','create_time'=>'1583232005','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'75','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'7','thumb'=>'202003/03/45477969-df13-3414-8a33-04766f37f0f1.jpg','spec_id'=>'185','spec_value_id'=>'25','create_time'=>'1583232005','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'76','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'7','thumb'=>'202003/03/7e62e6bb-0170-3694-b1db-6231fd23f45d.jpg','spec_id'=>'185','spec_value_id'=>'26','create_time'=>'1583232005','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'77','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'8','thumb'=>'202003/03/dd5d0463-aad9-3b95-b50d-d4e51f81969e.jpg','spec_id'=>'185','spec_value_id'=>'5','create_time'=>'1583234360','spec_item_show'=>'1']);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'78','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'8','thumb'=>'202003/03/7f5abff3-b980-343f-88a2-eb2e245a9fd9.jpg','spec_id'=>'185','spec_value_id'=>'6','create_time'=>'1583234360','spec_item_show'=>'1']);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'79','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'8','thumb'=>'202003/03/233675eb-18da-3a8a-8782-6fb3fd64d4c6.jpg','spec_id'=>'186','spec_value_id'=>'7','create_time'=>'1583234360','spec_item_show'=>'1']);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'80','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'8','thumb'=>'202003/03/df379cc3-4523-33a0-9b44-c36cb7da594b.jpg','spec_id'=>'186','spec_value_id'=>'8','create_time'=>'1583234360','spec_item_show'=>'1']);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'81','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'9','thumb'=>'202003/03/74ab2f16-eed5-39cd-9c8e-0d71577b75bf.jpg','spec_id'=>'185','spec_value_id'=>'6','create_time'=>'1583235467','spec_item_show'=>'1']);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'82','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'9','thumb'=>'202003/03/e8096948-30fd-3d73-9e71-f1b3ab90f9e5.png','spec_id'=>'185','spec_value_id'=>'5','create_time'=>'1583235467','spec_item_show'=>'1']);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'83','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'9','thumb'=>'202003/03/17b8cf21-4cd3-3ba6-971d-fd091af1597e.jpg','spec_id'=>'186','spec_value_id'=>'7','create_time'=>'1583235467','spec_item_show'=>'1']);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'84','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'9','thumb'=>'202003/03/837772b0-1320-32ec-b2a0-942f13a193fe.jpg','spec_id'=>'186','spec_value_id'=>'7','create_time'=>'1583235467','spec_item_show'=>'1']);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'164','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'11','thumb'=>'202003/03/5cffe221-25a9-3053-b42c-9dc6d2ce606a.jpg','spec_id'=>'185','spec_value_id'=>'5','create_time'=>'1583237270','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'165','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'11','thumb'=>'202003/03/f28a7263-6255-3fb1-8c5a-bd4f61e6cfe6.jpg','spec_id'=>'185','spec_value_id'=>'6','create_time'=>'1583237271','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'166','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'11','thumb'=>'202003/03/178740e1-1e1f-3738-ab95-abeea832e678.jpg','spec_id'=>'185','spec_value_id'=>'20','create_time'=>'1583237271','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'167','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'11','thumb'=>'202003/03/eeebf802-9034-3e69-8304-d0b7d94f3892.jpg','spec_id'=>'186','spec_value_id'=>'8','create_time'=>'1583237271','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'168','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'11','thumb'=>'202003/03/3f1b2992-e539-3f58-acdd-21852ffa3dc8.jpg','spec_id'=>'186','spec_value_id'=>'27','create_time'=>'1583237271','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'170','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'13','thumb'=>'202003/03/13243d1f-d2c1-3dc2-8fa0-01ae26fdb42f.jpg','spec_id'=>'193','spec_value_id'=>'28','create_time'=>'1583237564','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'175','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'10','thumb'=>'202003/03/74ab2f16-eed5-39cd-9c8e-0d71577b75bf.jpg','spec_id'=>'185','spec_value_id'=>'6','create_time'=>'1583244802','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'176','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'10','thumb'=>'202003/03/e8096948-30fd-3d73-9e71-f1b3ab90f9e5.png','spec_id'=>'185','spec_value_id'=>'5','create_time'=>'1583244802','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'177','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'10','thumb'=>'202003/03/837772b0-1320-32ec-b2a0-942f13a193fe.jpg','spec_id'=>'186','spec_value_id'=>'7','create_time'=>'1583244802','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'178','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'10','thumb'=>'202003/03/0a837a6a-c617-31fc-a7ba-9f518eff057b.jpg','spec_id'=>'186','spec_value_id'=>'27','create_time'=>'1583244802','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'243','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'16','thumb'=>'202003/03/3dac6d32-22d7-3fe1-8942-bae152067d26.jpg','spec_id'=>'185','spec_value_id'=>'5','create_time'=>'1583251465','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'244','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'16','thumb'=>'202003/03/5fed5b56-b0eb-3e88-9cd1-3c15598373e5.jpg','spec_id'=>'186','spec_value_id'=>'7','create_time'=>'1583251465','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'269','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'1','thumb'=>'','spec_id'=>'185','spec_value_id'=>'5','create_time'=>'1584269332','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'270','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'1','thumb'=>'','spec_id'=>'185','spec_value_id'=>'6','create_time'=>'1584269332','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'271','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'1','thumb'=>'','spec_id'=>'186','spec_value_id'=>'8','create_time'=>'1584269332','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'272','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'1','thumb'=>'','spec_id'=>'186','spec_value_id'=>'7','create_time'=>'1584269332','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'293','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'2','thumb'=>'202003/20/d2318066-666c-3217-8b93-c8e8ce8154a3.jpg','spec_id'=>'185','spec_value_id'=>'5','create_time'=>'1584648893','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'294','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'2','thumb'=>'202003/20/a03fd3b1-7bed-350a-bdb9-aef4c7da1ea0.png','spec_id'=>'185','spec_value_id'=>'6','create_time'=>'1584648893','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'295','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'2','thumb'=>'202003/20/a4d7fbc3-011c-3f1e-80e4-636e58dcfd07.png','spec_id'=>'186','spec_value_id'=>'8','create_time'=>'1584648893','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'296','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'2','thumb'=>'202003/20/7915208e-b6fe-39d8-9834-e426d0151c2c.jpg','spec_id'=>'186','spec_value_id'=>'7','create_time'=>'1584648894','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'334','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'28','thumb'=>'','spec_id'=>'197','spec_value_id'=>'33','create_time'=>'1586427732','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'335','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'28','thumb'=>'','spec_id'=>'197','spec_value_id'=>'34','create_time'=>'1586427732','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'336','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'28','thumb'=>'','spec_id'=>'198','spec_value_id'=>'35','create_time'=>'1586427732','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'337','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'28','thumb'=>'','spec_id'=>'198','spec_value_id'=>'36','create_time'=>'1586427732','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'384','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'34','thumb'=>'','spec_id'=>'185','spec_value_id'=>'5','create_time'=>'1591515873','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'385','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'34','thumb'=>'','spec_id'=>'185','spec_value_id'=>'6','create_time'=>'1591515873','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'386','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'34','thumb'=>'','spec_id'=>'185','spec_value_id'=>'20','create_time'=>'1591515873','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'387','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'34','thumb'=>'','spec_id'=>'186','spec_value_id'=>'8','create_time'=>'1591515873','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'388','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'34','thumb'=>'','spec_id'=>'186','spec_value_id'=>'7','create_time'=>'1591515873','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'389','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'34','thumb'=>'','spec_id'=>'187','spec_value_id'=>'11','create_time'=>'1591515873','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'390','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'34','thumb'=>'','spec_id'=>'187','spec_value_id'=>'37','create_time'=>'1591515873','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'391','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'35','thumb'=>'','spec_id'=>'186','spec_value_id'=>'38','create_time'=>'1591516845','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'392','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'35','thumb'=>'','spec_id'=>'186','spec_value_id'=>'39','create_time'=>'1591516846','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'393','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'35','thumb'=>'','spec_id'=>'185','spec_value_id'=>'40','create_time'=>'1591516846','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'394','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'35','thumb'=>'','spec_id'=>'185','spec_value_id'=>'41','create_time'=>'1591516846','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'408','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'23','thumb'=>'202004/02/ebff6681-0e2a-36f5-aa7e-f25839df1604.jpg','spec_id'=>'194','spec_value_id'=>'29','create_time'=>'1594289807','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'409','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'23','thumb'=>'202004/02/d722f20c-26b7-3855-9135-e97f6cd1f1a0.jpg','spec_id'=>'195','spec_value_id'=>'30','create_time'=>'1594289807','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'410','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'23','thumb'=>'','spec_id'=>'196','spec_value_id'=>'31','create_time'=>'1594289807','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'411','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'23','thumb'=>'','spec_id'=>'196','spec_value_id'=>'32','create_time'=>'1594289807','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'412','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'29','thumb'=>'','spec_id'=>'185','spec_value_id'=>'5','create_time'=>'1594549026','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'413','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'29','thumb'=>'','spec_id'=>'185','spec_value_id'=>'6','create_time'=>'1594549026','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'414','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'29','thumb'=>'','spec_id'=>'186','spec_value_id'=>'7','create_time'=>'1594549026','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'415','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'29','thumb'=>'','spec_id'=>'186','spec_value_id'=>'8','create_time'=>'1594549026','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'416','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'63','thumb'=>'','spec_id'=>'185','spec_value_id'=>'5','create_time'=>'1594553200','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'417','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'63','thumb'=>'','spec_id'=>'185','spec_value_id'=>'20','create_time'=>'1594553200','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'418','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'63','thumb'=>'','spec_id'=>'186','spec_value_id'=>'8','create_time'=>'1594553200','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'419','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'63','thumb'=>'','spec_id'=>'186','spec_value_id'=>'7','create_time'=>'1594553200','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'420','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'64','thumb'=>'','spec_id'=>'185','spec_value_id'=>'5','create_time'=>'1594553239','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'421','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'64','thumb'=>'','spec_id'=>'185','spec_value_id'=>'6','create_time'=>'1594553239','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'422','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'64','thumb'=>'','spec_id'=>'186','spec_value_id'=>'8','create_time'=>'1594553239','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'423','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'64','thumb'=>'','spec_id'=>'186','spec_value_id'=>'7','create_time'=>'1594553239','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'424','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'64','thumb'=>'','spec_id'=>'186','spec_value_id'=>'42','create_time'=>'1594553239','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'427','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'72','thumb'=>'','spec_id'=>'186','spec_value_id'=>'8','create_time'=>'1596109094','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'428','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'72','thumb'=>'','spec_id'=>'186','spec_value_id'=>'7','create_time'=>'1596109094','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'429','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'72','thumb'=>'','spec_id'=>'185','spec_value_id'=>'5','create_time'=>'1596109094','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'430','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'72','thumb'=>'','spec_id'=>'185','spec_value_id'=>'20','create_time'=>'1596109094','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'499','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'67','thumb'=>'202007/13/521764f9-4078-363d-8fef-708294afaa8b.png','spec_id'=>'185','spec_value_id'=>'43','create_time'=>'1596240418','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'500','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'67','thumb'=>'','spec_id'=>'185','spec_value_id'=>'5','create_time'=>'1596240418','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'501','store_id'=>NULL,'bloc_id'=>NULL,'goods_id'=>'67','thumb'=>'','spec_id'=>'185','spec_value_id'=>'21','create_time'=>'1596240418','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'518','store_id'=>'48','bloc_id'=>'8','goods_id'=>'76','thumb'=>NULL,'spec_id'=>'185','spec_value_id'=>'43','create_time'=>'1608036882','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'519','store_id'=>'48','bloc_id'=>'8','goods_id'=>'76','thumb'=>NULL,'spec_id'=>'185','spec_value_id'=>'6','create_time'=>'1608036882','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'521','store_id'=>'48','bloc_id'=>'8','goods_id'=>'77','thumb'=>NULL,'spec_id'=>'199','spec_value_id'=>'44','create_time'=>'1608036903','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'527','store_id'=>'48','bloc_id'=>'8','goods_id'=>'79','thumb'=>NULL,'spec_id'=>'199','spec_value_id'=>'46','create_time'=>'1608036924','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'528','store_id'=>'48','bloc_id'=>'8','goods_id'=>'80','thumb'=>NULL,'spec_id'=>'199','spec_value_id'=>'47','create_time'=>'1608036936','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'529','store_id'=>'48','bloc_id'=>'8','goods_id'=>'81','thumb'=>NULL,'spec_id'=>'199','spec_value_id'=>'48','create_time'=>'1608036945','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'530','store_id'=>'48','bloc_id'=>'8','goods_id'=>'82','thumb'=>NULL,'spec_id'=>'199','spec_value_id'=>'49','create_time'=>'1608036954','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'536','store_id'=>'48','bloc_id'=>'8','goods_id'=>'78','thumb'=>NULL,'spec_id'=>'199','spec_value_id'=>'45','create_time'=>'1608040426','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'537','store_id'=>'48','bloc_id'=>'8','goods_id'=>'83','thumb'=>NULL,'spec_id'=>'199','spec_value_id'=>'50','create_time'=>'1608103175','spec_item_show'=>'1']);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'538','store_id'=>'48','bloc_id'=>'8','goods_id'=>'84','thumb'=>NULL,'spec_id'=>'185','spec_value_id'=>'51','create_time'=>'1608104459','spec_item_show'=>'1']);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'539','store_id'=>'48','bloc_id'=>'8','goods_id'=>'84','thumb'=>NULL,'spec_id'=>'185','spec_value_id'=>'52','create_time'=>'1608104459','spec_item_show'=>'1']);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'540','store_id'=>'48','bloc_id'=>'8','goods_id'=>'85','thumb'=>NULL,'spec_id'=>'185','spec_value_id'=>'53','create_time'=>'1608105620','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'541','store_id'=>'48','bloc_id'=>'8','goods_id'=>'86','thumb'=>NULL,'spec_id'=>'199','spec_value_id'=>'54','create_time'=>'1608106736','spec_item_show'=>'1']);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'542','store_id'=>'48','bloc_id'=>'8','goods_id'=>'87','thumb'=>NULL,'spec_id'=>'199','spec_value_id'=>'55','create_time'=>'1608178995','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'544','store_id'=>'48','bloc_id'=>'8','goods_id'=>'88','thumb'=>NULL,'spec_id'=>'199','spec_value_id'=>'56','create_time'=>'1608261572','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'545','store_id'=>'48','bloc_id'=>'8','goods_id'=>'90','thumb'=>NULL,'spec_id'=>'199','spec_value_id'=>'57','create_time'=>'1608262621','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'546','store_id'=>'48','bloc_id'=>'8','goods_id'=>'91','thumb'=>NULL,'spec_id'=>'199','spec_value_id'=>'58','create_time'=>'1608266435','spec_item_show'=>'1']);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'547','store_id'=>'48','bloc_id'=>'8','goods_id'=>'92','thumb'=>NULL,'spec_id'=>'199','spec_value_id'=>'59','create_time'=>'1608266935','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'548','store_id'=>'48','bloc_id'=>'8','goods_id'=>'93','thumb'=>NULL,'spec_id'=>'199','spec_value_id'=>'59','create_time'=>'1608267034','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'549','store_id'=>'48','bloc_id'=>'8','goods_id'=>'94','thumb'=>NULL,'spec_id'=>'199','spec_value_id'=>'60','create_time'=>'1608274019','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'550','store_id'=>'48','bloc_id'=>'8','goods_id'=>'95','thumb'=>NULL,'spec_id'=>'199','spec_value_id'=>'61','create_time'=>'1608275533','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'551','store_id'=>'48','bloc_id'=>'8','goods_id'=>'96','thumb'=>NULL,'spec_id'=>'199','spec_value_id'=>'62','create_time'=>'1608276989','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'552','store_id'=>'48','bloc_id'=>'8','goods_id'=>'97','thumb'=>NULL,'spec_id'=>'199','spec_value_id'=>'63','create_time'=>'1608277506','spec_item_show'=>'1']);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'553','store_id'=>'48','bloc_id'=>'8','goods_id'=>'98','thumb'=>NULL,'spec_id'=>'199','spec_value_id'=>'64','create_time'=>'1608369801','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'554','store_id'=>'48','bloc_id'=>'8','goods_id'=>'99','thumb'=>NULL,'spec_id'=>'185','spec_value_id'=>'20','create_time'=>'1608445459','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'555','store_id'=>'48','bloc_id'=>'8','goods_id'=>'99','thumb'=>NULL,'spec_id'=>'185','spec_value_id'=>'6','create_time'=>'1608445459','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'556','store_id'=>'48','bloc_id'=>'8','goods_id'=>'100','thumb'=>NULL,'spec_id'=>'185','spec_value_id'=>'5','create_time'=>'1608446721','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'557','store_id'=>'48','bloc_id'=>'8','goods_id'=>'100','thumb'=>NULL,'spec_id'=>'185','spec_value_id'=>'43','create_time'=>'1608446721','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'558','store_id'=>'48','bloc_id'=>'8','goods_id'=>'101','thumb'=>NULL,'spec_id'=>'199','spec_value_id'=>'65','create_time'=>'1608630542','spec_item_show'=>'1']);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'559','store_id'=>'48','bloc_id'=>'8','goods_id'=>'102','thumb'=>NULL,'spec_id'=>'199','spec_value_id'=>'66','create_time'=>'1608637242','spec_item_show'=>'1']);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'560','store_id'=>'48','bloc_id'=>'8','goods_id'=>'103','thumb'=>NULL,'spec_id'=>'185','spec_value_id'=>'67','create_time'=>'1608640073','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'561','store_id'=>'48','bloc_id'=>'8','goods_id'=>'103','thumb'=>NULL,'spec_id'=>'185','spec_value_id'=>'68','create_time'=>'1608640073','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'562','store_id'=>'48','bloc_id'=>'8','goods_id'=>'103','thumb'=>NULL,'spec_id'=>'185','spec_value_id'=>'69','create_time'=>'1608640073','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'563','store_id'=>'48','bloc_id'=>'8','goods_id'=>'104','thumb'=>NULL,'spec_id'=>'185','spec_value_id'=>'67','create_time'=>'1608640073','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'564','store_id'=>'48','bloc_id'=>'8','goods_id'=>'104','thumb'=>NULL,'spec_id'=>'185','spec_value_id'=>'68','create_time'=>'1608640073','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'565','store_id'=>'48','bloc_id'=>'8','goods_id'=>'104','thumb'=>NULL,'spec_id'=>'185','spec_value_id'=>'69','create_time'=>'1608640073','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'578','store_id'=>'48','bloc_id'=>'8','goods_id'=>'74','thumb'=>NULL,'spec_id'=>'185','spec_value_id'=>'5','create_time'=>'1611837592','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'579','store_id'=>'48','bloc_id'=>'8','goods_id'=>'74','thumb'=>NULL,'spec_id'=>'185','spec_value_id'=>'9','create_time'=>'1611837592','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'580','store_id'=>'48','bloc_id'=>'8','goods_id'=>'74','thumb'=>NULL,'spec_id'=>'185','spec_value_id'=>'21','create_time'=>'1611837592','spec_item_show'=>NULL]);
        $this->insert('{{%diandi_integral_goods_spec_rel}}',['id'=>'581','store_id'=>'48','bloc_id'=>'8','goods_id'=>'74','thumb'=>NULL,'spec_id'=>'185','spec_value_id'=>'43','create_time'=>'1611837592','spec_item_show'=>NULL]);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_integral_goods_spec_rel}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

