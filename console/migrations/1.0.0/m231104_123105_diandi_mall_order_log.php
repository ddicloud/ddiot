<?php

use yii\db\Migration;

class m231104_123105_diandi_mall_order_log extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_mall_order_log}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'bloc_id' => "int(11) NULL COMMENT '公司id'",
            'store_id' => "int(11) NULL COMMENT '商户id'",
            'member_id' => "int(11) NULL COMMENT '会员id'",
            'member_pid1_level' => "int(11) NULL COMMENT '一级会员等级'",
            'member_pid2_level' => "int(11) NULL COMMENT '二级会员等级'",
            'member_pid3_level' => "int(11) NULL COMMENT '三级会员等级'",
            'member_pid3' => "int(11) NULL COMMENT '三级会员id'",
            'member_pid2' => "int(11) NULL COMMENT '二级会员id'",
            'member_pid1' => "int(11) NULL COMMENT '一级会员id'",
            'group_member_pid1_level' => "int(11) NULL COMMENT '一级分销商等级'",
            'group_member_pid2_level' => "int(11) NULL COMMENT '二级分销商等级'",
            'group_member_pid3_level' => "int(11) NULL COMMENT '三级分销商等级'",
            'group_member_pid3' => "int(11) NULL COMMENT '三级分销商id'",
            'group_member_pid2' => "int(11) NULL COMMENT '二级分销商id'",
            'group_member_pid1' => "int(11) NULL COMMENT '一级分销商id'",
            'order_id' => "int(11) NULL COMMENT '订单id'",
            'goods_id' => "int(11) NULL COMMENT '商品id'",
            'goods_spec_id' => "int(11) NULL COMMENT '规格id'",
            'goods_spec_price' => "decimal(10,2) NULL COMMENT '规格价格'",
            'tota_price' => "decimal(10,2) NULL",
            'memberprice' => "decimal(11,2) NULL COMMENT '会员价格'",
            'goods_price' => "decimal(10,2) NULL",
            'group_id' => "int(11) NULL COMMENT '分销商等级'",
            'level_id' => "int(11) NULL COMMENT '会员等级'",
            'type' => "varchar(30) NULL DEFAULT '比例' COMMENT '分销方式'",
            'money' => "decimal(11,2) NULL COMMENT '分销参数'",
            'refund_money' => "decimal(11,2) NULL COMMENT '退款金额'",
            'order_status' => "int(255) NULL COMMENT '订单状态'",
            'money_status' => "varchar(30) NULL COMMENT '资金状态'",
            'refundstatus' => "int(11) NULL COMMENT '退款状态'",
            'price1' => "decimal(11,2) NULL COMMENT '价格1'",
            'price2' => "decimal(11,2) NULL COMMENT '价格2'",
            'price3' => "decimal(11,2) NULL COMMENT '价格3'",
            'price4' => "decimal(11,2) NULL COMMENT '价格4'",
            'price5' => "decimal(11,2) NULL COMMENT '价格5'",
            'price6' => "decimal(11,2) NULL COMMENT '价格6'",
            'update_time' => "int(11) NULL COMMENT '更新时间'",
            'create_time' => "int(11) NULL COMMENT '创建时间'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='价格字段说明'");
        
        /* 索引设置 */
        $this->createIndex('member_id','{{%diandi_mall_order_log}}','goods_spec_id',0);
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_mall_order_log}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

