<?php

use yii\db\Migration;

class m231104_123104_diandi_integral_company extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_integral_company}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'title' => "varchar(255) NULL COMMENT '名称'",
            'code' => "varchar(255) NULL COMMENT '编码'",
            'status' => "int(255) NULL DEFAULT '0' COMMENT '是否启用 1.启用 0.关闭'",
            'display_order' => "int(11) NULL COMMENT '排序'",
            'mobile' => "varchar(20) NULL COMMENT '联系电话'",
            'link_man' => "varchar(30) NULL COMMENT '联系人'",
            'is_default' => "int(11) NULL COMMENT '是否默认 1.默认 0.不默认'",
            'create_time' => "int(11) NULL",
            'update_time' => "int(11) NULL",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'PRIMARY KEY (`id`)'
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
        $this->dropTable('{{%diandi_integral_company}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

