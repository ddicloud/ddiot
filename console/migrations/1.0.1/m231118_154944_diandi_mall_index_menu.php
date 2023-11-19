<?php

use yii\db\Migration;

class m231118_154944_diandi_mall_index_menu extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_mall_index_menu}}', [
            'id' => "int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id'",
            'name' => "varchar(255) NOT NULL DEFAULT '' COMMENT '按钮名称'",
            'url' => "varchar(255) NOT NULL COMMENT '链接地址'",
            'thumb' => "varchar(255) NULL COMMENT '图片'",
            'query' => "varchar(255) NULL COMMENT '参数'",
            'displayorder' => "int(11) NULL COMMENT '排序'",
            'status' => "int(11) NULL DEFAULT '0' COMMENT '状态'",
            'update_time' => "int(11) NULL COMMENT '更新时间'",
            'create_time' => "int(11) NULL COMMENT '创建时间'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_mall_index_menu}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

