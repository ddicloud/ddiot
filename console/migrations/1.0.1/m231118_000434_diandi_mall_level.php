<?php

use yii\db\Migration;

class m231118_000434_diandi_mall_level extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_mall_level}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'bloc_id' => "int(11) NULL COMMENT '公司ID'",
            'store_id' => "int(11) NULL COMMENT '商户ID'",
            'levelname' => "varchar(100) NOT NULL COMMENT '等级名称'",
            'levelnum' => "int(11) NOT NULL COMMENT '等级'",
            'total_num' => "int(11) NULL COMMENT '团队等级总人数'",
            'total_sale' => "int(11) NULL COMMENT '团队等级总销售额'",
            'condition' => "varchar(255) NULL COMMENT '条件汇总'",
            'water_ratio' => "decimal(11,3) NULL COMMENT '店铺流水分红'",
            'level2_num' => "int(11) NULL COMMENT '分销二级份'",
            'level1_num' => "int(11) NULL COMMENT '分销一级人数'",
            'level1_sale' => "int(11) NULL COMMENT '分销一级销售额'",
            'level2_sale' => "int(11) NULL COMMENT '分销二级销售额'",
            'self_sale' => "int(11) NULL COMMENT '自己消费'",
            'create_time' => "int(11) NULL COMMENT '创建时间'",
            'update_time' => "int(11) NULL COMMENT '更新时间'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
        
        /* 索引设置 */
        $this->createIndex('levelnum','{{%diandi_mall_level}}','levelnum',1);
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_mall_level}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

