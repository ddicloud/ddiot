<?php

use yii\db\Migration;

class m220801_020131_diandi_website_category extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_website_category}}', [
            'id' => "int(10) unsigned NOT NULL AUTO_INCREMENT",
            'name' => "varchar(50) NOT NULL DEFAULT '' COMMENT '分类名'",
            'pid' => "int(11) NOT NULL DEFAULT '0' COMMENT '父id'",
            'path' => "varchar(50) NOT NULL DEFAULT '0' COMMENT '完整的父id 用/分开'",
            'type' => "tinyint(4) NOT NULL COMMENT '1.news 2 products 3 download 4 photo'",
            'image' => "varchar(255) NOT NULL DEFAULT ''",
            'description' => "varchar(255) NOT NULL DEFAULT ''",
            'keywords' => "varchar(255) NOT NULL DEFAULT ''",
            'created_at' => "int(11) NOT NULL",
            'updated_at' => "int(11) NOT NULL",
            'language' => "varchar(20) NOT NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8");
        
        /* 索引设置 */
        $this->createIndex('i-type-pid','{{%diandi_website_category}}','type, pid',0);
        $this->createIndex('i-language','{{%diandi_website_category}}','language',0);
        
        
        /* 表数据 */
        $this->insert('{{%diandi_website_category}}',['id'=>'1','name'=>'游学研学','pid'=>'0','path'=>'','type'=>'2','image'=>'','description'=>'','keywords'=>'','created_at'=>'1481360463','updated_at'=>'1490457550','language'=>'']);
        $this->insert('{{%diandi_website_category}}',['id'=>'2','name'=>'默认分类','pid'=>'0','path'=>'','type'=>'1','image'=>'/uploads/products-img/img_58f32726aa3df.png','description'=>'测试','keywords'=>'测试，测试测试','created_at'=>'1481367786','updated_at'=>'1492330278','language'=>'']);
        $this->insert('{{%diandi_website_category}}',['id'=>'3','name'=>'新闻分类2','pid'=>'2','path'=>'2','type'=>'1','image'=>'','description'=>'','keywords'=>'','created_at'=>'1481372394','updated_at'=>'1499598678','language'=>'']);
        $this->insert('{{%diandi_website_category}}',['id'=>'4','name'=>'旅行度假','pid'=>'0','path'=>'','type'=>'2','image'=>'','description'=>'','keywords'=>'','created_at'=>'1481609361','updated_at'=>'1490457573','language'=>'']);
        $this->insert('{{%diandi_website_category}}',['id'=>'5','name'=>'下载文档','pid'=>'0','path'=>'','type'=>'3','image'=>'','description'=>'','keywords'=>'','created_at'=>'1482155225','updated_at'=>'1482155225','language'=>'']);
        $this->insert('{{%diandi_website_category}}',['id'=>'6','name'=>'企业环境','pid'=>'0','path'=>'','type'=>'4','image'=>'','description'=>'','keywords'=>'','created_at'=>'1482559711','updated_at'=>'1482559711','language'=>'']);
        $this->insert('{{%diandi_website_category}}',['id'=>'7','name'=>'商务考察','pid'=>'0','path'=>'','type'=>'2','image'=>'','description'=>'','keywords'=>'','created_at'=>'1490457590','updated_at'=>'1490457590','language'=>'']);
        $this->insert('{{%diandi_website_category}}',['id'=>'8','name'=>'测试修改path','pid'=>'0','path'=>'','type'=>'1','image'=>'','description'=>'','keywords'=>'','created_at'=>'1498831600','updated_at'=>'1498833499','language'=>'']);
        $this->insert('{{%diandi_website_category}}',['id'=>'9','name'=>'测试修改path2','pid'=>'3','path'=>'','type'=>'1','image'=>'','description'=>'','keywords'=>'','created_at'=>'1498832464','updated_at'=>'1499598673','language'=>'']);
        $this->insert('{{%diandi_website_category}}',['id'=>'10','name'=>'修改path3','pid'=>'9','path'=>'9','type'=>'1','image'=>'','description'=>'','keywords'=>'','created_at'=>'1498832583','updated_at'=>'1499598673','language'=>'']);
        $this->insert('{{%diandi_website_category}}',['id'=>'11','name'=>'書籍','pid'=>'0','path'=>'','type'=>'2','image'=>'','description'=>'','keywords'=>'','created_at'=>'1586001312','updated_at'=>'1586001312','language'=>'zh-CN']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_website_category}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

