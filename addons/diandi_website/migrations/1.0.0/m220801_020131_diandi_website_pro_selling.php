<?php

use yii\db\Migration;

class m220801_020131_diandi_website_pro_selling extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_website_pro_selling}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'create_time' => "varchar(30) NULL",
            'update_time' => "varchar(30) NULL",
            'image' => "varchar(255) NULL COMMENT '静止图片'",
            'title' => "varchar(100) NULL COMMENT '标题'",
            'content' => "varchar(255) NULL COMMENT '内容'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='核心卖点'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_website_pro_selling}}',['id'=>'17','store_id'=>'61','bloc_id'=>'8','create_time'=>'2022-06-07 15:05:28','update_time'=>'2022-06-07 15:07:52','image'=>'202206/07/f42b037d-859f-39ca-b046-707735a23bb7.jpg','title'=>'标题1','content'=>'12']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_website_pro_selling}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

