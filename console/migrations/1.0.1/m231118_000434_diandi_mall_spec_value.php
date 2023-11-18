<?php

use yii\db\Migration;

class m231118_000434_diandi_mall_spec_value extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_mall_spec_value}}', [
            'spec_value_id' => "int(11) unsigned NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'spec_value' => "varchar(255) NOT NULL",
            'spec_id' => "int(11) NOT NULL",
            'create_time' => "int(11) NOT NULL",
            'category_ids' => "text NULL COMMENT '关联分类默认值'",
            'PRIMARY KEY (`spec_value_id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_mall_spec_value}}',['spec_value_id'=>'1','store_id'=>'62','bloc_id'=>'13','spec_value'=>'规格1','spec_id'=>'1','create_time'=>'1657695103','category_ids'=>'2']);
        $this->insert('{{%diandi_mall_spec_value}}',['spec_value_id'=>'2','store_id'=>'62','bloc_id'=>'13','spec_value'=>'12','spec_id'=>'1','create_time'=>'1658715154','category_ids'=>'2,4,5']);
        $this->insert('{{%diandi_mall_spec_value}}',['spec_value_id'=>'3','store_id'=>'61','bloc_id'=>'8','spec_value'=>'年限','spec_id'=>'3','create_time'=>'1665281281','category_ids'=>'7']);
        $this->insert('{{%diandi_mall_spec_value}}',['spec_value_id'=>'4','store_id'=>'61','bloc_id'=>'8','spec_value'=>'有效期','spec_id'=>'3','create_time'=>'1665281311','category_ids'=>'7']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_mall_spec_value}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

