<?php

use yii\db\Migration;

class m231104_123105_diandi_mall_delivery extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_mall_delivery}}', [
            'delivery_id' => "int(11) unsigned NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'name' => "varchar(255) NOT NULL DEFAULT ''",
            'method' => "tinyint(3) unsigned NOT NULL DEFAULT '10'",
            'sort' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'wxapp_id' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'create_time' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'update_time' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'province' => "varchar(255) NULL",
            'city' => "varchar(255) NULL",
            'district' => "varchar(255) NULL",
            'PRIMARY KEY (`delivery_id`)'
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
        $this->dropTable('{{%diandi_mall_delivery}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

