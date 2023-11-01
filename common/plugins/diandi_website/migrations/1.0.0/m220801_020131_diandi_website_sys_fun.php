<?php

use yii\db\Migration;

class m220801_020131_diandi_website_sys_fun extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_website_sys_fun}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID'",
            'bloc_id' => "int(11) NOT NULL",
            'store_id' => "int(11) NOT NULL",
            'cate_id' => "int(11) NOT NULL COMMENT '分类ID'",
            'title' => "varchar(45) NOT NULL COMMENT '标题'",
            'icon' => "varchar(180) NOT NULL COMMENT 'ICON'",
            'des' => "varchar(450) NOT NULL COMMENT '描述'",
            'created_at' => "datetime NOT NULL COMMENT '创建时间'",
            'updated_at' => "datetime NOT NULL COMMENT '最后一次更新时间'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='系统功能'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_website_sys_fun}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

