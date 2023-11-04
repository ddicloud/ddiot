<?php

use yii\db\Migration;

class m231104_123105_diandi_website_pro_config extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_website_pro_config}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'create_time' => "varchar(30) NULL",
            'update_time' => "varchar(30) NULL",
            'image_a' => "varchar(255) NULL COMMENT '公众号演示二维码'",
            'image_b' => "varchar(255) NULL COMMENT '商城二维码'",
            'image_c' => "varchar(255) NULL COMMENT '官方公众号二维码'",
            'image_d' => "varchar(255) NULL COMMENT '官方商城二维码'",
            'price_system' => "text NULL COMMENT '价格体系'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_website_pro_config}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

