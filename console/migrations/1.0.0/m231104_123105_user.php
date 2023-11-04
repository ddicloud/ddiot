<?php

use yii\db\Migration;

class m231104_123105_user extends Migration
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
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC");
        
        /* 索引设置 */
        $this->createIndex('username','{{%user}}','username',1);
        $this->createIndex('email','{{%user}}','email',1);
        $this->createIndex('password_reset_token','{{%user}}','password_reset_token',1);
        $this->createIndex('UNIQUE_OPEN_ID','{{%user}}','open_id',1);
        $this->createIndex('UNIQUE_UNION_ID','{{%user}}','union_id',1);
        
        
        /* 表数据 */
        $this->insert('{{%user}}',['id'=>'11','mobile'=>'17778984690','company'=>'','username'=>'admin','auth_key'=>'Uh6zuaQpwYrxw5ttOQGYx4Rkaw09Khzy','password_hash'=>'$2y$13$MC8zmn5nzYuphsAtaiRQ8.ivPGnVA3AIs/8Xx6BDhCk7.aKhpgvbm','password_reset_token'=>'TN7YEvXT-AvqMXxvwi5mt6LWAsS-jA3P_1698840383','email'=>'admin@163.com','parent_bloc_id'=>'0','store_id'=>'153','bloc_id'=>'91','status'=>'1','created_at'=>'1586678074','updated_at'=>'1698738401','verification_token'=>'au60OEDI1aeqdg9EU22cNKY_3wAsmbfh_1672987875','last_time'=>'1698840383','avatar'=>'202307/14/17b0f756-8d61-32d1-a153-4183fa00825b.png','is_login'=>'0','last_login_ip'=>'222.91.196.89','open_id'=>NULL,'union_id'=>NULL]);
        
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

