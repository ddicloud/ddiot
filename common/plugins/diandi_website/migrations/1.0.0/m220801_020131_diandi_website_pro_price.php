<?php

use yii\db\Migration;

class m220801_020131_diandi_website_pro_price extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_website_pro_price}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'create_time' => "varchar(30) NULL",
            'update_time' => "varchar(30) NULL",
            'title' => "varchar(100) NULL COMMENT '标题'",
            'describe' => "varchar(255) NULL COMMENT '描述'",
            'price' => "decimal(10,2) NULL COMMENT '价格'",
            'link' => "varchar(255) NULL COMMENT '链接地址'",
            'sort' => "int(11) NULL COMMENT '排序'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='产品价格体系'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_website_pro_price}}',['id'=>'17','store_id'=>'61','bloc_id'=>'8','create_time'=>'2022-06-07 14:54:45','update_time'=>'2022-06-07 14:59:28','title'=>'biaoti1','describe'=>'miasoshu ','price'=>NULL,'link'=>NULL,'sort'=>NULL]);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_website_pro_price}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

