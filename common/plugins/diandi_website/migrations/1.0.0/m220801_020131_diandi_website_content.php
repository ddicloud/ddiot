<?php

use yii\db\Migration;

class m220801_020131_diandi_website_content extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_website_content}}', [
            'id' => "int(10) unsigned NOT NULL AUTO_INCREMENT",
            'language' => "varchar(20) NOT NULL",
            'title' => "varchar(255) NOT NULL DEFAULT ''",
            'type' => "tinyint(4) NOT NULL DEFAULT '1' COMMENT '类型1news,2product3photo'",
            'category_id' => "int(11) NOT NULL",
            'image' => "varchar(255) NOT NULL DEFAULT '' COMMENT '缩略图'",
            'description' => "varchar(255) NOT NULL DEFAULT ''",
            'keywords' => "varchar(255) NOT NULL DEFAULT ''",
            'status' => "tinyint(4) NOT NULL DEFAULT '0' COMMENT '0不显示1显示'",
            'admin_user_id' => "int(11) NOT NULL DEFAULT '0'",
            'hits' => "int(11) NOT NULL DEFAULT '0' COMMENT '浏览数点击数'",
            'created_at' => "int(11) NOT NULL DEFAULT '0'",
            'updated_at' => "int(11) NOT NULL DEFAULT '0'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8");
        
        /* 索引设置 */
        $this->createIndex('i-type-status-title','{{%diandi_website_content}}','type, status, title',0);
        $this->createIndex('i-update','{{%diandi_website_content}}','updated_at',0);
        $this->createIndex('i-language','{{%diandi_website_content}}','language',0);
        
        
        /* 表数据 */
        $this->insert('{{%diandi_website_content}}',['id'=>'1','language'=>'zh-CN','title'=>'测试1','type'=>'1','category_id'=>'0','image'=>'','description'=>'测试测试222','keywords'=>'','status'=>'1','admin_user_id'=>'0','hits'=>'0','created_at'=>'0','updated_at'=>'1481269292']);
        $this->insert('{{%diandi_website_content}}',['id'=>'7','language'=>'zh-CN','title'=>'新闻2','type'=>'1','category_id'=>'3','image'=>'','description'=>'吃豆腐的房地产','keywords'=>'','status'=>'0','admin_user_id'=>'0','hits'=>'0','created_at'=>'1481264976','updated_at'=>'1481379895']);
        $this->insert('{{%diandi_website_content}}',['id'=>'9','language'=>'zh-CN','title'=>'dfdsfadfdsfdsfds','type'=>'1','category_id'=>'0','image'=>'','description'=>'dfsdds','keywords'=>'','status'=>'0','admin_user_id'=>'0','hits'=>'0','created_at'=>'1481265228','updated_at'=>'1481265228']);
        $this->insert('{{%diandi_website_content}}',['id'=>'10','language'=>'zh-CN','title'=>'dfsdfds312321的所得税法','type'=>'1','category_id'=>'0','image'=>'','description'=>'的范德萨发的','keywords'=>'','status'=>'0','admin_user_id'=>'1','hits'=>'0','created_at'=>'1481265362','updated_at'=>'1481265362']);
        $this->insert('{{%diandi_website_content}}',['id'=>'11','language'=>'zh-CN','title'=>'测试你好','type'=>'1','category_id'=>'0','image'=>'','description'=>'三大市场','keywords'=>'','status'=>'1','admin_user_id'=>'1','hits'=>'0','created_at'=>'1481265454','updated_at'=>'1481265454']);
        $this->insert('{{%diandi_website_content}}',['id'=>'13','language'=>'zh-CN','title'=>'sdfdsvds','type'=>'1','category_id'=>'0','image'=>'','description'=>'dsfadsfdsa adfdasfd','keywords'=>'','status'=>'0','admin_user_id'=>'1','hits'=>'0','created_at'=>'1481265650','updated_at'=>'1481265650']);
        $this->insert('{{%diandi_website_content}}',['id'=>'14','language'=>'zh-CN','title'=>'dfsdfds312321的所得税法dsfdsf','type'=>'1','category_id'=>'0','image'=>'','description'=>'fdsdsfsdfds','keywords'=>'','status'=>'0','admin_user_id'=>'1','hits'=>'0','created_at'=>'1481268136','updated_at'=>'1481268136']);
        $this->insert('{{%diandi_website_content}}',['id'=>'15','language'=>'zh-CN','title'=>'测试测试测试','type'=>'1','category_id'=>'0','image'=>'','description'=>'测试测试222','keywords'=>'','status'=>'0','admin_user_id'=>'1','hits'=>'0','created_at'=>'1481268506','updated_at'=>'1481268506']);
        $this->insert('{{%diandi_website_content}}',['id'=>'16','language'=>'zh-CN','title'=>'电风扇的范德萨','type'=>'1','category_id'=>'0','image'=>'','description'=>'东方闪电','keywords'=>'','status'=>'0','admin_user_id'=>'1','hits'=>'0','created_at'=>'1481268645','updated_at'=>'1481268645']);
        $this->insert('{{%diandi_website_content}}',['id'=>'17','language'=>'zh-CN','title'=>'ceshi','type'=>'1','category_id'=>'2','image'=>'','description'=>'测试','keywords'=>'','status'=>'1','admin_user_id'=>'1','hits'=>'0','created_at'=>'1481294417','updated_at'=>'1482486244']);
        $this->insert('{{%diandi_website_content}}',['id'=>'18','language'=>'zh-CN','title'=>'测试测试','type'=>'1','category_id'=>'0','image'=>'','description'=>'测试3333333','keywords'=>'','status'=>'1','admin_user_id'=>'1','hits'=>'1','created_at'=>'1481294436','updated_at'=>'1481294436']);
        $this->insert('{{%diandi_website_content}}',['id'=>'19','language'=>'zh-CN','title'=>'测试测试测试','type'=>'1','category_id'=>'2','image'=>'','description'=>'测试测试','keywords'=>'','status'=>'1','admin_user_id'=>'1','hits'=>'14','created_at'=>'1481294458','updated_at'=>'1482120320']);
        $this->insert('{{%diandi_website_content}}',['id'=>'20','language'=>'zh-CN','title'=>'德国代购2016 Marc Jacobs/马克·雅可布 女士撞色皮质直板钱包','type'=>'2','category_id'=>'1','image'=>'','description'=>'<p>德国代购2016 Marc Jacobs/马克·雅可布 女士撞色皮质直板钱包</p>','keywords'=>'','status'=>'1','admin_user_id'=>'1','hits'=>'0','created_at'=>'1481455753','updated_at'=>'1482071209']);
        $this->insert('{{%diandi_website_content}}',['id'=>'21','language'=>'zh-CN','title'=>'测试测试','type'=>'2','category_id'=>'1','image'=>'/uploads/products-img/img_584d571075916.jpg','description'=>'测试','keywords'=>'','status'=>'1','admin_user_id'=>'1','hits'=>'0','created_at'=>'1481463544','updated_at'=>'1481552670']);
        $this->insert('{{%diandi_website_content}}',['id'=>'22','language'=>'zh-CN','title'=>'测试测试测试','type'=>'2','category_id'=>'1','image'=>'/uploads/products-img/img_584d57438ddb0.jpg','description'=>'测试测试测试','keywords'=>'','status'=>'1','admin_user_id'=>'1','hits'=>'0','created_at'=>'1481463619','updated_at'=>'1481463619']);
        $this->insert('{{%diandi_website_content}}',['id'=>'23','language'=>'zh-CN','title'=>'测试产品22222222222222','type'=>'2','category_id'=>'1','image'=>'/uploads/products-img/img_584d5d65a0855.jpg','description'=>'测试产品','keywords'=>'','status'=>'1','admin_user_id'=>'1','hits'=>'0','created_at'=>'1481465189','updated_at'=>'1481465189']);
        $this->insert('{{%diandi_website_content}}',['id'=>'24','language'=>'zh-CN','title'=>'飒飒的范德萨范德萨似懂非懂是','type'=>'2','category_id'=>'1','image'=>'/uploads/products-img/img_58575c9b83b7b.png','description'=>'<p>似懂非懂是付的是</p><p><br></p>','keywords'=>'','status'=>'1','admin_user_id'=>'1','hits'=>'4','created_at'=>'1481465708','updated_at'=>'1482120751']);
        $this->insert('{{%diandi_website_content}}',['id'=>'25','language'=>'zh-CN','title'=>'美国代购2016 MOTHER 女士磨边牛仔裤','type'=>'2','category_id'=>'1','image'=>'/uploads/products-img/img_584eb27571659.jpg','description'=>'重度磨损和猫须褶皱为这款褪色 MOTHER 牛仔裤带来做旧效果。5 口袋设计。钮扣和拉链门襟。','keywords'=>'','status'=>'1','admin_user_id'=>'1','hits'=>'6','created_at'=>'1481552501','updated_at'=>'1481552688']);
        $this->insert('{{%diandi_website_content}}',['id'=>'26','language'=>'zh-CN','title'=>'关于公司考勤制度','type'=>'3','category_id'=>'5','image'=>'','description'=>'<p>关于公司考勤制度</p>','keywords'=>'','status'=>'1','admin_user_id'=>'1','hits'=>'0','created_at'=>'1482155706','updated_at'=>'1482157422']);
        $this->insert('{{%diandi_website_content}}',['id'=>'27','language'=>'zh-CN','title'=>'测试','type'=>'3','category_id'=>'5','image'=>'','description'=>'','keywords'=>'','status'=>'0','admin_user_id'=>'1','hits'=>'0','created_at'=>'1482200020','updated_at'=>'1482202904']);
        $this->insert('{{%diandi_website_content}}',['id'=>'28','language'=>'zh-CN','title'=>'继承测试','type'=>'1','category_id'=>'2','image'=>'','description'=>'继承测试','keywords'=>'gggg','status'=>'1','admin_user_id'=>'1','hits'=>'10','created_at'=>'1482291369','updated_at'=>'1510469205']);
        $this->insert('{{%diandi_website_content}}',['id'=>'29','language'=>'zh-CN','title'=>'产品继承测试','type'=>'2','category_id'=>'1','image'=>'/uploads/products-img/img_5859f8c6724c8.jpg','description'=>'','keywords'=>'','status'=>'1','admin_user_id'=>'1','hits'=>'23','created_at'=>'1482291398','updated_at'=>'1482325074']);
        $this->insert('{{%diandi_website_content}}',['id'=>'30','language'=>'zh-CN','title'=>'办公环境','type'=>'4','category_id'=>'6','image'=>'','description'=>'','keywords'=>'','status'=>'1','admin_user_id'=>'1','hits'=>'8','created_at'=>'1482560413','updated_at'=>'1482560413']);
        $this->insert('{{%diandi_website_content}}',['id'=>'31','language'=>'zh-CN','title'=>'测试相册','type'=>'4','category_id'=>'6','image'=>'','description'=>'测试','keywords'=>'测试','status'=>'1','admin_user_id'=>'1','hits'=>'0','created_at'=>'1482654720','updated_at'=>'1482654720']);
        $this->insert('{{%diandi_website_content}}',['id'=>'32','language'=>'zh-CN','title'=>'cccc','type'=>'3','category_id'=>'5','image'=>'','description'=>'','keywords'=>'ssss','status'=>'0','admin_user_id'=>'1','hits'=>'0','created_at'=>'1489731591','updated_at'=>'1494326191']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_website_content}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

