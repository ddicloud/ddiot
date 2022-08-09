<?php

use yii\db\Migration;

class m220801_020131_diandi_website_slide extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_website_slide}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'images' => "varchar(255) NULL",
            'title' => "varchar(255) NULL",
            'description' => "varchar(255) NULL",
            'menuname' => "varchar(255) NULL",
            'menuurl' => "varchar(255) NULL",
            'create_time' => "int(30) NULL",
            'update_time' => "int(30) NULL",
            'page_id' => "int(11) NULL COMMENT '页面配置id'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='幻灯片'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_website_slide}}',['id'=>'6','store_id'=>NULL,'bloc_id'=>NULL,'images'=>'http://www.ai.com/attachment/202105/17/9f46de01-7cf4-3507-a0a0-2791e3e55a73.jpg','title'=>'标题','description'=>'描述','menuname'=>'按钮名称','menuurl'=>'www','create_time'=>'1621220295','update_time'=>'1621220295','page_id'=>NULL]);
        $this->insert('{{%diandi_website_slide}}',['id'=>'7','store_id'=>NULL,'bloc_id'=>NULL,'images'=>'http://www.ai.com/attachment/202105/17/9f46de01-7cf4-3507-a0a0-2791e3e55a73.jpg','title'=>'标题','description'=>'描述','menuname'=>'按钮名称','menuurl'=>'www','create_time'=>'1621220358','update_time'=>'1621220358','page_id'=>NULL]);
        $this->insert('{{%diandi_website_slide}}',['id'=>'8','store_id'=>NULL,'bloc_id'=>NULL,'images'=>'http://www.ai.com/attachment/202105/17/9e70b63a-b679-3f91-913f-190c80854533.jpg','title'=>'标题','description'=>'描述','menuname'=>'按钮','menuurl'=>'www','create_time'=>'1621220480','update_time'=>'1621220480','page_id'=>NULL]);
        $this->insert('{{%diandi_website_slide}}',['id'=>'11','store_id'=>NULL,'bloc_id'=>NULL,'images'=>'http://www.ai.com/attachment/202105/17/06c6fbe5-02c4-30bd-a9d5-0d5ea1d212ff.jpg','title'=>'新标题','description'=>'描述内容','menuname'=>'按钮名称','menuurl'=>'wwwwwww','create_time'=>'1621223009','update_time'=>'1621223009','page_id'=>NULL]);
        $this->insert('{{%diandi_website_slide}}',['id'=>'14','store_id'=>NULL,'bloc_id'=>NULL,'images'=>'https://dev.hopesfire.com/attachment/202109/22/ff2fa133-fdfc-3753-bb69-de1c44e7ed6f.png','title'=>'测试','description'=>'描述','menuname'=>'按钮名称','menuurl'=>'url','create_time'=>NULL,'update_time'=>NULL,'page_id'=>NULL]);
        $this->insert('{{%diandi_website_slide}}',['id'=>'15','store_id'=>'75','bloc_id'=>'27','images'=>'202207/14/6d2e0021-ff50-36d0-a2a8-45bdf710f8a9.jpg','title'=>'001','description'=>'描述','menuname'=>'001','menuurl'=>'001','create_time'=>'1632364600','update_time'=>'1657780116','page_id'=>NULL]);
        $this->insert('{{%diandi_website_slide}}',['id'=>'16','store_id'=>'75','bloc_id'=>'27','images'=>'https://dev.hopesfire.com/attachment/202110/08/f3318888-4828-3315-88ca-c3a9f4c98810.jpg','title'=>'002','description'=>'002','menuname'=>'002','menuurl'=>'003','create_time'=>'1632364617','update_time'=>'1633659162','page_id'=>NULL]);
        $this->insert('{{%diandi_website_slide}}',['id'=>'17','store_id'=>'75','bloc_id'=>'27','images'=>'https://dev.hopesfire.com/attachment/202110/08/89fa0b84-33f5-3efa-83a3-f03c02b6b8c3.jpg','title'=>'积极务实','description'=>'团结创新','menuname'=>'','menuurl'=>'','create_time'=>'1632467234','update_time'=>'1633659830','page_id'=>NULL]);
        $this->insert('{{%diandi_website_slide}}',['id'=>'19','store_id'=>'79','bloc_id'=>'30','images'=>'202204/21/af16f673-a5de-3823-98da-8d564d05918c.jpg','title'=>'首页','description'=>NULL,'menuname'=>NULL,'menuurl'=>NULL,'create_time'=>'1650507165','update_time'=>'1650507165','page_id'=>'28']);
        $this->insert('{{%diandi_website_slide}}',['id'=>'20','store_id'=>'82','bloc_id'=>'33','images'=>'202204/21/1d9e09b5-a41a-305f-8e65-b188728c382a.png','title'=>'首页','description'=>NULL,'menuname'=>NULL,'menuurl'=>NULL,'create_time'=>'1650510900','update_time'=>'1650510900','page_id'=>'28']);
        $this->insert('{{%diandi_website_slide}}',['id'=>'21','store_id'=>'82','bloc_id'=>'33','images'=>'','title'=>'首页','description'=>'','menuname'=>'','menuurl'=>'','create_time'=>'1650511653','update_time'=>'1650511653','page_id'=>'28']);
        $this->insert('{{%diandi_website_slide}}',['id'=>'23','store_id'=>'82','bloc_id'=>'33','images'=>'202204/21/601e16df-96f0-33b1-8692-df4276b8ab3e.jpg','title'=>'农业政策','description'=>NULL,'menuname'=>NULL,'menuurl'=>NULL,'create_time'=>'1650513094','update_time'=>'1650513094','page_id'=>'30']);
        $this->insert('{{%diandi_website_slide}}',['id'=>'24','store_id'=>'82','bloc_id'=>'33','images'=>'202204/21/5be0de87-7496-3a03-86a9-c6893afe284f.jpg','title'=>'农业政策','description'=>'农业政策','menuname'=>NULL,'menuurl'=>NULL,'create_time'=>'1650513223','update_time'=>'1650513223','page_id'=>'30']);
        $this->insert('{{%diandi_website_slide}}',['id'=>'25','store_id'=>'82','bloc_id'=>'33','images'=>NULL,'title'=>'农场监控','description'=>'农场监控','menuname'=>NULL,'menuurl'=>NULL,'create_time'=>'1650513381','update_time'=>'1650513381','page_id'=>'31']);
        $this->insert('{{%diandi_website_slide}}',['id'=>'26','store_id'=>'82','bloc_id'=>'33','images'=>NULL,'title'=>'农场介绍','description'=>'农场介绍','menuname'=>NULL,'menuurl'=>NULL,'create_time'=>'1650513542','update_time'=>'1650513542','page_id'=>'32']);
        $this->insert('{{%diandi_website_slide}}',['id'=>'27','store_id'=>'82','bloc_id'=>'33','images'=>'202204/21/e4f9e109-96dc-31cf-8373-634737cfe256.jpg','title'=>'最新资讯','description'=>'最新资讯','menuname'=>NULL,'menuurl'=>NULL,'create_time'=>'1650513669','update_time'=>'1650513669','page_id'=>'33']);
        $this->insert('{{%diandi_website_slide}}',['id'=>'28','store_id'=>'82','bloc_id'=>'33','images'=>'202204/21/3cf53055-4b7a-3508-8b22-2c027ce072ff.jpg','title'=>'认养','description'=>'认养','menuname'=>'','menuurl'=>'','create_time'=>'1650521326','update_time'=>'1650521364','page_id'=>'35']);
        $this->insert('{{%diandi_website_slide}}',['id'=>'29','store_id'=>'0','bloc_id'=>'0','images'=>'202205/05/a735019f-5cca-32be-9321-6e1d0d57641f.png','title'=>'首页','description'=>'首页','menuname'=>'首页','menuurl'=>'首页','create_time'=>'1651718335','update_time'=>'1651718335','page_id'=>'37']);
        $this->insert('{{%diandi_website_slide}}',['id'=>'31','store_id'=>'80','bloc_id'=>'31','images'=>'202205/07/68abdef1-5fbb-3629-a366-2802785d4e58.jpg','title'=>'首页','description'=>'首页','menuname'=>'首页','menuurl'=>'首页','create_time'=>'1651719175','update_time'=>'1651899714','page_id'=>'37']);
        $this->insert('{{%diandi_website_slide}}',['id'=>'32','store_id'=>'80','bloc_id'=>'31','images'=>'202205/07/57f9bde0-62db-3682-9923-c8cf35445c12.jpg','title'=>'首页','description'=>'首页','menuname'=>'','menuurl'=>'','create_time'=>'1651720098','update_time'=>'1651899722','page_id'=>'37']);
        $this->insert('{{%diandi_website_slide}}',['id'=>'33','store_id'=>'61','bloc_id'=>'8','images'=>'202207/13/3c03557d-8a94-3eea-94aa-a1fde4899006.png','title'=>'首页','description'=>'首页','menuname'=>'sy','menuurl'=>'sy','create_time'=>'1656040034','update_time'=>'1657710012','page_id'=>'38']);
        $this->insert('{{%diandi_website_slide}}',['id'=>'34','store_id'=>'61','bloc_id'=>'8','images'=>'202207/13/a2c4ea04-eb2e-36bd-a5a2-481fd4d57ea4.png','title'=>'防控','description'=>'防控','menuname'=>'首页','menuurl'=>'首页','create_time'=>'1656051141','update_time'=>'1657708609','page_id'=>'38']);
        $this->insert('{{%diandi_website_slide}}',['id'=>'37','store_id'=>'61','bloc_id'=>'8','images'=>'202207/13/453b9662-e0dd-30ce-a073-c0851f28507e.png','title'=>'农业','description'=>'农业','menuname'=>'','menuurl'=>'','create_time'=>'1657707483','update_time'=>'1657707483','page_id'=>'38']);
        $this->insert('{{%diandi_website_slide}}',['id'=>'38','store_id'=>'61','bloc_id'=>'8','images'=>'202207/13/22169d73-6e88-35e9-905c-484255da484f.png','title'=>'电商','description'=>'电商','menuname'=>'','menuurl'=>'','create_time'=>'1657707495','update_time'=>'1657708680','page_id'=>'38']);
        $this->insert('{{%diandi_website_slide}}',['id'=>'40','store_id'=>'61','bloc_id'=>'8','images'=>'202207/15/8b920e35-b74b-340c-a656-f2bf67798cb1.png','title'=>'小程序首页','description'=>'小程序首页','menuname'=>'小程序首页','menuurl'=>'index','create_time'=>'1657770556','update_time'=>'1657849548','page_id'=>'39']);
        $this->insert('{{%diandi_website_slide}}',['id'=>'41','store_id'=>'61','bloc_id'=>'8','images'=>'202207/15/4e014032-c212-32ae-9eae-c5b5f99f1041.png','title'=>'小程序农业认养','description'=>'小程序农业认养','menuname'=>'小程序','menuurl'=>'index','create_time'=>'1657770763','update_time'=>'1657868053','page_id'=>'39']);
        $this->insert('{{%diandi_website_slide}}',['id'=>'42','store_id'=>'77','bloc_id'=>'28','images'=>'202207/14/9176af25-0b1b-3f08-b564-e6763bb72163.jpg','title'=>NULL,'description'=>NULL,'menuname'=>NULL,'menuurl'=>NULL,'create_time'=>'1657780176','update_time'=>'1657780176','page_id'=>NULL]);
        $this->insert('{{%diandi_website_slide}}',['id'=>'43','store_id'=>'61','bloc_id'=>'8','images'=>'202207/15/a0f8ade8-44d7-32d3-bc06-549424996067.png','title'=>'小程序解决方案','description'=>' 小程序解决方案','menuname'=>'','menuurl'=>'','create_time'=>'1657867995','update_time'=>'1657867995','page_id'=>'39']);
        $this->insert('{{%diandi_website_slide}}',['id'=>'44','store_id'=>'61','bloc_id'=>'8','images'=>'202207/15/33f52962-4667-3dd3-b737-3bf2f6a3abd5.png','title'=>' 小程序智能房控','description'=>' 小程序智能房控','menuname'=>'','menuurl'=>'','create_time'=>'1657868036','update_time'=>'1657868036','page_id'=>'39']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_website_slide}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

