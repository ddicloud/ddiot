<?php

use yii\db\Migration;

class m230714_032924_user_bloc extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%user_bloc}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'user_id' => "int(11) NULL DEFAULT '0' COMMENT '管理员id'",
            'bloc_id' => "int(11) NULL DEFAULT '0' COMMENT '集团id'",
            'status' => "int(11) NULL COMMENT '是否启用'",
            'is_default' => "smallint(6) NULL DEFAULT '0' COMMENT '是否默认'",
            'create_time' => "varchar(30) NULL",
            'update_time' => "varchar(30) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%user_bloc}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

