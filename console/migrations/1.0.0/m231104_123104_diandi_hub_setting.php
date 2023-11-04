<?php

use yii\db\Migration;

class m231104_123104_diandi_hub_setting extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_hub_setting}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'type' => "varchar(10) NOT NULL",
            'section' => "varchar(255) NOT NULL",
            'key' => "varchar(255) NOT NULL",
            'value' => "text NOT NULL",
            'status' => "smallint(6) NOT NULL DEFAULT '1'",
            'description' => "varchar(255) NULL",
            'created_at' => "int(11) NOT NULL",
            'updated_at' => "int(11) NOT NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_hub_setting}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

