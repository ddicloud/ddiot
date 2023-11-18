<?php

use yii\db\Migration;

class m231118_000438_diandi_website_nav extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_website_nav}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'name' => "varchar(128) NOT NULL COMMENT '名称'",
            'parent' => "int(11) NOT NULL COMMENT '父级'",
            'link' => "varchar(255) NULL COMMENT '链接地址'",
            'order' => "int(11) NOT NULL DEFAULT '0' COMMENT '排序'",
            'data' => "blob NULL COMMENT '数据'",
            'type' => "varchar(20) NULL COMMENT '导航类型'",
            'icon' => "varchar(30) NULL COMMENT '图标'",
            'is_show' => "smallint(6) NULL DEFAULT '1' COMMENT '是否显示'",
            'store_id' => "int(11) NULL COMMENT '商户'",
            'bloc_id' => "int(11) NULL COMMENT '公司'",
            'create_time' => "int(11) NULL COMMENT '创建时间'",
            'update_time' => "int(11) NULL COMMENT '更新时间'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8");
        
        /* 索引设置 */
        $this->createIndex('parent','{{%diandi_website_nav}}','parent',0);
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_website_nav}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

