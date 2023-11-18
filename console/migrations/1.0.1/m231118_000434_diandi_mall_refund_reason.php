<?php

use yii\db\Migration;

class m231118_000434_diandi_mall_refund_reason extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_mall_refund_reason}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'reason' => "varchar(50) NULL",
            'create_time' => "int(11) NULL",
            'update_time' => "int(11) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_mall_refund_reason}}',['id'=>'1','reason'=>'原因1','create_time'=>'1658804565','update_time'=>'1658804565']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_mall_refund_reason}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

