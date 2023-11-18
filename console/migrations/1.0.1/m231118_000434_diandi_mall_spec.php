<?php

use yii\db\Migration;

class m231118_000434_diandi_mall_spec extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_mall_spec}}', [
            'spec_id' => "int(11) unsigned NOT NULL AUTO_INCREMENT",
            'bloc_id' => "int(11) NULL",
            'store_id' => "int(11) NULL",
            'spec_name' => "varchar(255) NOT NULL DEFAULT ''",
            'category_id' => "int(11) NULL",
            'wxapp_id' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'create_time' => "int(11) NOT NULL",
            'PRIMARY KEY (`spec_id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_mall_spec}}',['spec_id'=>'1','bloc_id'=>'13','store_id'=>'62','spec_name'=>'规格1','category_id'=>'2','wxapp_id'=>'0','create_time'=>'1657694341']);
        $this->insert('{{%diandi_mall_spec}}',['spec_id'=>'2','bloc_id'=>'13','store_id'=>'62','spec_name'=>'规格2','category_id'=>'2','wxapp_id'=>'0','create_time'=>'1658715142']);
        $this->insert('{{%diandi_mall_spec}}',['spec_id'=>'3','bloc_id'=>'8','store_id'=>'61','spec_name'=>'时效','category_id'=>'7','wxapp_id'=>'0','create_time'=>'1665281183']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_mall_spec}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

