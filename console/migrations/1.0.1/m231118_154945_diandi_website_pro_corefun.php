<?php

use yii\db\Migration;

class m231118_154945_diandi_website_pro_corefun extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_website_pro_corefun}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'create_time' => "varchar(30) NULL",
            'update_time' => "varchar(30) NULL",
            'logo' => "varchar(255) NULL COMMENT 'logo'",
            'title' => "varchar(100) NULL COMMENT '标题'",
            'describe' => "varchar(255) NULL COMMENT '描述'",
            'sort' => "int(11) NULL COMMENT '排序'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_website_pro_corefun}}',['id'=>'17','store_id'=>'61','bloc_id'=>'8','create_time'=>'2022-06-07 14:54:45','update_time'=>'2022-06-07 14:59:28','logo'=>'202206/07/2c909e82-90b7-3e12-9a07-1475564fd902.jpg','title'=>'biaoti1','describe'=>'miasoshu ','sort'=>NULL]);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_website_pro_corefun}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

