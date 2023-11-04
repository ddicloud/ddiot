<?php

use yii\db\Migration;

class m231104_123104_bea_cloud_feedback extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%bea_cloud_feedback}}', [
            'id' => "int(10) unsigned NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'member_id' => "int(11) NULL",
            'feed_store_id' => "int(11) NULL",
            'subject' => "varchar(125) NOT NULL DEFAULT ''",
            'status' => "int(11) NULL DEFAULT '0'",
            'name' => "varchar(100) NOT NULL DEFAULT ''",
            'phone' => "varchar(50) NOT NULL DEFAULT ''",
            'email' => "varchar(50) NOT NULL DEFAULT ''",
            'body' => "varchar(255) NOT NULL DEFAULT ''",
            'create_time' => "datetime NULL",
            'update_time' => "datetime NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%bea_cloud_feedback}}',['id'=>'38','store_id'=>'149','bloc_id'=>'51','member_id'=>'108','feed_store_id'=>NULL,'subject'=>'','status'=>'0','name'=>'','phone'=>'','email'=>'','body'=>'1','create_time'=>'2023-03-18 15:20:36','update_time'=>'2023-03-18 15:40:51']);
        $this->insert('{{%bea_cloud_feedback}}',['id'=>'39','store_id'=>'149','bloc_id'=>'51','member_id'=>'108','feed_store_id'=>NULL,'subject'=>'','status'=>'0','name'=>'','phone'=>'','email'=>'','body'=>'服务不行','create_time'=>'2023-03-18 15:41:19','update_time'=>'2023-03-18 15:41:19']);
        $this->insert('{{%bea_cloud_feedback}}',['id'=>'40','store_id'=>'149','bloc_id'=>'51','member_id'=>'108','feed_store_id'=>NULL,'subject'=>'','status'=>'0','name'=>'','phone'=>'','email'=>'','body'=>'不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行','create_time'=>'2023-03-18 15:44:17','update_time'=>'2023-03-18 15:44:17']);
        $this->insert('{{%bea_cloud_feedback}}',['id'=>'41','store_id'=>'149','bloc_id'=>'51','member_id'=>'108','feed_store_id'=>NULL,'subject'=>'','status'=>'0','name'=>'','phone'=>'','email'=>'','body'=>'不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行不行','create_time'=>'2023-03-18 15:44:29','update_time'=>'2023-03-18 15:44:29']);
        $this->insert('{{%bea_cloud_feedback}}',['id'=>'42','store_id'=>'149','bloc_id'=>'51','member_id'=>'125','feed_store_id'=>NULL,'subject'=>'','status'=>'0','name'=>'','phone'=>'','email'=>'','body'=>'','create_time'=>'2023-03-20 14:25:28','update_time'=>'2023-03-20 14:25:28']);
        $this->insert('{{%bea_cloud_feedback}}',['id'=>'43','store_id'=>'138','bloc_id'=>'38','member_id'=>'127','feed_store_id'=>NULL,'subject'=>'','status'=>'0','name'=>'','phone'=>'','email'=>'','body'=>'','create_time'=>'2023-03-22 16:03:38','update_time'=>'2023-03-22 16:03:38']);
        $this->insert('{{%bea_cloud_feedback}}',['id'=>'44','store_id'=>'138','bloc_id'=>'38','member_id'=>'129','feed_store_id'=>NULL,'subject'=>'','status'=>'0','name'=>'','phone'=>'','email'=>'','body'=>'','create_time'=>'2023-03-23 10:49:35','update_time'=>'2023-03-23 10:49:35']);
        $this->insert('{{%bea_cloud_feedback}}',['id'=>'45','store_id'=>'138','bloc_id'=>'38','member_id'=>'131','feed_store_id'=>NULL,'subject'=>'','status'=>'0','name'=>'','phone'=>'','email'=>'','body'=>'','create_time'=>'2023-03-23 22:20:45','update_time'=>'2023-03-23 22:20:45']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%bea_cloud_feedback}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

