<?php

use yii\db\Migration;

class m220628_105254_user extends Migration
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
        $this->insert('{{%user}}',['id'=>'1','mobile'=>'17778984690','company'=>NULL,'username'=>'admin','auth_key'=>'k3GuOmTY767KobQloHgOCPIfPMxMPJEE','password_hash'=>'$2y$13$bQ5eb54tqxyi.TIOGeFBAujcvogn5rzCeOLeAUHUQPiYEybnpvmRi','password_reset_token'=>'Lo_Zo-PYQzab9HdWL_iGtykknH1Jswqm_1656410300','email'=>'2192138785@qq.com','store_id'=>'0','bloc_id'=>'0','status'=>'1','created_at'=>'1656410214','updated_at'=>'1656410214','verification_token'=>'vPo0RotjijSfZIL-DUCCRuRkaN5Psvj2_1656410214','last_time'=>'1656410300','avatar'=>NULL,'is_login'=>'1','last_login_ip'=>'222.90.31.255']);
        
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

