<?php

use yii\db\Migration;

class m221102_024927_user_action_log extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%user_action_log}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'user_id' => "int(11) NULL COMMENT '用户'",
            'operation' => "varchar(100) NULL COMMENT '操作'",
            'logtime' => "datetime NULL COMMENT '操作时间'",
            'logip' => "varchar(20) NULL COMMENT '操作ip'",
            'create_time' => "datetime NULL",
            'update_time' => "datetime NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM DEFAULT CHARSET=utf8");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%user_action_log}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

