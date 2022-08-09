<?php

use yii\db\Migration;

class m220801_020131_diandi_website_nav extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_website_nav}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'name' => "varchar(128) NOT NULL COMMENT '名称'",
            'parent' => "int(11) NOT NULL COMMENT '父级'",
            'link' => "varchar(255) NULL COMMENT '链接地址'",
            'order' => "int(11) NOT NULL DEFAULT '0' COMMENT '排序'",
            'data' => "blob NULL COMMENT '数据'",
            'type' => "varchar(20) NULL COMMENT '导航类型'",
            'icon' => "varchar(30) NULL COMMENT '图标'",
            'is_show' => "smallint(6) NULL DEFAULT '1' COMMENT '是否显示'",
            'store_id' => "int(11) NULL COMMENT '商户'",
            'bloc_id' => "int(11) NULL COMMENT '公司'",
            'create_time' => "int(11) NULL COMMENT '创建时间'",
            'update_time' => "int(11) NULL COMMENT '更新时间'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8");
        
        /* 索引设置 */
        $this->createIndex('parent','{{%diandi_website_nav}}','parent',0);
        
        
        /* 表数据 */
        $this->insert('{{%diandi_website_nav}}',['id'=>'1','name'=>'首页','parent'=>'0','link'=>'index.html','order'=>'0','data'=>NULL,'type'=>'2','icon'=>NULL,'is_show'=>'0','store_id'=>'75','bloc_id'=>'27','create_time'=>'1632365894','update_time'=>'1632365894']);
        $this->insert('{{%diandi_website_nav}}',['id'=>'2','name'=>'关于和生','parent'=>'0','link'=>'about.html','order'=>'1','data'=>'','type'=>'2','icon'=>'fa fa-battery-0','is_show'=>'0','store_id'=>'75','bloc_id'=>'27','create_time'=>'1632366613','update_time'=>'1632902510']);
        $this->insert('{{%diandi_website_nav}}',['id'=>'3','name'=>'和生简介','parent'=>'2','link'=>'about.html','order'=>'0','data'=>NULL,'type'=>'2','icon'=>NULL,'is_show'=>'0','store_id'=>'75','bloc_id'=>'27','create_time'=>'1632366652','update_time'=>'1632366652']);
        $this->insert('{{%diandi_website_nav}}',['id'=>'4','name'=>'荣誉资质','parent'=>'2','link'=>'honor.html','order'=>'0','data'=>NULL,'type'=>'2','icon'=>NULL,'is_show'=>'0','store_id'=>'75','bloc_id'=>'27','create_time'=>'1632366669','update_time'=>'1632366669']);
        $this->insert('{{%diandi_website_nav}}',['id'=>'5','name'=>'合作伙伴','parent'=>'2','link'=>'partner.html','order'=>'0','data'=>'','type'=>'2','icon'=>'','is_show'=>'0','store_id'=>'75','bloc_id'=>'27','create_time'=>'1632366709','update_time'=>'1632979349']);
        $this->insert('{{%diandi_website_nav}}',['id'=>'6','name'=>'解决方案','parent'=>'0','link'=>'product.html','order'=>'2','data'=>'','type'=>'2','icon'=>'','is_show'=>'0','store_id'=>'75','bloc_id'=>'27','create_time'=>'1632366723','update_time'=>'1632902527']);
        $this->insert('{{%diandi_website_nav}}',['id'=>'7','name'=>'项目案例','parent'=>'6','link'=>'product.html','order'=>'0','data'=>'','type'=>'2','icon'=>'','is_show'=>'0','store_id'=>'75','bloc_id'=>'27','create_time'=>'1632366746','update_time'=>'1632366759']);
        $this->insert('{{%diandi_website_nav}}',['id'=>'8','name'=>'技术支持','parent'=>'6','link'=>'technology.html','order'=>'0','data'=>'','type'=>'2','icon'=>'','is_show'=>'0','store_id'=>'75','bloc_id'=>'27','create_time'=>'1632366792','update_time'=>'1632366792']);
        $this->insert('{{%diandi_website_nav}}',['id'=>'9','name'=>'新闻资讯','parent'=>'0','link'=>'news.html','order'=>'3','data'=>'','type'=>'2','icon'=>'','is_show'=>'0','store_id'=>'75','bloc_id'=>'27','create_time'=>'1632366821','update_time'=>'1632474942']);
        $this->insert('{{%diandi_website_nav}}',['id'=>'10','name'=>'联系我们','parent'=>'0','link'=>'relation.html','order'=>'4','data'=>'','type'=>'2','icon'=>'','is_show'=>'0','store_id'=>'75','bloc_id'=>'27','create_time'=>'1632366852','update_time'=>'1632902551']);
        $this->insert('{{%diandi_website_nav}}',['id'=>'11','name'=>'联系方式','parent'=>'10','link'=>'relation.html','order'=>'0','data'=>'','type'=>'2','icon'=>'','is_show'=>'0','store_id'=>'75','bloc_id'=>'27','create_time'=>'1632366884','update_time'=>'1632901116']);
        $this->insert('{{%diandi_website_nav}}',['id'=>'12','name'=>'加入我们','parent'=>'10','link'=>'job.html','order'=>'0','data'=>NULL,'type'=>'2','icon'=>NULL,'is_show'=>'0','store_id'=>'75','bloc_id'=>'27','create_time'=>'1632366903','update_time'=>'1632366903']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_website_nav}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

