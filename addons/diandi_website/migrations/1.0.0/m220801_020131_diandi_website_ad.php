<?php

use yii\db\Migration;

class m220801_020131_diandi_website_ad extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_website_ad}}', [
            'id' => "int(10) unsigned NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'title' => "varchar(50) NOT NULL DEFAULT ''",
            'type' => "tinyint(4) NULL DEFAULT '101' COMMENT '1 轮播图 2 友情链接'",
            'category_id' => "int(11) NULL DEFAULT '0'",
            'image' => "varchar(255) NOT NULL DEFAULT ''",
            'link' => "varchar(255) NOT NULL DEFAULT ''",
            'created_at' => "int(11) NOT NULL DEFAULT '0'",
            'updated_at' => "int(11) NOT NULL DEFAULT '0'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8");
        
        /* 索引设置 */
        $this->createIndex('i-type-category','{{%diandi_website_ad}}','type, category_id',0);
        
        
        /* 表数据 */
        $this->insert('{{%diandi_website_ad}}',['id'=>'1','store_id'=>NULL,'bloc_id'=>NULL,'title'=>'百度','type'=>'101','category_id'=>'0','image'=>'/uploads/ad-img/img_58500a3e1b241.jpg','link'=>'http://www.baidu.com','created_at'=>'1481640510','updated_at'=>'1481640673']);
        $this->insert('{{%diandi_website_ad}}',['id'=>'2','store_id'=>NULL,'bloc_id'=>NULL,'title'=>'腾讯','type'=>'101','category_id'=>'0','image'=>'/uploads/ad-img/img_58500a67014d3.jpg','link'=>'http://www.qq.com','created_at'=>'1481640551','updated_at'=>'1481640751']);
        $this->insert('{{%diandi_website_ad}}',['id'=>'3','store_id'=>NULL,'bloc_id'=>NULL,'title'=>'网易','type'=>'101','category_id'=>'0','image'=>'/uploads/ad-img/img_58500a8b4fb51.png','link'=>'http://www.163.com','created_at'=>'1481640587','updated_at'=>'1481640587']);
        $this->insert('{{%diandi_website_ad}}',['id'=>'4','store_id'=>NULL,'bloc_id'=>NULL,'title'=>'去哪网','type'=>'102','category_id'=>'0','image'=>'','link'=>'http://www.quna.com','created_at'=>'0','updated_at'=>'0']);
        $this->insert('{{%diandi_website_ad}}',['id'=>'5','store_id'=>NULL,'bloc_id'=>NULL,'title'=>'携程','type'=>'102','category_id'=>'0','image'=>'','link'=>'','created_at'=>'0','updated_at'=>'0']);
        $this->insert('{{%diandi_website_ad}}',['id'=>'6','store_id'=>NULL,'bloc_id'=>NULL,'title'=>'马蜂窝','type'=>'102','category_id'=>'0','image'=>'','link'=>'','created_at'=>'0','updated_at'=>'0']);
        $this->insert('{{%diandi_website_ad}}',['id'=>'7','store_id'=>NULL,'bloc_id'=>NULL,'title'=>'面包旅行','type'=>'102','category_id'=>'0','image'=>'','link'=>'','created_at'=>'0','updated_at'=>'0']);
        $this->insert('{{%diandi_website_ad}}',['id'=>'8','store_id'=>NULL,'bloc_id'=>NULL,'title'=>'这个标题','type'=>'1','category_id'=>'0','image'=>'https://dev.hopesfire.com/attachment/202109/22/5cffe6f2-cc62-3a7a-8114-5d23431a4e66.jpg','link'=>'www','created_at'=>'0','updated_at'=>'0']);
        $this->insert('{{%diandi_website_ad}}',['id'=>'9','store_id'=>'59','bloc_id'=>'8','title'=>'好的','type'=>'1','category_id'=>'0','image'=>'https://dev.hopesfire.com/attachment/202109/22/bf68f21b-06bd-3a50-ab82-38c6421ade7b.png','link'=>'www','created_at'=>'1632309496','updated_at'=>'1632309496']);
        $this->insert('{{%diandi_website_ad}}',['id'=>'10','store_id'=>'57','bloc_id'=>'8','title'=>'12','type'=>'101','category_id'=>'0','image'=>'https://dev.hopesfire.com/attachment/202109/22/73433b92-86f4-3ed9-bcbf-6d629660ec39.png','link'=>'','created_at'=>'1632310133','updated_at'=>'1632310153']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_website_ad}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

