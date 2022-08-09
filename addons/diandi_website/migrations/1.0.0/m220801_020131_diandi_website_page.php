<?php

use yii\db\Migration;

class m220801_020131_diandi_website_page extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_website_page}}', [
            'id' => "int(10) unsigned NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'title' => "varchar(100) NOT NULL DEFAULT ''",
            'image' => "varchar(255) NOT NULL DEFAULT ''",
            'description' => "varchar(255) NOT NULL DEFAULT ''",
            'keyword' => "varchar(100) NOT NULL DEFAULT ''",
            'template' => "varchar(100) NOT NULL DEFAULT '' COMMENT '模板路径'",
            'content' => "text NOT NULL",
            'created_at' => "int(11) NULL",
            'updated_at' => "int(11) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_website_page}}',['id'=>'1','store_id'=>'61','bloc_id'=>'8','title'=>'解决方案','image'=>'202206/24/5ef938bf-07e6-30f8-bb30-009c2992de6a.jpg','description'=>'解决方案','keyword'=>'解决方案','template'=>'jjfa','content'=>'<p>解决方案</p>','created_at'=>'1656053301','updated_at'=>'1656053327']);
        $this->insert('{{%diandi_website_page}}',['id'=>'2','store_id'=>'61','bloc_id'=>'8','title'=>'新闻中心','image'=>'202207/14/824a548d-2c9e-34e2-9415-a37bb3b8a976.png','description'=>'新闻中心','keyword'=>'新闻中心','template'=>'xwzx','content'=>'<p>新闻中心</p>','created_at'=>'1656053999','updated_at'=>'1657783390']);
        $this->insert('{{%diandi_website_page}}',['id'=>'3','store_id'=>'61','bloc_id'=>'8','title'=>'应用中心','image'=>'202207/14/fa21d941-a62a-3443-be87-75954fa295a2.png','description'=>'应用中心','keyword'=>'','template'=>'yyzx','content'=>'<p>应用中心</p>','created_at'=>'1656054204','updated_at'=>'1657794894']);
        $this->insert('{{%diandi_website_page}}',['id'=>'6','store_id'=>'61','bloc_id'=>'8','title'=>'定制业务','image'=>'202207/14/3376ec37-1c53-3e3a-8b1a-4039ab1392e3.png','description'=>'定制业务','keyword'=>'','template'=>'dzyw','content'=>'<p>定制业务</p>','created_at'=>'1656054970','updated_at'=>'1657784051']);
        $this->insert('{{%diandi_website_page}}',['id'=>'7','store_id'=>'61','bloc_id'=>'8','title'=>'公司简介','image'=>'202207/14/a41b636d-0b2c-3573-8e06-55536cbf7455.png','description'=>'公司简介','keyword'=>'12','template'=>'gsjj','content'=>'<p>公司简介公司简介公司简介</p>','created_at'=>'1656055107','updated_at'=>'1657783402']);
        $this->insert('{{%diandi_website_page}}',['id'=>'8','store_id'=>'61','bloc_id'=>'8','title'=>'商业授权','image'=>'202207/14/113f1533-a9ca-3210-96aa-b5965f2a293d.png','description'=>'商业授权','keyword'=>'','template'=>'sysq','content'=>'<p>商业授权</p>','created_at'=>'1656055190','updated_at'=>'1657773546']);
        $this->insert('{{%diandi_website_page}}',['id'=>'9','store_id'=>'61','bloc_id'=>'8','title'=>'产品功能','image'=>'202206/24/41f9a9dc-98f1-3578-81e5-65a524da1f7d.jpg','description'=>'产品功能','keyword'=>'产品功能','template'=>'cpgn','content'=>'<p>产品功能</p>','created_at'=>'1656055983','updated_at'=>'1656055983']);
        $this->insert('{{%diandi_website_page}}',['id'=>'10','store_id'=>'61','bloc_id'=>'8','title'=>'客户案例','image'=>'202206/24/29c6ded3-a608-3cc9-8b40-7edacdc0b9af.jpg','description'=>'客户案例','keyword'=>'','template'=>'khal','content'=>'<p>客户案例</p>','created_at'=>'1656056490','updated_at'=>'1656056490']);
        $this->insert('{{%diandi_website_page}}',['id'=>'11','store_id'=>'61','bloc_id'=>'8','title'=>'关于我们','image'=>'202207/11/9afdd8d2-dea4-3a60-a87f-ec73693fad9e.jpg','description'=>'关于我们','keyword'=>'关于我们','template'=>'gywm','content'=>'<p dir=\"ltr\"><span style=\"color: rgb(26, 26, 166); font-family: monospace; font-size: medium; white-space: pre;\"> &nbsp; &nbsp;</span>店滴云，针对多商户业务开发的一套管理cms，支持多运营主体，单运营主体运营开发。cms基于世界上最好的语言php和yi开发，采用最新的vue开发技术作为中后台管理，多终端开发框架uniapp打造，旨在让开发更有趣味和成就感，希望可以助力更多的中小企业实现业绩增长，技术创新和持续发展。官方依赖于店滴云先后开发了疫情大数据监测，企业外呼，im客服，多商户分销，外卖点餐，政企党建等系统。</p>','created_at'=>'1657524340','updated_at'=>'1657524526']);
        $this->insert('{{%diandi_website_page}}',['id'=>'12','store_id'=>'61','bloc_id'=>'8','title'=>'规划','image'=>'202207/11/17632ed5-7f46-3111-a40a-1f4993eaa84e.jpg','description'=>'12','keyword'=>'12','template'=>'gh','content'=>'<p>应用市场上线，开发者入驻，打造智能设备业务管理系统</p><p><br/></p>','created_at'=>'1657524406','updated_at'=>'1657524577']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_website_page}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

