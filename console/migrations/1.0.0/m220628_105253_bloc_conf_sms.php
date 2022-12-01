<?php

use yii\db\Migration;

class m220628_105253_bloc_conf_sms extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%bloc_conf_sms}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'bloc_id' => "int(10) unsigned NULL",
            'access_key_id' => "varchar(255) NULL",
            'access_key_secret' => "varchar(255) NULL DEFAULT '0'",
            'sign_name' => "varchar(255) NULL DEFAULT '0'",
            'template_code' => "varchar(255) NULL",
            'is_login' => "int(11) NULL",
            'update_time' => "int(11) NULL",
            'create_time' => "int(11) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8");
        
        /* 索引设置 */
        $this->createIndex('bloc_id','{{%bloc_conf_sms}}','bloc_id',1);
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%bloc_conf_sms}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

