<?php

use yii\db\Migration;

class m231118_000434_diandi_mall_account_order extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_mall_account_order}}', [
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
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
        
        /* 索引设置 */
        $this->createIndex('memberc_id','{{%diandi_mall_account_order}}','memberc_id',0);
        $this->createIndex('member_id','{{%diandi_mall_account_order}}','member_id',0);
        
        
        /* 表数据 */
        $this->insert('{{%diandi_mall_account_order}}',['id'=>'1','status'=>'1','memberc_id'=>'0','member_id'=>'4','member_level'=>NULL,'memberc_level'=>'0','is_count'=>'1','type'=>'4','performance'=>'0.00','order_goods_id'=>'20','order_type'=>'1','goods_type'=>'2','store_order_id'=>NULL,'order_id'=>'18','order_price'=>'12.00','goods_id'=>'5','goods_price'=>'12.00','money'=>'0.00','is_refund'=>'0','account_log_id'=>'0','update_time'=>'1659007414','create_time'=>'1659007414']);
        $this->insert('{{%diandi_mall_account_order}}',['id'=>'2','status'=>'1','memberc_id'=>'0','member_id'=>'15','member_level'=>NULL,'memberc_level'=>'0','is_count'=>'1','type'=>'4','performance'=>'0.00','order_goods_id'=>'103','order_type'=>'1','goods_type'=>'2','store_order_id'=>NULL,'order_id'=>'101','order_price'=>'4990.00','goods_id'=>'5','goods_price'=>'499.00','money'=>'0.00','is_refund'=>'0','account_log_id'=>'0','update_time'=>'1659260476','create_time'=>'1659260476']);
        $this->insert('{{%diandi_mall_account_order}}',['id'=>'3','status'=>'1','memberc_id'=>'0','member_id'=>'4','member_level'=>NULL,'memberc_level'=>'0','is_count'=>'1','type'=>'4','performance'=>'0.00','order_goods_id'=>'111','order_type'=>'1','goods_type'=>'2','store_order_id'=>NULL,'order_id'=>'109','order_price'=>'1596.00','goods_id'=>'4','goods_price'=>'399.00','money'=>'0.00','is_refund'=>'0','account_log_id'=>'0','update_time'=>'1659529720','create_time'=>'1659529720']);
        $this->insert('{{%diandi_mall_account_order}}',['id'=>'4','status'=>'1','memberc_id'=>'0','member_id'=>'15','member_level'=>NULL,'memberc_level'=>'0','is_count'=>'1','type'=>'4','performance'=>'0.00','order_goods_id'=>'155','order_type'=>'2','goods_type'=>'2','store_order_id'=>NULL,'order_id'=>'153','order_price'=>'11970.00','goods_id'=>'4','goods_price'=>'399.00','money'=>'0.00','is_refund'=>'0','account_log_id'=>'0','update_time'=>'1661356729','create_time'=>'1661356729']);
        $this->insert('{{%diandi_mall_account_order}}',['id'=>'5','status'=>'1','memberc_id'=>'0','member_id'=>'15','member_level'=>NULL,'memberc_level'=>'0','is_count'=>'1','type'=>'4','performance'=>'0.00','order_goods_id'=>'156','order_type'=>'1','goods_type'=>'2','store_order_id'=>NULL,'order_id'=>'154','order_price'=>'4788.00','goods_id'=>'4','goods_price'=>'399.00','money'=>'0.00','is_refund'=>'0','account_log_id'=>'0','update_time'=>'1664156969','create_time'=>'1664156969']);
        $this->insert('{{%diandi_mall_account_order}}',['id'=>'6','status'=>'1','memberc_id'=>'0','member_id'=>'4','member_level'=>NULL,'memberc_level'=>'0','is_count'=>'1','type'=>'4','performance'=>'0.00','order_goods_id'=>'157','order_type'=>'1','goods_type'=>'2','store_order_id'=>NULL,'order_id'=>'155','order_price'=>'798.00','goods_id'=>'4','goods_price'=>'399.00','money'=>'0.00','is_refund'=>'0','account_log_id'=>'0','update_time'=>'1664527547','create_time'=>'1664527547']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_mall_account_order}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

