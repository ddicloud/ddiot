<?php

use yii\db\Migration;

class m231118_154944_diandi_mall_goods extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_mall_goods}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'bloc_id' => "int(11) NULL COMMENT '公司ID'",
            'store_id' => "int(11) NULL COMMENT '商户ID'",
            'goods_id' => "int(11) NULL COMMENT '商品ID'",
            'goods_name' => "varchar(100) NULL COMMENT '商品名称'",
            'share_title' => "varchar(100) NULL COMMENT '分销标题'",
            'share_desc' => "varchar(100) NULL DEFAULT '1' COMMENT '分销描述'",
            'share_img' => "varchar(100) NULL COMMENT '分销描述'",
            'one_options' => "decimal(11,2) NULL",
            'two_options' => "decimal(11,2) NULL",
            'three_options' => "decimal(11,2) NULL",
            'type' => "smallint(6) NULL COMMENT '分销类型'",
            'create_time' => "int(11) NULL COMMENT '创建时间'",
            'update_time' => "int(11) NULL COMMENT '更新时间'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT");
        
        /* 索引设置 */
        $this->createIndex('member_id','{{%diandi_mall_goods}}','goods_id',0);
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_mall_goods}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

