<?php

use yii\db\Migration;

class m221102_024927_user extends Migration
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
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");
        
        /* 索引设置 */
        $this->createIndex('username','{{%user}}','username',1);
        $this->createIndex('email','{{%user}}','email',1);
        $this->createIndex('password_reset_token','{{%user}}','password_reset_token',1);
        $this->createIndex('UNIQUE_OPEN_ID','{{%user}}','open_id',1);
        $this->createIndex('UNIQUE_UNION_ID','{{%user}}','union_id',1);
        
        
        /* 表数据 */
        $this->insert('{{%user}}',['id'=>'11','mobile'=>'17778984690','company'=>'','username'=>'admin','auth_key'=>'o0bNkEsGthkzLeqYqRRzmLiVYHKL3MOH','password_hash'=>'$2y$13$2GJXGIXzudNE5/sYh6BQmO2QcLGUN4BtmQtyTcNxQ66Ab.qRiC6zO','password_reset_token'=>'OcN95mcKicS3PYp-wo3QdKO1OlgOBz9u_1667214083','email'=>'admin@163.com','parent_bloc_id'=>NULL,'store_id'=>'132','bloc_id'=>'0','status'=>'1','created_at'=>'1586678074','updated_at'=>'1667211811','verification_token'=>'KBCXSjhOTtp_uU-W9HevXSjbTr1EfzU9_1658484008','last_time'=>'1667214083','avatar'=>'202208/29/a3edc707-bd1c-378f-bf54-cf03252cda44.png','is_login'=>'1','last_login_ip'=>'127.0.0.1','open_id'=>NULL,'union_id'=>NULL]);
        
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

