<?php

use yii\db\Migration;

class m231118_154944_diandi_website_article_category extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_website_article_category}}', [
            'id' => "int(10) unsigned NOT NULL AUTO_INCREMENT",
            'bloc_id' => "int(11) NULL",
            'store_id' => "int(11) NULL",
            'title' => "varchar(30) NOT NULL",
            'displayorder' => "tinyint(3) unsigned NOT NULL",
            'pcate' => "int(11) NULL DEFAULT '0'",
            'type' => "varchar(15) NOT NULL",
            'thumb' => "varchar(255) NULL",
            'create_time' => "int(11) NULL",
            'update_time' => "int(11) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='文章分类'");
        
        /* 索引设置 */
        $this->createIndex('type','{{%diandi_website_article_category}}','type',0);
        
        
        /* 表数据 */
        $this->insert('{{%diandi_website_article_category}}',['id'=>'38','bloc_id'=>'8','store_id'=>'61','title'=>'行业新闻','displayorder'=>'6','pcate'=>'0','type'=>'xzwm','thumb'=>'202208/02/8f5192f3-e3f1-30dc-ae81-9fb44cfd1596.png','create_time'=>'1657527493','update_time'=>'1659422912']);
        $this->insert('{{%diandi_website_article_category}}',['id'=>'37','bloc_id'=>'8','store_id'=>'61','title'=>'运营知识','displayorder'=>'5','pcate'=>'0','type'=>'xwzx','thumb'=>'202208/02/44d8a908-a0bd-3bbe-a54e-67d671c086d0.png','create_time'=>'1657519479','update_time'=>'1659422918']);
        $this->insert('{{%diandi_website_article_category}}',['id'=>'35','bloc_id'=>'8','store_id'=>'61','title'=>'官方动态','displayorder'=>'1','pcate'=>'0','type'=>'gsjj','thumb'=>'202208/02/c1dea801-8459-3fd2-8eee-11d0a73cb735.png','create_time'=>'1657507319','update_time'=>'1659422923']);
        $this->insert('{{%diandi_website_article_category}}',['id'=>'31','bloc_id'=>'8','store_id'=>'61','title'=>'硬件研发','displayorder'=>'1','pcate'=>'0','type'=>'xwzx','thumb'=>'202208/02/ec32755a-1593-3d02-b58e-e62e2caf89e1.png','create_time'=>'1656059952','update_time'=>'1659422928']);
        $this->insert('{{%diandi_website_article_category}}',['id'=>'33','bloc_id'=>'8','store_id'=>'61','title'=>'战略合作','displayorder'=>'3','pcate'=>'0','type'=>'gngx','thumb'=>'202208/02/fc094532-1a9c-3261-b768-26d050b38114.png','create_time'=>'1656061200','update_time'=>'1659422933']);
        $this->insert('{{%diandi_website_article_category}}',['id'=>'32','bloc_id'=>'8','store_id'=>'61','title'=>'开发者资源','displayorder'=>'2','pcate'=>'0','type'=>'hydt','thumb'=>'202208/02/92256eaa-3505-305a-bf12-4a3b7a503067.png','create_time'=>'1656060499','update_time'=>'1659422939']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_website_article_category}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

