<?php

use yii\db\Migration;

class m220801_020131_diandi_website_pro_h5_body extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_website_pro_h5_body}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'create_time' => "varchar(30) NULL",
            'update_time' => "varchar(30) NULL",
            'title' => "varchar(100) NULL COMMENT '标题'",
            'content' => "text NULL COMMENT '内容'",
            'image_a' => "varchar(255) NULL COMMENT 'a图'",
            'image_b' => "varchar(255) NULL COMMENT 'b图'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='h5界面展示'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_website_pro_h5_body}}',['id'=>'17','store_id'=>'61','bloc_id'=>'8','create_time'=>'2022-06-07 16:43:15','update_time'=>'2022-06-07 16:45:07','title'=>'biaoti1','content'=>'1','image_a'=>'202206/07/95d038d1-7e41-36f9-8bf2-daa6797f2ba8.jpg','image_b'=>'202206/07/72e8d454-185f-3109-86ba-d175c5f19e52.jpg']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_website_pro_h5_body}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

