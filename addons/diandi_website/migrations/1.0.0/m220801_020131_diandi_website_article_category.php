<?php

use yii\db\Migration;

class m220801_020131_diandi_website_article_category extends Migration
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
            'create_time' => "int(11) NULL",
            'update_time' => "int(11) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='文章分类'");
        
        /* 索引设置 */
        $this->createIndex('type','{{%diandi_website_article_category}}','type',0);
        
        
        /* 表数据 */
        $this->insert('{{%diandi_website_article_category}}',['id'=>'27','bloc_id'=>'33','store_id'=>'82','title'=>'今日公告','displayorder'=>'4','pcate'=>'0','type'=>'jrgg','create_time'=>'1650448060','update_time'=>'1650448060']);
        $this->insert('{{%diandi_website_article_category}}',['id'=>'26','bloc_id'=>'33','store_id'=>'82','title'=>'最新资讯','displayorder'=>'3','pcate'=>'0','type'=>'zxzx','create_time'=>'1650446622','update_time'=>'1650446622']);
        $this->insert('{{%diandi_website_article_category}}',['id'=>'25','bloc_id'=>'33','store_id'=>'82','title'=>'农场介绍','displayorder'=>'2','pcate'=>'0','type'=>'ncjs','create_time'=>'1650446315','update_time'=>'1650446315']);
        $this->insert('{{%diandi_website_article_category}}',['id'=>'24','bloc_id'=>'33','store_id'=>'82','title'=>'农业政策','displayorder'=>'1','pcate'=>'0','type'=>'nyzc','create_time'=>'1650445255','update_time'=>'1650445255']);
        $this->insert('{{%diandi_website_article_category}}',['id'=>'15','bloc_id'=>'27','store_id'=>'75','title'=>'客户案例','displayorder'=>'0','pcate'=>'0','type'=>'khal','create_time'=>'1632382835','update_time'=>'1632382835']);
        $this->insert('{{%diandi_website_article_category}}',['id'=>'16','bloc_id'=>'27','store_id'=>'75','title'=>'新闻资讯','displayorder'=>'1','pcate'=>'0','type'=>'xwzx','create_time'=>'1632383039','update_time'=>'1632383039']);
        $this->insert('{{%diandi_website_article_category}}',['id'=>'17','bloc_id'=>'27','store_id'=>'75','title'=>'项目案例','displayorder'=>'1','pcate'=>'0','type'=>'xmal','create_time'=>'1632383109','update_time'=>'1632383109']);
        $this->insert('{{%diandi_website_article_category}}',['id'=>'18','bloc_id'=>'27','store_id'=>'75','title'=>'技术支持','displayorder'=>'1','pcate'=>'0','type'=>'jszc','create_time'=>'1632383124','update_time'=>'1632383124']);
        $this->insert('{{%diandi_website_article_category}}',['id'=>'19','bloc_id'=>'27','store_id'=>'75','title'=>'荣誉资质','displayorder'=>'1','pcate'=>'0','type'=>'ryzz','create_time'=>'1632383148','update_time'=>'1632383148']);
        $this->insert('{{%diandi_website_article_category}}',['id'=>'20','bloc_id'=>'27','store_id'=>'75','title'=>'合作伙伴','displayorder'=>'1','pcate'=>'0','type'=>'hzhb','create_time'=>'1632383166','update_time'=>'1632383166']);
        $this->insert('{{%diandi_website_article_category}}',['id'=>'21','bloc_id'=>'27','store_id'=>'75','title'=>'全部产品','displayorder'=>'1','pcate'=>'0','type'=>'product','create_time'=>'1632383267','update_time'=>'1632383267']);
        $this->insert('{{%diandi_website_article_category}}',['id'=>'22','bloc_id'=>'27','store_id'=>'75','title'=>'产品分类1','displayorder'=>'1','pcate'=>'21','type'=>'product-cate1','create_time'=>'1632383296','update_time'=>'1632383296']);
        $this->insert('{{%diandi_website_article_category}}',['id'=>'23','bloc_id'=>'27','store_id'=>'75','title'=>'产品分类2','displayorder'=>'1','pcate'=>'21','type'=>'product-cate2','create_time'=>'1632383312','update_time'=>'1632383312']);
        $this->insert('{{%diandi_website_article_category}}',['id'=>'28','bloc_id'=>'31','store_id'=>'80','title'=>'平台公告','displayorder'=>'1','pcate'=>'0','type'=>'ptgg','create_time'=>'1651720175','update_time'=>'1651720175']);
        $this->insert('{{%diandi_website_article_category}}',['id'=>'29','bloc_id'=>'31','store_id'=>'80','title'=>'订购指南','displayorder'=>'2','pcate'=>'0','type'=>'dgzn','create_time'=>'1651723055','update_time'=>'1651723055']);
        $this->insert('{{%diandi_website_article_category}}',['id'=>'30','bloc_id'=>'31','store_id'=>'80','title'=>'售后须知','displayorder'=>'3','pcate'=>'0','type'=>'shxz','create_time'=>'1651723234','update_time'=>'1651723234']);
        $this->insert('{{%diandi_website_article_category}}',['id'=>'31','bloc_id'=>'8','store_id'=>'61','title'=>'新闻中心','displayorder'=>'1','pcate'=>'0','type'=>'xwzx','create_time'=>'1656059952','update_time'=>'1656059982']);
        $this->insert('{{%diandi_website_article_category}}',['id'=>'32','bloc_id'=>'8','store_id'=>'61','title'=>'行业动态','displayorder'=>'2','pcate'=>'0','type'=>'hydt','create_time'=>'1656060499','update_time'=>'1656061584']);
        $this->insert('{{%diandi_website_article_category}}',['id'=>'33','bloc_id'=>'8','store_id'=>'61','title'=>'功能更新1','displayorder'=>'3','pcate'=>'0','type'=>'gngx','create_time'=>'1656061200','update_time'=>'1656061733']);
        $this->insert('{{%diandi_website_article_category}}',['id'=>'34','bloc_id'=>'31','store_id'=>'80','title'=>'本期活动','displayorder'=>'1','pcate'=>'0','type'=>'bqhd','create_time'=>'1656931426','update_time'=>'1656931426']);
        $this->insert('{{%diandi_website_article_category}}',['id'=>'35','bloc_id'=>'8','store_id'=>'61','title'=>'官网简介','displayorder'=>'1','pcate'=>'0','type'=>'gsjj','create_time'=>'1657507319','update_time'=>'1657519526']);
        $this->insert('{{%diandi_website_article_category}}',['id'=>'37','bloc_id'=>'8','store_id'=>'61','title'=>'新闻资讯','displayorder'=>'5','pcate'=>'0','type'=>'xwzx','create_time'=>'1657519479','update_time'=>'1657519479']);
        $this->insert('{{%diandi_website_article_category}}',['id'=>'38','bloc_id'=>'8','store_id'=>'61','title'=>'为什么选择我们','displayorder'=>'6','pcate'=>'0','type'=>'xzwm','create_time'=>'1657527493','update_time'=>'1657527493']);
        
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

