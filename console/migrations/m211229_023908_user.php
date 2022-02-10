<?php

use yii\db\Migration;

class m211229_023908_user extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%user}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'username' => "varchar(255) NOT NULL",
            'auth_key' => "varchar(32) NOT NULL",
            'password_hash' => "varchar(255) NOT NULL",
            'password_reset_token' => "varchar(255) NULL",
            'email' => "varchar(255) NOT NULL",
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
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");
        
        /* 索引设置 */
        $this->createIndex('username','{{%user}}','username',1);
        $this->createIndex('email','{{%user}}','email',1);
        $this->createIndex('password_reset_token','{{%user}}','password_reset_token',1);
        
        
        /* 表数据 */
        $this->insert('{{%user}}',['id'=>'11','username'=>'admin','auth_key'=>'ddkNMK6gRRPa82aYfvTfzmQ0xYHyZT-i','password_hash'=>'$2y$13$psFPZds7682kXvzz7kYf4.4UrcxmFA/ZoTyLYMvRlYUKTBj6n/quW','password_reset_token'=>NULL,'email'=>'admin@163.com','store_id'=>'0','bloc_id'=>'0','status'=>'10','created_at'=>'1586678074','updated_at'=>'1640705465','verification_token'=>NULL,'last_time'=>'1640705433','avatar'=>NULL,'is_login'=>'1','last_login_ip'=>'219.145.4.154']);
        $this->insert('{{%user}}',['id'=>'12','username'=>'ceshi','auth_key'=>'c62gSJ19zMIAZiJLbXD92OqCAcBvB2TI','password_hash'=>'$2y$13$w806Fvg3CmbHTNS1BBxrSelh1l6yWxdonEDT2z0VOPYKfFuILBCy.','password_reset_token'=>NULL,'email'=>'1654@23.com','store_id'=>'0','bloc_id'=>'0','status'=>'10','created_at'=>'1640710163','updated_at'=>'1640710163','verification_token'=>NULL,'last_time'=>NULL,'avatar'=>NULL,'is_login'=>'0','last_login_ip'=>NULL]);
        
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

