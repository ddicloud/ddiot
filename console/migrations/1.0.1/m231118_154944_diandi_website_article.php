<?php

use yii\db\Migration;

class m231118_154944_diandi_website_article extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_website_article}}', [
            'id' => "int(10) unsigned NOT NULL AUTO_INCREMENT",
            'bloc_id' => "int(11) NULL",
            'store_id' => "int(11) NULL",
            'ishot' => "tinyint(1) unsigned NOT NULL",
            'pcate' => "int(10) unsigned NOT NULL",
            'ccate' => "int(10) unsigned NOT NULL",
            'template' => "varchar(300) NOT NULL",
            'title' => "varchar(100) NOT NULL",
            'description' => "varchar(100) NOT NULL",
            'content' => "mediumtext NOT NULL",
            'thumb' => "varchar(255) NOT NULL",
            'source' => "varchar(255) NOT NULL",
            'author' => "varchar(50) NOT NULL",
            'displayorder' => "int(10) unsigned NOT NULL",
            'linkurl' => "varchar(500) NOT NULL",
            'icon' => "varchar(30) NULL",
            'is_top' => "tinyint(2) NOT NULL DEFAULT '-1'",
            'type' => "varchar(255) NULL",
            'create_time' => "int(11) NULL",
            'update_time' => "int(11) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='文章资讯'");
        
        /* 索引设置 */
        $this->createIndex('idx_ishot','{{%diandi_website_article}}','ishot',0);
        
        
        /* 表数据 */
        $this->insert('{{%diandi_website_article}}',['id'=>'89','bloc_id'=>'8','store_id'=>'61','ishot'=>'1','pcate'=>'33','ccate'=>'0','template'=>'1','title'=>'行业新闻','description'=>'功能更新','content'=>'<p>功能更新</p>','thumb'=>'202206/24/77af47fe-72c2-3023-bb92-4e2dd9245f4e.jpg','source'=>'功能更新','author'=>'功能更新','displayorder'=>'1','linkurl'=>'功能更新','icon'=>NULL,'is_top'=>'-1','type'=>'xwzx','create_time'=>'1656061335','update_time'=>'1656061335']);
        $this->insert('{{%diandi_website_article}}',['id'=>'90','bloc_id'=>'8','store_id'=>'61','ishot'=>'1','pcate'=>'31','ccate'=>'0','template'=>'新闻中心','title'=>'运营知识','description'=>'新闻中心','content'=>'<p>新闻中心</p>','thumb'=>'202206/24/63af6a17-dafd-3cc7-b61b-34dcc4cb6eb8.jpg','source'=>'新闻中心','author'=>'新闻中心','displayorder'=>'1','linkurl'=>'新闻中心','icon'=>NULL,'is_top'=>'-1','type'=>'xwzx','create_time'=>'1656061363','update_time'=>'1656061363']);
        $this->insert('{{%diandi_website_article}}',['id'=>'95','bloc_id'=>'8','store_id'=>'61','ishot'=>'1','pcate'=>'38','ccate'=>'0','template'=>'2','title'=>'功能更新','description'=>'大数据时代，数据掌握在自己手里，数据更安全','content'=>'<p><span style=\"color: rgb(242, 139, 84); font-family: Consolas, &quot;Lucida Console&quot;, &quot;Courier New&quot;, monospace; font-size: 12px; white-space: pre;\">大数据时代，数据掌握在自己手里，数据更安全</span></p>','thumb'=>'202207/11/76d3b2ba-d035-3db7-b927-eae92fddecd7.png','source'=>'2','author'=>'2','displayorder'=>'2','linkurl'=>'2','icon'=>NULL,'is_top'=>'1','type'=>'xzwm','create_time'=>'1657527742','update_time'=>'1657527742']);
        $this->insert('{{%diandi_website_article}}',['id'=>'94','bloc_id'=>'8','store_id'=>'61','ishot'=>'1','pcate'=>'38','ccate'=>'0','template'=>'1','title'=>'官方动态','description'=>'只需一次购买，即可获得终身授权，源码永久免费更新。','content'=>'<p><span style=\"color: rgb(242, 139, 84); font-family: Consolas, &quot;Lucida Console&quot;, &quot;Courier New&quot;, monospace; font-size: 12px; white-space: pre;\">只需一次购买，即可获得终身授权，源码永久免费更新。</span></p>','thumb'=>'202207/11/7cba36c4-ef3c-3eb7-8fcd-830c8d18ef1f.png','source'=>'1','author'=>'1','displayorder'=>'1','linkurl'=>'1','icon'=>NULL,'is_top'=>'1','type'=>'xzwm','create_time'=>'1657527564','update_time'=>'1657527564']);
        $this->insert('{{%diandi_website_article}}',['id'=>'93','bloc_id'=>'8','store_id'=>'61','ishot'=>'1','pcate'=>'35','ccate'=>'0','template'=>'12','title'=>'店滴云官网','description'=>'欢迎来到店滴云官网，我们是一直拥有多年开发经验的团队，目前主要开发自家产品以及定制开发良好的服务为各位客户的程序持续更新维护。目前我们的产品有电商，多端自媒体资讯小程序','content'=>'<p>欢迎来到店滴云官网，我们是一直拥有多年开发经验的团队，目前主要开发自家产品以及定制开发良好的服务为各位客户的程序持续更新维护。目前我们的产品有电商，多端自媒体资讯小程序</p>','thumb'=>'202207/11/e111b8e1-b659-3d5a-a649-c73d397082df.jpg','source'=>'12','author'=>'12','displayorder'=>'12','linkurl'=>'12','icon'=>'','is_top'=>'1','type'=>'gsjj','create_time'=>'1657524226','update_time'=>'1657507751']);
        $this->insert('{{%diandi_website_article}}',['id'=>'88','bloc_id'=>'8','store_id'=>'61','ishot'=>'1','pcate'=>'32','ccate'=>'0','template'=>'1','title'=>'行业动态','description'=>'行业动态','content'=>'<p>行业动态</p>','thumb'=>'202206/24/b2d92e6d-df4f-34b4-ae67-f71ff70393be.jpg','source'=>'1','author'=>'1','displayorder'=>'1','linkurl'=>'1','icon'=>NULL,'is_top'=>'-1','type'=>'xwzx','create_time'=>'1656061300','update_time'=>'1656061300']);
        $this->insert('{{%diandi_website_article}}',['id'=>'92','bloc_id'=>'8','store_id'=>'61','ishot'=>'1','pcate'=>'31','ccate'=>'0','template'=>'3','title'=>'新闻新闻','description'=>'新闻新闻','content'=>'<p>新闻新闻</p>','thumb'=>'202206/24/85275b3e-7f0a-3ab1-9d14-0729e1acb0d8.jpg','source'=>'3','author'=>'3','displayorder'=>'3','linkurl'=>'3','icon'=>NULL,'is_top'=>'-1','type'=>'xwzx','create_time'=>'1656063666','update_time'=>'1656063666']);
        $this->insert('{{%diandi_website_article}}',['id'=>'91','bloc_id'=>'8','store_id'=>'61','ishot'=>'1','pcate'=>'31','ccate'=>'0','template'=>'2','title'=>'这是新闻','description'=>'这是新闻','content'=>'<p>这是新闻</p>','thumb'=>'202206/24/2866cac4-d697-3c34-8bf7-a67dd998190a.jpg','source'=>'2','author'=>'2','displayorder'=>'2','linkurl'=>'2','icon'=>NULL,'is_top'=>'-1','type'=>'xwzx','create_time'=>'1656063639','update_time'=>'1656063639']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_website_article}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

