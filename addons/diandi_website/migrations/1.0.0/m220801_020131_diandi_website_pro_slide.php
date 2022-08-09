<?php

use yii\db\Migration;

class m220801_020131_diandi_website_pro_slide extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_website_pro_slide}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'create_time' => "varchar(30) NULL",
            'update_time' => "varchar(30) NULL",
            'link' => "varchar(255) NULL COMMENT '链接地址'",
            'image' => "varchar(255) NULL COMMENT '显示图片'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='产品幻灯片'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_website_pro_slide}}',['id'=>'17','store_id'=>'61','bloc_id'=>'8','create_time'=>'2022-06-07 18:04:59','update_time'=>'2022-06-07 18:05:10','link'=>'121','image'=>'202206/07/579c4f18-fe81-3f8c-87c8-42fa880438c5.png']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_website_pro_slide}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

