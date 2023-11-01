<?php

use yii\db\Migration;

class m220801_020131_diandi_website_pro_core extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_website_pro_core}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'create_time' => "varchar(30) NULL",
            'update_time' => "varchar(30) NULL",
            'link' => "varchar(255) NULL COMMENT '链接地址'",
            'logo' => "varchar(255) NULL COMMENT 'logo'",
            'title' => "varchar(100) NULL COMMENT '标题'",
            'describe' => "varchar(255) NULL COMMENT '描述'",
            'content' => "text NULL COMMENT '内容'",
            'solution_id' => "int(11) NOT NULL DEFAULT '0' COMMENT '案例ID'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='h5产品核心功能'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_website_pro_core}}',['id'=>'17','store_id'=>'61','bloc_id'=>'8','create_time'=>'2022-06-07 14:54:45','update_time'=>'2022-06-07 14:59:28','link'=>'http://localhost:9527/pro-admin/#/diandi_website/product/corefunction/create.vue','logo'=>'202206/07/2c909e82-90b7-3e12-9a07-1475564fd902.jpg','title'=>'biaoti1','describe'=>'miasoshu ','content'=>'1q1','solution_id'=>'0']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_website_pro_core}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

