<?php

use yii\db\Migration;

class m231104_123105_diandi_mall_account_log extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_mall_account_log}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'member_id' => "int(11) NOT NULL COMMENT '会员id'",
            'order_goods_id' => "int(11) NULL",
            'account_type' => "int(11) NULL COMMENT '资金类型'",
            'change_type' => "int(11) NULL COMMENT '资金变化类型'",
            'money' => "decimal(11,3) NULL COMMENT '资金'",
            'is_add' => "int(11) NULL DEFAULT '0' COMMENT '0增加，1减少'",
            'order_type' => "int(11) NULL COMMENT '订单类型'",
            'goods_type' => "int(11) NULL COMMENT '商品类型'",
            'order_id' => "int(11) NULL COMMENT '订单id'",
            'order_price' => "decimal(10,2) NULL COMMENT '订单价格'",
            'goods_id' => "int(11) NULL COMMENT '商品id'",
            'goods_price' => "decimal(10,2) NULL COMMENT '商品价格'",
            'performance' => "decimal(11,2) NULL COMMENT '礼包业绩'",
            'store_order_id' => "int(11) NULL COMMENT '到店订单id'",
            'remark' => "varchar(50) NULL COMMENT '备注'",
            'is_refund' => "int(11) NULL DEFAULT '0' COMMENT '是否退款'",
            'update_time' => "int(11) NULL COMMENT '创建时间'",
            'create_time' => "int(11) NULL COMMENT '更新时间'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_mall_account_log}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

