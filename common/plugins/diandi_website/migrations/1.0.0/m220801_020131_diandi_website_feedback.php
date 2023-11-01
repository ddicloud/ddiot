<?php

use yii\db\Migration;

class m220801_020131_diandi_website_feedback extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_website_feedback}}', [
            'id' => "int(10) unsigned NOT NULL AUTO_INCREMENT",
            'subject' => "varchar(125) NOT NULL DEFAULT ''",
            'name' => "varchar(100) NOT NULL DEFAULT ''",
            'phone' => "varchar(50) NOT NULL DEFAULT ''",
            'email' => "varchar(50) NOT NULL DEFAULT ''",
            'body' => "varchar(255) NOT NULL DEFAULT ''",
            'created_at' => "int(11) NOT NULL DEFAULT '0'",
            'updated_at' => "int(11) NOT NULL DEFAULT '0'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_website_feedback}}',['id'=>'1','subject'=>'测试测试','name'=>'李先生','phone'=>'13240702278','email'=>'739800600@qq.com','body'=>'你好你好你好','created_at'=>'1481433870','updated_at'=>'1481433870']);
        $this->insert('{{%diandi_website_feedback}}',['id'=>'2','subject'=>'你好','name'=>'你好','phone'=>'','email'=>'739800600@qq.com','body'=>'你好，你好','created_at'=>'1481434463','updated_at'=>'1481434463']);
        $this->insert('{{%diandi_website_feedback}}',['id'=>'3','subject'=>'sddfsfsfds','name'=>'dsfsdfsdds','phone'=>'','email'=>'739800600@qq.com','body'=>'sdfdsfds','created_at'=>'1501242456','updated_at'=>'1501242456']);
        $this->insert('{{%diandi_website_feedback}}',['id'=>'4','subject'=>'ddddddd','name'=>'ddddd','phone'=>'','email'=>'739800600@qq.com','body'=>'dsfsdfds','created_at'=>'1501242645','updated_at'=>'1501242645']);
        $this->insert('{{%diandi_website_feedback}}',['id'=>'5','subject'=>'dsfsdfdsfsd','name'=>'dddd','phone'=>'','email'=>'739800600@qq.com','body'=>'dsfsdfdsfds','created_at'=>'1501397774','updated_at'=>'1501397774']);
        
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

