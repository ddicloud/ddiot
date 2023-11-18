<?php

use yii\db\Migration;

class m231118_000433_bloc_conf_api extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%bloc_conf_api}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID'",
            'member_id' => "int(11) NULL",
            'swoole_member_id' => "int(11) NULL",
            'bloc_id' => "int(11) NOT NULL DEFAULT '0' COMMENT '商户ID'",
            'app_id' => "varchar(45) NOT NULL COMMENT 'APP ID'",
            'app_secret' => "varchar(450) NOT NULL COMMENT 'APP SECRET'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商户签名验证'");
        
        /* 索引设置 */
        $this->createIndex('UNIQUE_APP_ID','{{%bloc_conf_api}}','app_id',1);
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%bloc_conf_api}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

