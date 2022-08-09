<?php

use yii\db\Migration;

class m220801_020131_diandi_website_pro_customer extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_website_pro_customer}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'create_time' => "varchar(30) NULL",
            'update_time' => "varchar(30) NULL",
            'image' => "varchar(255) NULL COMMENT '图片'",
            'title' => "varchar(100) NULL COMMENT '标题'",
            'content' => "text NULL COMMENT '内容'",
            'link' => "varchar(255) NULL COMMENT '链接地址'",
            'solution_id' => "int(11) NOT NULL DEFAULT '0' COMMENT '案例ID'",
            'is_website' => "tinyint(2) NOT NULL DEFAULT '-1' COMMENT '是否是官网'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='合作客户'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_website_pro_customer}}',['id'=>'17','store_id'=>'61','bloc_id'=>'8','create_time'=>'2022-06-07 16:02:23','update_time'=>'2022-06-07 16:02:31','image'=>'202206/07/9b25539a-3464-3b6b-b363-afbb77f841d0.png','title'=>'标题1','content'=>'12','link'=>'1','solution_id'=>'0','is_website'=>'-1']);
        $this->insert('{{%diandi_website_pro_customer}}',['id'=>'18','store_id'=>'61','bloc_id'=>'8','create_time'=>'2022-07-11 11:26:28','update_time'=>'2022-07-11 11:26:28','image'=>'202207/11/637d694e-999c-3b1d-9e70-cc66f342cbee.jpg','title'=>'农业养殖','content'=>'农业养殖','link'=>'1','solution_id'=>'0','is_website'=>'1']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_website_pro_customer}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

