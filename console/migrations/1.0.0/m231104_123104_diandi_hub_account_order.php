<?php

use yii\db\Migration;

class m231104_123104_diandi_hub_account_order extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_hub_account_order}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'status' => "int(11) NULL",
            'memberc_id' => "int(11) NULL COMMENT '受益人id'",
            'member_id' => "int(11) NULL COMMENT '会员id'",
            'member_level' => "int(11) NULL",
            'memberc_level' => "int(11) NULL",
            'is_count' => "int(11) NULL COMMENT '是否是汇总订单0汇总1分订单'",
            'type' => "int(11) NULL COMMENT '分佣类型0分销佣金1等级佣金2团队佣金3区域经理佣金'",
            'performance' => "decimal(11,2) NULL COMMENT '礼包业绩'",
            'order_goods_id' => "int(11) NULL COMMENT '商品与订单数据id'",
            'order_type' => "int(11) NULL COMMENT '订单类型'",
            'goods_type' => "int(11) NULL COMMENT '商品类型'",
            'store_order_id' => "int(11) NULL COMMENT '到店订单ID'",
            'order_id' => "int(11) NULL COMMENT '订单id'",
            'order_price' => "decimal(10,2) NULL COMMENT '订单价格'",
            'goods_id' => "int(11) NULL COMMENT '商品id'",
            'goods_price' => "decimal(10,2) NULL COMMENT '商品价格'",
            'money' => "decimal(11,2) NULL COMMENT '佣金总额'",
            'is_refund' => "int(11) NULL DEFAULT '0' COMMENT '是否退款'",
            'account_log_id' => "int(11) NULL",
            'update_time' => "int(11) NULL COMMENT '创建时间'",
            'create_time' => "int(11) NULL COMMENT '更新时间'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=FIXED");
        
        /* 索引设置 */
        $this->createIndex('memberc_id','{{%diandi_hub_account_order}}','memberc_id',0);
        $this->createIndex('member_id','{{%diandi_hub_account_order}}','member_id',0);
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_hub_account_order}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

