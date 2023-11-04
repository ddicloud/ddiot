<?php

use yii\db\Migration;

class m231104_123105_pay_refund_log extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%pay_refund_log}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'return_code' => "varchar(50) NULL",
            'out_refund_no' => "varchar(50) NULL COMMENT '商户退款单号'",
            'out_trade_no' => "varchar(50) NULL COMMENT '商户订单号 '",
            'refund_account' => "varchar(50) NULL COMMENT '退款资金来源'",
            'refund_fee' => "decimal(11,2) NULL COMMENT '申请退款金额 '",
            'refund_id' => "varchar(50) NULL COMMENT '微信退款单号'",
            'refund_recv_accout' => "decimal(11,2) NOT NULL COMMENT '支付用户零钱'",
            'refund_request_source' => "varchar(255) NULL COMMENT '退款发起来源'",
            'refund_status' => "varchar(255) NULL COMMENT '退款状态'",
            'module' => "varchar(50) NULL COMMENT '模块标识'",
            'settlement_refund_fee' => "varchar(255) NULL COMMENT '退款金额 '",
            'settlement_total_fee' => "decimal(11,2) NOT NULL COMMENT '应结订单金额'",
            'success_time' => "varchar(100) NULL COMMENT '退款成功时间'",
            'total_fee' => "decimal(11,2) NOT NULL COMMENT '订单金额 '",
            'transaction_id' => "varchar(50) NULL COMMENT '微信订单号'",
            'member_id' => "int(11) NULL COMMENT '用户id'",
            'create_time' => "int(11) NULL COMMENT '创建时间'",
            'update_time' => "int(11) NULL COMMENT '更新时间'",
            'bloc_id' => "int(11) NULL COMMENT '公司ID'",
            'store_id' => "int(11) NULL COMMENT '商户ID'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='退款通知日志'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%pay_refund_log}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

