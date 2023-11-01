<?php

use yii\db\Migration;

class m220801_020131_diandi_website_sys_worth extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_website_sys_worth}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID'",
            'bloc_id' => "int(11) NOT NULL",
            'store_id' => "int(11) NOT NULL",
            'solution_id' => "tinyint(2) NOT NULL DEFAULT '0' COMMENT '解决案例ID'",
            'is_website' => "tinyint(2) NOT NULL DEFAULT '-1' COMMENT '是否是官网'",
            'title' => "varchar(45) NOT NULL COMMENT '标题'",
            'icon' => "varchar(180) NOT NULL",
            'des' => "varchar(450) NOT NULL COMMENT '描述'",
            'created_at' => "datetime NOT NULL COMMENT '创建时间'",
            'updated_at' => "datetime NOT NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='系统价值'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_website_sys_worth}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

