<?php

use yii\db\Migration;

class m221105_121058_store_label extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%store_label}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'bloc_id' => "int(11) NOT NULL COMMENT '公司ID'",
            'store_id' => "int(11) NOT NULL COMMENT '商户id'",
            'name' => "varchar(255) NULL COMMENT '标签名称'",
            'thumb' => "varchar(255) NULL COMMENT '标签图片'",
            'displayorder' => "int(11) NULL COMMENT '排序'",
            'color' => "varchar(30) NULL COMMENT '颜色'",
            'is_show' => "int(11) NOT NULL COMMENT '是否显示'",
            'create_time' => "varchar(30) NULL",
            'update_time' => "varchar(30) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%store_label}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

