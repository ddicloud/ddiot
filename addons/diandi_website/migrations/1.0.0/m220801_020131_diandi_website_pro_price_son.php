<?php

use yii\db\Migration;

class m220801_020131_diandi_website_pro_price_son extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_website_pro_price_son}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'create_time' => "varchar(30) NULL",
            'update_time' => "varchar(30) NULL",
            'title' => "varchar(100) NULL COMMENT '标题'",
            'is_have' => "tinyint(3) NULL COMMENT '是否包含该功能1.有2.无'",
            'sort' => "int(11) NULL COMMENT '排序'",
            'price_id' => "int(11) NULL COMMENT '关联价格体系id'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='产品价格体系功能点'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_website_pro_price_son}}',['id'=>'17','store_id'=>'61','bloc_id'=>'8','create_time'=>'2022-06-07 14:54:45','update_time'=>'2022-06-07 14:59:28','title'=>'biaoti1','is_have'=>'0','sort'=>NULL,'price_id'=>NULL]);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_website_pro_price_son}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

