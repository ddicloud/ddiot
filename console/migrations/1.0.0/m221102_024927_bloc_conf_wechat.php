<?php

use yii\db\Migration;

class m221102_024927_bloc_conf_wechat extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%bloc_conf_wechat}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'bloc_id' => "int(10) unsigned NULL",
            'app_id' => "varchar(255) NULL COMMENT 'app_id'",
            'secret' => "varchar(255) NULL DEFAULT '0' COMMENT 'secret'",
            'token' => "varchar(255) NULL DEFAULT '0' COMMENT 'token'",
            'aes_key' => "varchar(255) NULL COMMENT 'aes_key'",
            'headimg' => "varchar(255) NULL COMMENT '公众号头像'",
            'update_time' => "int(11) NULL",
            'create_time' => "int(11) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='公众号配置'");
        
        /* 索引设置 */
        $this->createIndex('bloc_id','{{%bloc_conf_wechat}}','bloc_id',1);
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%bloc_conf_wechat}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

