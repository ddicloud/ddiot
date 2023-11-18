<?php

use yii\db\Migration;

class m231118_000438_diandi_website_slide extends Migration
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
            'displayorder' => "int(11) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='幻灯片'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_website_slide}}',['id'=>'38','store_id'=>'61','bloc_id'=>'8','images'=>'202208/01/6a9e76a0-57c9-398b-b087-60a6379e1e66.png','title'=>'花卉电商','description'=>'专注花卉市场订单调度电商系统','menuname'=>'申请试用','menuurl'=>'https://www.dandicloud.cn/#/register','create_time'=>'1657707495','update_time'=>'1659339788','page_id'=>'38','displayorder'=>'2']);
        $this->insert('{{%diandi_website_slide}}',['id'=>'37','store_id'=>'61','bloc_id'=>'8','images'=>'202208/01/09032c4d-2912-3050-a315-bb329d5c52dd.png','title'=>'农业认养','description'=>'农业养殖与在线认养电商系统','menuname'=>'申请试用','menuurl'=>'https://www.dandicloud.cn/#/register','create_time'=>'1657707483','update_time'=>'1659339774','page_id'=>'38','displayorder'=>'3']);
        $this->insert('{{%diandi_website_slide}}',['id'=>'44','store_id'=>'61','bloc_id'=>'8','images'=>'202207/15/33f52962-4667-3dd3-b737-3bf2f6a3abd5.png','title'=>' 小程序智能房控','description'=>' 小程序智能房控','menuname'=>'','menuurl'=>'','create_time'=>'1657868036','update_time'=>'1657868036','page_id'=>'39','displayorder'=>NULL]);
        $this->insert('{{%diandi_website_slide}}',['id'=>'34','store_id'=>'61','bloc_id'=>'8','images'=>'202208/01/5f2f6326-e9dd-3f15-b26b-0f12f37d4c9e.png','title'=>'智能房控','description'=>'酒店，公寓房源智慧管控','menuname'=>'申请试用','menuurl'=>'https://www.dandicloud.cn/#/register','create_time'=>'1656051141','update_time'=>'1659916219','page_id'=>'38','displayorder'=>'4']);
        $this->insert('{{%diandi_website_slide}}',['id'=>'40','store_id'=>'61','bloc_id'=>'8','images'=>'202207/15/8b920e35-b74b-340c-a656-f2bf67798cb1.png','title'=>'小程序首页','description'=>'小程序首页','menuname'=>'小程序首页','menuurl'=>'index','create_time'=>'1657770556','update_time'=>'1657849548','page_id'=>'39','displayorder'=>NULL]);
        $this->insert('{{%diandi_website_slide}}',['id'=>'33','store_id'=>'61','bloc_id'=>'8','images'=>'202208/01/0ed4d0bb-d5bb-3680-ba3b-5cfa5244c95c.png','title'=>'无人茶室','description'=>'让经营场所更智能','menuname'=>'申请试用','menuurl'=>'https://www.dandicloud.cn/#/register','create_time'=>'1656040034','update_time'=>'1659339755','page_id'=>'38','displayorder'=>'5']);
        $this->insert('{{%diandi_website_slide}}',['id'=>'41','store_id'=>'61','bloc_id'=>'8','images'=>'202207/15/4e014032-c212-32ae-9eae-c5b5f99f1041.png','title'=>'小程序农业认养','description'=>'小程序农业认养','menuname'=>'小程序','menuurl'=>'index','create_time'=>'1657770763','update_time'=>'1657868053','page_id'=>'39','displayorder'=>NULL]);
        $this->insert('{{%diandi_website_slide}}',['id'=>'43','store_id'=>'61','bloc_id'=>'8','images'=>'202207/15/a0f8ade8-44d7-32d3-bc06-549424996067.png','title'=>'小程序解决方案','description'=>' 小程序解决方案','menuname'=>'','menuurl'=>'','create_time'=>'1657867995','update_time'=>'1657867995','page_id'=>'39','displayorder'=>NULL]);
        
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

