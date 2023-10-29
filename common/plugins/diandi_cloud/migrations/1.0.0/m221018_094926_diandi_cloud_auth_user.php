<?php

use yii\db\Migration;

class m221018_094926_diandi_cloud_auth_user extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_cloud_auth_user}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'member_id' => "int(11) NULL COMMENT '会员ID'",
            'email' => "varchar(255) NULL COMMENT '邮箱'",
            'mobile' => "varchar(255) NULL COMMENT '手机号'",
            'username' => "varchar(50) NULL COMMENT '真实姓名'",
            'web_key' => "varchar(100) NOT NULL COMMENT '系统秘钥'",
            'status' => "tinyint(2) NOT NULL DEFAULT '1' COMMENT '用户状态'",
            'create_time' => "int(11) NULL",
            'update_time' => "int(11) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
        
        /* 索引设置 */
        $this->createIndex('UNIQUE_WEB_KEY','{{%diandi_cloud_auth_user}}','web_key',1);
        $this->createIndex('UNIQUE_MEMBER_ID','{{%diandi_cloud_auth_user}}','member_id',1);
        
        
        /* 表数据 */
        $this->insert('{{%diandi_cloud_auth_user}}',['id'=>'1','member_id'=>'1','email'=>'asda','mobile'=>'asd','username'=>'asd','web_key'=>'162cb989f12671','status'=>'1','create_time'=>'1657510047','update_time'=>'1657510942']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_cloud_auth_user}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

