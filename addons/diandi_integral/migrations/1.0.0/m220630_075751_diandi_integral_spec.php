<?php

use yii\db\Migration;

class m220630_075751_diandi_integral_spec extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_integral_spec}}', [
            'spec_id' => "int(11) unsigned NOT NULL AUTO_INCREMENT",
            'bloc_id' => "int(11) NULL",
            'store_id' => "int(11) NULL",
            'spec_name' => "varchar(255) NOT NULL DEFAULT ''",
            'wxapp_id' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'create_time' => "int(11) NOT NULL",
            'PRIMARY KEY (`spec_id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_integral_spec}}',['spec_id'=>'185','bloc_id'=>NULL,'store_id'=>NULL,'spec_name'=>'颜色','wxapp_id'=>'0','create_time'=>'1578336531']);
        $this->insert('{{%diandi_integral_spec}}',['spec_id'=>'186','bloc_id'=>NULL,'store_id'=>NULL,'spec_name'=>'尺寸','wxapp_id'=>'0','create_time'=>'1578336531']);
        $this->insert('{{%diandi_integral_spec}}',['spec_id'=>'187','bloc_id'=>NULL,'store_id'=>NULL,'spec_name'=>'材料','wxapp_id'=>'0','create_time'=>'1578341609']);
        $this->insert('{{%diandi_integral_spec}}',['spec_id'=>'188','bloc_id'=>NULL,'store_id'=>NULL,'spec_name'=>'','wxapp_id'=>'0','create_time'=>'1578557108']);
        $this->insert('{{%diandi_integral_spec}}',['spec_id'=>'189','bloc_id'=>NULL,'store_id'=>NULL,'spec_name'=>'尺寸w','wxapp_id'=>'0','create_time'=>'1578638143']);
        $this->insert('{{%diandi_integral_spec}}',['spec_id'=>'190','bloc_id'=>NULL,'store_id'=>NULL,'spec_name'=>'号码','wxapp_id'=>'0','create_time'=>'1578638524']);
        $this->insert('{{%diandi_integral_spec}}',['spec_id'=>'191','bloc_id'=>NULL,'store_id'=>NULL,'spec_name'=>'没想到','wxapp_id'=>'0','create_time'=>'1578639354']);
        $this->insert('{{%diandi_integral_spec}}',['spec_id'=>'192','bloc_id'=>NULL,'store_id'=>NULL,'spec_name'=>'产地','wxapp_id'=>'0','create_time'=>'1583222492']);
        $this->insert('{{%diandi_integral_spec}}',['spec_id'=>'193','bloc_id'=>NULL,'store_id'=>NULL,'spec_name'=>'周期','wxapp_id'=>'0','create_time'=>'1583237534']);
        $this->insert('{{%diandi_integral_spec}}',['spec_id'=>'194','bloc_id'=>NULL,'store_id'=>NULL,'spec_name'=>'红','wxapp_id'=>'0','create_time'=>'1585821036']);
        $this->insert('{{%diandi_integral_spec}}',['spec_id'=>'195','bloc_id'=>NULL,'store_id'=>NULL,'spec_name'=>'绿','wxapp_id'=>'0','create_time'=>'1585821093']);
        $this->insert('{{%diandi_integral_spec}}',['spec_id'=>'196','bloc_id'=>NULL,'store_id'=>NULL,'spec_name'=>'大小','wxapp_id'=>'0','create_time'=>'1586334033']);
        $this->insert('{{%diandi_integral_spec}}',['spec_id'=>'197','bloc_id'=>NULL,'store_id'=>NULL,'spec_name'=>'版本','wxapp_id'=>'0','create_time'=>'1586427299']);
        $this->insert('{{%diandi_integral_spec}}',['spec_id'=>'198','bloc_id'=>NULL,'store_id'=>NULL,'spec_name'=>'服务','wxapp_id'=>'0','create_time'=>'1586427299']);
        $this->insert('{{%diandi_integral_spec}}',['spec_id'=>'199','bloc_id'=>'8','store_id'=>'48','spec_name'=>'规格','wxapp_id'=>'0','create_time'=>'1608018311']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_integral_spec}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

