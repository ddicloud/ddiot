<?php

use yii\db\Migration;

class m231118_000438_user extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%user}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'mobile' => "varchar(11) NULL COMMENT '手机号'",
            'company' => "varchar(100) NULL COMMENT '公司名称'",
            'username' => "varchar(255) NOT NULL",
            'auth_key' => "varchar(32) NOT NULL",
            'password_hash' => "varchar(255) NOT NULL",
            'password_reset_token' => "varchar(255) NULL",
            'email' => "varchar(255) NOT NULL",
            'parent_bloc_id' => "int(11) NULL",
            'store_id' => "int(11) NULL DEFAULT '0'",
            'bloc_id' => "int(11) NULL DEFAULT '0'",
            'status' => "smallint(6) NOT NULL DEFAULT '10'",
            'created_at' => "int(11) NOT NULL",
            'updated_at' => "int(11) NOT NULL",
            'verification_token' => "varchar(255) NULL",
            'last_time' => "int(11) NULL",
            'avatar' => "varchar(255) NULL",
            'is_login' => "int(11) NULL DEFAULT '0'",
            'last_login_ip' => "varchar(50) NULL",
            'open_id' => "varchar(90) NULL COMMENT '微信OPEN ID'",
            'union_id' => "varchar(90) NULL COMMENT '微信unionid'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");
        
        /* 索引设置 */
        $this->createIndex('username','{{%user}}','username',1);
        $this->createIndex('email','{{%user}}','email',1);
        $this->createIndex('password_reset_token','{{%user}}','password_reset_token',1);
        $this->createIndex('UNIQUE_OPEN_ID','{{%user}}','open_id',1);
        $this->createIndex('UNIQUE_UNION_ID','{{%user}}','union_id',1);
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%user}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

