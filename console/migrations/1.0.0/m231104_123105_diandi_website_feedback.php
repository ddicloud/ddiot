<?php

use yii\db\Migration;

class m231104_123105_diandi_website_feedback extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_website_feedback}}', [
            'id' => "int(10) unsigned NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'feed_store_id' => "int(11) NULL",
            'subject' => "varchar(125) NOT NULL DEFAULT ''",
            'name' => "varchar(100) NOT NULL DEFAULT ''",
            'phone' => "varchar(50) NOT NULL DEFAULT ''",
            'email' => "varchar(50) NOT NULL DEFAULT ''",
            'body' => "varchar(255) NOT NULL DEFAULT ''",
            'created_at' => "int(11) NOT NULL DEFAULT '0'",
            'updated_at' => "int(11) NOT NULL DEFAULT '0'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_website_feedback}}',['id'=>'1','store_id'=>NULL,'bloc_id'=>NULL,'feed_store_id'=>NULL,'subject'=>'测试测试','name'=>'李先生','phone'=>'13240702278','email'=>'739800600@qq.com','body'=>'你好你好你好','created_at'=>'1481433870','updated_at'=>'1481433870']);
        $this->insert('{{%diandi_website_feedback}}',['id'=>'2','store_id'=>NULL,'bloc_id'=>NULL,'feed_store_id'=>NULL,'subject'=>'你好','name'=>'你好','phone'=>'','email'=>'739800600@qq.com','body'=>'你好，你好','created_at'=>'1481434463','updated_at'=>'1481434463']);
        $this->insert('{{%diandi_website_feedback}}',['id'=>'3','store_id'=>NULL,'bloc_id'=>NULL,'feed_store_id'=>NULL,'subject'=>'sddfsfsfds','name'=>'dsfsdfsdds','phone'=>'','email'=>'739800600@qq.com','body'=>'sdfdsfds','created_at'=>'1501242456','updated_at'=>'1501242456']);
        $this->insert('{{%diandi_website_feedback}}',['id'=>'4','store_id'=>NULL,'bloc_id'=>NULL,'feed_store_id'=>NULL,'subject'=>'ddddddd','name'=>'ddddd','phone'=>'','email'=>'739800600@qq.com','body'=>'dsfsdfds','created_at'=>'1501242645','updated_at'=>'1501242645']);
        $this->insert('{{%diandi_website_feedback}}',['id'=>'5','store_id'=>NULL,'bloc_id'=>NULL,'feed_store_id'=>NULL,'subject'=>'dsfsdfdsfsd','name'=>'dddd','phone'=>'','email'=>'739800600@qq.com','body'=>'dsfsdfdsfds','created_at'=>'1501397774','updated_at'=>'1501397774']);
        $this->insert('{{%diandi_website_feedback}}',['id'=>'6','store_id'=>'138','bloc_id'=>'38','feed_store_id'=>NULL,'subject'=>'','name'=>'','phone'=>'','email'=>'','body'=>'1,2,3','created_at'=>'0','updated_at'=>'0']);
        $this->insert('{{%diandi_website_feedback}}',['id'=>'7','store_id'=>'138','bloc_id'=>'38','feed_store_id'=>NULL,'subject'=>'','name'=>'','phone'=>'','email'=>'','body'=>'123111111111111111111','created_at'=>'0','updated_at'=>'0']);
        $this->insert('{{%diandi_website_feedback}}',['id'=>'8','store_id'=>'138','bloc_id'=>'38','feed_store_id'=>NULL,'subject'=>'','name'=>'','phone'=>'','email'=>'','body'=>'6666666666666666666','created_at'=>'0','updated_at'=>'0']);
        $this->insert('{{%diandi_website_feedback}}',['id'=>'9','store_id'=>'138','bloc_id'=>'38','feed_store_id'=>NULL,'subject'=>'','name'=>'','phone'=>'','email'=>'','body'=>'','created_at'=>'0','updated_at'=>'0']);
        $this->insert('{{%diandi_website_feedback}}',['id'=>'10','store_id'=>'138','bloc_id'=>'38','feed_store_id'=>NULL,'subject'=>'','name'=>'','phone'=>'','email'=>'','body'=>'','created_at'=>'0','updated_at'=>'0']);
        $this->insert('{{%diandi_website_feedback}}',['id'=>'11','store_id'=>'138','bloc_id'=>'38','feed_store_id'=>NULL,'subject'=>'','name'=>'','phone'=>'','email'=>'','body'=>'123123123','created_at'=>'0','updated_at'=>'0']);
        $this->insert('{{%diandi_website_feedback}}',['id'=>'12','store_id'=>'138','bloc_id'=>'38','feed_store_id'=>NULL,'subject'=>'','name'=>'','phone'=>'','email'=>'','body'=>'','created_at'=>'0','updated_at'=>'0']);
        $this->insert('{{%diandi_website_feedback}}',['id'=>'13','store_id'=>'140','bloc_id'=>'38','feed_store_id'=>NULL,'subject'=>'','name'=>'','phone'=>'','email'=>'','body'=>'123123213','created_at'=>'0','updated_at'=>'0']);
        $this->insert('{{%diandi_website_feedback}}',['id'=>'14','store_id'=>'140','bloc_id'=>'38','feed_store_id'=>NULL,'subject'=>'','name'=>'','phone'=>'','email'=>'','body'=>'123','created_at'=>'0','updated_at'=>'0']);
        $this->insert('{{%diandi_website_feedback}}',['id'=>'15','store_id'=>'140','bloc_id'=>'38','feed_store_id'=>NULL,'subject'=>'','name'=>'','phone'=>'','email'=>'','body'=>'123','created_at'=>'0','updated_at'=>'0']);
        $this->insert('{{%diandi_website_feedback}}',['id'=>'16','store_id'=>'140','bloc_id'=>'38','feed_store_id'=>NULL,'subject'=>'','name'=>'','phone'=>'','email'=>'','body'=>'test','created_at'=>'0','updated_at'=>'0']);
        $this->insert('{{%diandi_website_feedback}}',['id'=>'17','store_id'=>'140','bloc_id'=>'38','feed_store_id'=>NULL,'subject'=>'','name'=>'','phone'=>'','email'=>'','body'=>'test','created_at'=>'0','updated_at'=>'0']);
        $this->insert('{{%diandi_website_feedback}}',['id'=>'18','store_id'=>'140','bloc_id'=>'38','feed_store_id'=>NULL,'subject'=>'','name'=>'','phone'=>'','email'=>'','body'=>'test','created_at'=>'0','updated_at'=>'0']);
        $this->insert('{{%diandi_website_feedback}}',['id'=>'19','store_id'=>'140','bloc_id'=>'38','feed_store_id'=>NULL,'subject'=>'','name'=>'','phone'=>'','email'=>'','body'=>'test','created_at'=>'0','updated_at'=>'0']);
        $this->insert('{{%diandi_website_feedback}}',['id'=>'20','store_id'=>'138','bloc_id'=>'38','feed_store_id'=>NULL,'subject'=>'','name'=>'','phone'=>'','email'=>'','body'=>'','created_at'=>'0','updated_at'=>'0']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_website_feedback}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

