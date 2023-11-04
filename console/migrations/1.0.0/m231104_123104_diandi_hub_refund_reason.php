<?php

use yii\db\Migration;

class m231104_123104_diandi_hub_refund_reason extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_hub_refund_reason}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'reason' => "varchar(50) NULL",
            'create_time' => "int(11) NULL",
            'update_time' => "int(11) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_hub_refund_reason}}',['id'=>'1','reason'=>'11111111111111','create_time'=>'1646116566','update_time'=>'1650954669']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_hub_refund_reason}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

