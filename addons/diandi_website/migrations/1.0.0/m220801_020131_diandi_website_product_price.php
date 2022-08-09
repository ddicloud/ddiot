<?php

use yii\db\Migration;

class m220801_020131_diandi_website_product_price extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_website_product_price}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID'",
            'bloc_id' => "int(11) NOT NULL",
            'store_id' => "int(11) NOT NULL",
            'solution_id' => "tinyint(2) NOT NULL DEFAULT '0' COMMENT '解决案例ID'",
            'name' => "varchar(45) NOT NULL COMMENT '产品名称'",
            'des' => "varchar(450) NOT NULL COMMENT '产品描述'",
            'price' => "decimal(10,2) NOT NULL COMMENT '产品价格'",
            'show_price' => "varchar(45) NOT NULL COMMENT '展示价格'",
            'drift' => "tinyint(4) NOT NULL DEFAULT '1' COMMENT '价格浮动'",
            'fun' => "text NOT NULL COMMENT '产品功能'",
            'back_color' => "varchar(45) NOT NULL COMMENT '背景色'",
            'is_recommend' => "tinyint(2) NOT NULL DEFAULT '-1' COMMENT '是否推荐'",
            'created_at' => "datetime NOT NULL COMMENT '创建时间'",
            'updated_at' => "datetime NOT NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='产品价格'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_website_product_price}}',['id'=>'1','bloc_id'=>'8','store_id'=>'61','solution_id'=>'1','name'=>'名称','des'=>'12','price'=>'32.00','show_price'=>'12','drift'=>'2','fun'=>'121222222','back_color'=>'#931515','is_recommend'=>'1','created_at'=>'2022-07-11 14:58:20','updated_at'=>'2022-07-11 15:02:26']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_website_product_price}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

