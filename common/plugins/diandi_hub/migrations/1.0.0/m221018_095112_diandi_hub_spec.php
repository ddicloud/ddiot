<?php

use yii\db\Migration;

class m221018_095112_diandi_hub_spec extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_hub_spec}}', [
            'spec_id' => "int(11) unsigned NOT NULL AUTO_INCREMENT",
            'bloc_id' => "int(11) NULL",
            'store_id' => "int(11) NULL",
            'spec_name' => "varchar(255) NOT NULL DEFAULT ''",
            'category_id' => "int(11) NULL",
            'wxapp_id' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'create_time' => "int(11) NOT NULL",
            'PRIMARY KEY (`spec_id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_hub_spec}}',['spec_id'=>'1','bloc_id'=>'33','store_id'=>'82','spec_name'=>'颜色','category_id'=>NULL,'wxapp_id'=>'0','create_time'=>'1650619004']);
        $this->insert('{{%diandi_hub_spec}}',['spec_id'=>'2','bloc_id'=>'30','store_id'=>'79','spec_name'=>'2323','category_id'=>NULL,'wxapp_id'=>'0','create_time'=>'1652240390']);
        $this->insert('{{%diandi_hub_spec}}',['spec_id'=>'3','bloc_id'=>'31','store_id'=>'80','spec_name'=>'12','category_id'=>'15','wxapp_id'=>'0','create_time'=>'1652690108']);
        $this->insert('{{%diandi_hub_spec}}',['spec_id'=>'4','bloc_id'=>'31','store_id'=>'80','spec_name'=>'瑕疵','category_id'=>'12','wxapp_id'=>'0','create_time'=>'1652690487']);
        $this->insert('{{%diandi_hub_spec}}',['spec_id'=>'5','bloc_id'=>'31','store_id'=>'80','spec_name'=>'成熟度','category_id'=>'13','wxapp_id'=>'0','create_time'=>'1652690487']);
        $this->insert('{{%diandi_hub_spec}}',['spec_id'=>'6','bloc_id'=>'31','store_id'=>'80','spec_name'=>'尺寸','category_id'=>NULL,'wxapp_id'=>'0','create_time'=>'1652693357']);
        $this->insert('{{%diandi_hub_spec}}',['spec_id'=>'7','bloc_id'=>'31','store_id'=>'80','spec_name'=>'11','category_id'=>'12','wxapp_id'=>'0','create_time'=>'1652694225']);
        $this->insert('{{%diandi_hub_spec}}',['spec_id'=>'8','bloc_id'=>'31','store_id'=>'80','spec_name'=>'枝长','category_id'=>NULL,'wxapp_id'=>'0','create_time'=>'1652752942']);
        $this->insert('{{%diandi_hub_spec}}',['spec_id'=>'10','bloc_id'=>'31','store_id'=>'80','spec_name'=>'规格1','category_id'=>NULL,'wxapp_id'=>'0','create_time'=>'1652757127']);
        $this->insert('{{%diandi_hub_spec}}',['spec_id'=>'11','bloc_id'=>'33','store_id'=>'82','spec_name'=>'规格2','category_id'=>NULL,'wxapp_id'=>'0','create_time'=>'1653552901']);
        $this->insert('{{%diandi_hub_spec}}',['spec_id'=>'12','bloc_id'=>'31','store_id'=>'80','spec_name'=>'等级','category_id'=>NULL,'wxapp_id'=>'0','create_time'=>'1655105673']);
        $this->insert('{{%diandi_hub_spec}}',['spec_id'=>'14','bloc_id'=>'31','store_id'=>'80','spec_name'=>'扎','category_id'=>'11','wxapp_id'=>'0','create_time'=>'1655176916']);
        $this->insert('{{%diandi_hub_spec}}',['spec_id'=>'15','bloc_id'=>'0','store_id'=>'0','spec_name'=>'','category_id'=>NULL,'wxapp_id'=>'0','create_time'=>'1656987982']);
        $this->insert('{{%diandi_hub_spec}}',['spec_id'=>'16','bloc_id'=>'31','store_id'=>'80','spec_name'=>'123','category_id'=>NULL,'wxapp_id'=>'0','create_time'=>'1656991448']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_hub_spec}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

