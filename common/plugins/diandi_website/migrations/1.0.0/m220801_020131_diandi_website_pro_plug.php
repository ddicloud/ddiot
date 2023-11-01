<?php

use yii\db\Migration;

class m220801_020131_diandi_website_pro_plug extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_website_pro_plug}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'create_time' => "varchar(30) NULL",
            'update_time' => "varchar(30) NULL",
            'logo' => "varchar(255) NULL COMMENT 'logo'",
            'title' => "varchar(100) NULL COMMENT '标题'",
            'content' => "varchar(255) NULL COMMENT '内容'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='产品插件'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_website_pro_plug}}',['id'=>'17','store_id'=>'61','bloc_id'=>'8','create_time'=>'2022-06-07 17:03:17','update_time'=>'2022-06-07 17:04:23','logo'=>'202206/07/a9314551-52e4-3a05-a1ae-2b7a95a1bba4.png','title'=>'标题1','content'=>'12']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_website_pro_plug}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

