<?php

use yii\db\Migration;

class m220801_020131_diandi_website_pro_app extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_website_pro_app}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'create_time' => "varchar(30) NULL",
            'update_time' => "varchar(30) NULL",
            'link' => "varchar(255) NULL COMMENT '立即使用链接地址'",
            'logo' => "varchar(255) NULL COMMENT '图标'",
            'content' => "text NULL COMMENT '内容'",
            'title' => "varchar(100) NULL COMMENT '标题'",
            'tip1' => "varchar(255) NULL COMMENT '小提示1'",
            'tip2' => "varchar(255) NULL COMMENT '小提示2'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='应用中心'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_website_pro_app}}',['id'=>'23','store_id'=>'80','bloc_id'=>'31','create_time'=>'2022-06-07 11:55:16','update_time'=>'2022-06-07 11:55:16','link'=>'1','logo'=>NULL,'content'=>'1','title'=>'1','tip1'=>'1','tip2'=>'1']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_website_pro_app}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

