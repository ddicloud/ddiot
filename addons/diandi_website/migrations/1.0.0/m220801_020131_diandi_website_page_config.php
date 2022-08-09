<?php

use yii\db\Migration;

class m220801_020131_diandi_website_page_config extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_website_page_config}}', [
            'id' => "int(10) unsigned NOT NULL AUTO_INCREMENT",
            'bloc_id' => "int(11) NULL",
            'store_id' => "int(11) NULL",
            'title' => "varchar(30) NOT NULL",
            'template' => "varchar(50) NULL DEFAULT '0'",
            'type' => "varchar(15) NOT NULL",
            'create_time' => "int(11) NULL",
            'update_time' => "int(11) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='文章分类'");
        
        /* 索引设置 */
        $this->createIndex('type','{{%diandi_website_page_config}}','type',0);
        
        
        /* 表数据 */
        $this->insert('{{%diandi_website_page_config}}',['id'=>'37','bloc_id'=>'31','store_id'=>'80','title'=>'首页','template'=>'0','type'=>'首页','create_time'=>'1651718185','update_time'=>'1651718185']);
        $this->insert('{{%diandi_website_page_config}}',['id'=>'38','bloc_id'=>'8','store_id'=>'61','title'=>'pc首页','template'=>'1','type'=>'12','create_time'=>'1654571170','update_time'=>'1657770619']);
        $this->insert('{{%diandi_website_page_config}}',['id'=>'39','bloc_id'=>'8','store_id'=>'61','title'=>'小程序首页','template'=>'小程序首页','type'=>'小程序首页','create_time'=>'1657770541','update_time'=>'1657770541']);
        $this->insert('{{%diandi_website_page_config}}',['id'=>'35','bloc_id'=>'33','store_id'=>'82','title'=>'认养','template'=>'','type'=>'认养','create_time'=>'1650521345','update_time'=>'1650521345']);
        $this->insert('{{%diandi_website_page_config}}',['id'=>'33','bloc_id'=>'33','store_id'=>'82','title'=>'最新资讯','template'=>'0','type'=>'最新资讯','create_time'=>'1650513657','update_time'=>'1650513657']);
        $this->insert('{{%diandi_website_page_config}}',['id'=>'32','bloc_id'=>'33','store_id'=>'82','title'=>'农场介绍','template'=>'0','type'=>'农场介绍','create_time'=>'1650513525','update_time'=>'1650513525']);
        $this->insert('{{%diandi_website_page_config}}',['id'=>'30','bloc_id'=>'33','store_id'=>'82','title'=>'农业政策','template'=>'0','type'=>'农业政策','create_time'=>'1650513066','update_time'=>'1650513066']);
        $this->insert('{{%diandi_website_page_config}}',['id'=>'31','bloc_id'=>'33','store_id'=>'82','title'=>'农场监控','template'=>'0','type'=>'农场监控','create_time'=>'1650513351','update_time'=>'1650513351']);
        $this->insert('{{%diandi_website_page_config}}',['id'=>'28','bloc_id'=>'30','store_id'=>'79','title'=>'首页','template'=>'','type'=>'首页','create_time'=>'1650455577','update_time'=>'1650455577']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_website_page_config}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

