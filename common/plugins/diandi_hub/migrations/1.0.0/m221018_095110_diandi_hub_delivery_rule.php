<?php

use yii\db\Migration;

class m221018_095110_diandi_hub_delivery_rule extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_hub_delivery_rule}}', [
            'rule_id' => "int(11) unsigned NOT NULL AUTO_INCREMENT",
            'bloc_id' => "int(11) NULL",
            'store_id' => "int(11) NULL",
            'delivery_id' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'region' => "text NOT NULL",
            'first' => "double unsigned NOT NULL DEFAULT '0'",
            'first_fee' => "decimal(10,2) unsigned NOT NULL",
            'additional' => "double unsigned NOT NULL DEFAULT '0'",
            'additional_fee' => "decimal(10,2) unsigned NOT NULL",
            'wxapp_id' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'create_time' => "int(11) unsigned NOT NULL",
            'PRIMARY KEY (`rule_id`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_hub_delivery_rule}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

