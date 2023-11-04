<?php

use yii\db\Migration;

class m231104_123104_diandi_hub_spec_value extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_hub_spec_value}}', [
            'spec_value_id' => "int(11) unsigned NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'spec_value' => "varchar(255) NOT NULL",
            'spec_id' => "int(11) NOT NULL",
            'create_time' => "int(11) NOT NULL",
            'category_ids' => "text NULL COMMENT '关联分类默认值'",
            'PRIMARY KEY (`spec_value_id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'10','store_id'=>'82','bloc_id'=>'33','spec_value'=>'红色','spec_id'=>'1','create_time'=>'1650619238','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'11','store_id'=>'82','bloc_id'=>'33','spec_value'=>'绿色','spec_id'=>'1','create_time'=>'1650619238','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'12','store_id'=>'82','bloc_id'=>'33','spec_value'=>'红色','spec_id'=>'1','create_time'=>'1650619309','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'13','store_id'=>'82','bloc_id'=>'33','spec_value'=>'绿色','spec_id'=>'1','create_time'=>'1650619309','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'14','store_id'=>'82','bloc_id'=>'33','spec_value'=>'红色','spec_id'=>'1','create_time'=>'1650619321','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'15','store_id'=>'82','bloc_id'=>'33','spec_value'=>'绿色','spec_id'=>'1','create_time'=>'1650619321','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'16','store_id'=>'82','bloc_id'=>'33','spec_value'=>'红色','spec_id'=>'1','create_time'=>'1650619364','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'17','store_id'=>'82','bloc_id'=>'33','spec_value'=>'绿色','spec_id'=>'1','create_time'=>'1650619364','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'18','store_id'=>'82','bloc_id'=>'33','spec_value'=>'红色','spec_id'=>'1','create_time'=>'1650619452','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'19','store_id'=>'82','bloc_id'=>'33','spec_value'=>'绿色','spec_id'=>'1','create_time'=>'1650619452','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'20','store_id'=>'82','bloc_id'=>'33','spec_value'=>'红色','spec_id'=>'1','create_time'=>'1650619518','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'21','store_id'=>'82','bloc_id'=>'33','spec_value'=>'绿色','spec_id'=>'1','create_time'=>'1650619518','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'22','store_id'=>'82','bloc_id'=>'33','spec_value'=>'红色','spec_id'=>'1','create_time'=>'1650619528','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'23','store_id'=>'82','bloc_id'=>'33','spec_value'=>'绿色','spec_id'=>'1','create_time'=>'1650619528','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'24','store_id'=>'82','bloc_id'=>'33','spec_value'=>'红色','spec_id'=>'1','create_time'=>'1650619573','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'25','store_id'=>'82','bloc_id'=>'33','spec_value'=>'绿色','spec_id'=>'1','create_time'=>'1650619573','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'26','store_id'=>'79','bloc_id'=>'30','spec_value'=>'34','spec_id'=>'2','create_time'=>'1652240390','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'27','store_id'=>'80','bloc_id'=>'31','spec_value'=>'12','spec_id'=>'3','create_time'=>'1652690108','category_ids'=>'11,12,13,15']);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'28','store_id'=>'80','bloc_id'=>'31','spec_value'=>'2.12','spec_id'=>'4','create_time'=>'1652690487','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'29','store_id'=>'80','bloc_id'=>'31','spec_value'=>'中熟','spec_id'=>'5','create_time'=>'1652690487','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'30','store_id'=>'80','bloc_id'=>'31','spec_value'=>'中熟','spec_id'=>'5','create_time'=>'1652690856','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'31','store_id'=>'80','bloc_id'=>'31','spec_value'=>'1','spec_id'=>'3','create_time'=>'1652692868','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'32','store_id'=>'80','bloc_id'=>'31','spec_value'=>'红色','spec_id'=>'1','create_time'=>'1652693357','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'33','store_id'=>'80','bloc_id'=>'31','spec_value'=>'绿色','spec_id'=>'1','create_time'=>'1652693357','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'34','store_id'=>'80','bloc_id'=>'31','spec_value'=>'xl','spec_id'=>'6','create_time'=>'1652693357','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'35','store_id'=>'80','bloc_id'=>'31','spec_value'=>'xxl','spec_id'=>'6','create_time'=>'1652693357','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'36','store_id'=>'80','bloc_id'=>'31','spec_value'=>'xmm','spec_id'=>'6','create_time'=>'1652693357','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'37','store_id'=>'80','bloc_id'=>'31','spec_value'=>'111','spec_id'=>'7','create_time'=>'1652694225','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'38','store_id'=>'80','bloc_id'=>'31','spec_value'=>'红色','spec_id'=>'1','create_time'=>'1652698796','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'39','store_id'=>'80','bloc_id'=>'31','spec_value'=>'全熟','spec_id'=>'5','create_time'=>'1652698796','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'40','store_id'=>'80','bloc_id'=>'31','spec_value'=>'中熟','spec_id'=>'5','create_time'=>'1652752942','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'41','store_id'=>'80','bloc_id'=>'31','spec_value'=>'1.22','spec_id'=>'8','create_time'=>'1652752942','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'42','store_id'=>'80','bloc_id'=>'31','spec_value'=>'红色','spec_id'=>'1','create_time'=>'1652755778','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'43','store_id'=>'80','bloc_id'=>'31','spec_value'=>'红色','spec_id'=>'1','create_time'=>'1652755916','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'44','store_id'=>'80','bloc_id'=>'31','spec_value'=>'1','spec_id'=>'3','create_time'=>'1652756635','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'45','store_id'=>'80','bloc_id'=>'31','spec_value'=>'中熟','spec_id'=>'5','create_time'=>'1652756959','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'46','store_id'=>'80','bloc_id'=>'31','spec_value'=>'1','spec_id'=>'10','create_time'=>'1652757127','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'47','store_id'=>'80','bloc_id'=>'31','spec_value'=>'1','spec_id'=>'3','create_time'=>'1652757189','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'48','store_id'=>'80','bloc_id'=>'31','spec_value'=>'1','spec_id'=>'3','create_time'=>'1652757189','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'49','store_id'=>'80','bloc_id'=>'31','spec_value'=>'1','spec_id'=>'10','create_time'=>'1652757541','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'50','store_id'=>'80','bloc_id'=>'31','spec_value'=>'1','spec_id'=>'10','create_time'=>'1652774369','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'51','store_id'=>'80','bloc_id'=>'31','spec_value'=>'13','spec_id'=>'10','create_time'=>'1652947384','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'52','store_id'=>'80','bloc_id'=>'31','spec_value'=>'133','spec_id'=>'10','create_time'=>'1652947404','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'53','store_id'=>'80','bloc_id'=>'31','spec_value'=>'中熟','spec_id'=>'5','create_time'=>'1653125063','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'54','store_id'=>'80','bloc_id'=>'31','spec_value'=>'1.51','spec_id'=>'8','create_time'=>'1653125063','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'55','store_id'=>'80','bloc_id'=>'31','spec_value'=>'全熟','spec_id'=>'5','create_time'=>'1653127242','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'56','store_id'=>'80','bloc_id'=>'31','spec_value'=>'1.12','spec_id'=>'8','create_time'=>'1653127242','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'57','store_id'=>'80','bloc_id'=>'31','spec_value'=>'全熟','spec_id'=>'5','create_time'=>'1653127264','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'58','store_id'=>'80','bloc_id'=>'31','spec_value'=>'1.12','spec_id'=>'8','create_time'=>'1653127264','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'59','store_id'=>'80','bloc_id'=>'31','spec_value'=>'全熟','spec_id'=>'5','create_time'=>'1653127368','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'60','store_id'=>'80','bloc_id'=>'31','spec_value'=>'全熟','spec_id'=>'5','create_time'=>'1653127799','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'61','store_id'=>'80','bloc_id'=>'31','spec_value'=>'1.12','spec_id'=>'8','create_time'=>'1653127799','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'62','store_id'=>'80','bloc_id'=>'31','spec_value'=>'70CM','spec_id'=>'8','create_time'=>'1653516329','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'63','store_id'=>'82','bloc_id'=>'33','spec_value'=>'颜色','spec_id'=>'10','create_time'=>'1653552851','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'64','store_id'=>'82','bloc_id'=>'33','spec_value'=>'大小','spec_id'=>'10','create_time'=>'1653552880','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'65','store_id'=>'82','bloc_id'=>'33','spec_value'=>'规格二颜色','spec_id'=>'11','create_time'=>'1653552901','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'66','store_id'=>'80','bloc_id'=>'31','spec_value'=>'A','spec_id'=>'12','create_time'=>'1655105673','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'67','store_id'=>'80','bloc_id'=>'31','spec_value'=>'B','spec_id'=>'12','create_time'=>'1655105723','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'68','store_id'=>'80','bloc_id'=>'31','spec_value'=>'绿色','spec_id'=>'1','create_time'=>'1655105809','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'69','store_id'=>'80','bloc_id'=>'31','spec_value'=>'C','spec_id'=>'12','create_time'=>'1655105809','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'70','store_id'=>'80','bloc_id'=>'31','spec_value'=>'D','spec_id'=>'12','create_time'=>'1655105856','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'71','store_id'=>'80','bloc_id'=>'31','spec_value'=>'E','spec_id'=>'12','create_time'=>'1655105883','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'72','store_id'=>'80','bloc_id'=>'31','spec_value'=>'A','spec_id'=>'12','create_time'=>'1655105902','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'73','store_id'=>'80','bloc_id'=>'31','spec_value'=>'A','spec_id'=>'12','create_time'=>'1655176682','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'74','store_id'=>'80','bloc_id'=>'31','spec_value'=>'12','spec_id'=>'3','create_time'=>'1655177788','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'75','store_id'=>'80','bloc_id'=>'31','spec_value'=>'A级','spec_id'=>'12','create_time'=>'1655395228','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'76','store_id'=>'80','bloc_id'=>'31','spec_value'=>'11','spec_id'=>'7','create_time'=>'1656991448','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'77','store_id'=>'80','bloc_id'=>'31','spec_value'=>'12','spec_id'=>'16','create_time'=>'1656991448','category_ids'=>NULL]);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'78','store_id'=>'80','bloc_id'=>'31','spec_value'=>'123123','spec_id'=>'3','create_time'=>'1657693380','category_ids'=>'11,12,13']);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'79','store_id'=>'0','bloc_id'=>'0','spec_value'=>'100','spec_id'=>'17','create_time'=>'1666951780','category_ids'=>'19']);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'80','store_id'=>'0','bloc_id'=>'0','spec_value'=>'200','spec_id'=>'17','create_time'=>'1666953904','category_ids'=>'19']);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'81','store_id'=>'0','bloc_id'=>'0','spec_value'=>'200','spec_id'=>'18','create_time'=>'1666953966','category_ids'=>'19']);
        $this->insert('{{%diandi_hub_spec_value}}',['spec_value_id'=>'82','store_id'=>'86','bloc_id'=>'35','spec_value'=>'100','spec_id'=>'19','create_time'=>'1667642069','category_ids'=>'21']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_hub_spec_value}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

