<?php

use yii\db\Migration;

class m231118_000434_diandi_mall_account_store_pay extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_mall_account_store_pay}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'member_store_id' => "int(11) NULL",
            'order_no' => "varchar(30) NULL COMMENT '订单编号'",
            'member_id' => "int(11) NULL COMMENT '会员id'",
            'operation_mid' => "int(11) NULL COMMENT '发起人'",
            'money' => "decimal(11,2) NULL COMMENT '付款金额'",
            'remark' => "varchar(255) NULL COMMENT '付款备注'",
            'pay_type' => "int(11) NULL COMMENT '支付方式'",
            'status' => "int(11) NULL COMMENT '付款状态'",
            'affirm_mid' => "int(11) NULL COMMENT '确认人'",
            'affirm_name' => "varchar(50) NULL COMMENT '确认客服名字'",
            'transaction_id' => "varchar(50) NULL COMMENT '微信支付单号'",
            'store_radio' => "decimal(11,2) NULL COMMENT '店铺折扣'",
            'store_money' => "decimal(11,2) NULL COMMENT '店铺结算资金'",
            'qrcode_time' => "int(11) NOT NULL COMMENT '扫码时间'",
            'pay_time' => "int(11) NOT NULL COMMENT '支付时间'",
            'is_rebate' => "int(11) NULL DEFAULT '0' COMMENT '是否补贴完成'",
            'is_money' => "int(11) NULL DEFAULT '0' COMMENT '是否解冻资金'",
            'confirm_time' => "int(11) NOT NULL COMMENT '确认时间'",
            'update_time' => "int(11) NULL COMMENT '创建时间'",
            'create_time' => "int(11) NULL COMMENT '更新时间'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_mall_account_store_pay}}',['id'=>'1','store_id'=>'62','bloc_id'=>'13','member_store_id'=>'62','order_no'=>'S2022071349539956','member_id'=>'2','operation_mid'=>NULL,'money'=>'100.00','remark'=>'1','pay_type'=>NULL,'status'=>'0','affirm_mid'=>'0','affirm_name'=>NULL,'transaction_id'=>'','store_radio'=>NULL,'store_money'=>'0.00','qrcode_time'=>'0','pay_time'=>'0','is_rebate'=>'0','is_money'=>'0','confirm_time'=>'0','update_time'=>'1657697201','create_time'=>'1657697201']);
        $this->insert('{{%diandi_mall_account_store_pay}}',['id'=>'2','store_id'=>'62','bloc_id'=>'13','member_store_id'=>'62','order_no'=>'S2022071349984898','member_id'=>'2','operation_mid'=>NULL,'money'=>'100.00','remark'=>'1','pay_type'=>NULL,'status'=>'0','affirm_mid'=>'0','affirm_name'=>NULL,'transaction_id'=>'','store_radio'=>NULL,'store_money'=>'0.00','qrcode_time'=>'0','pay_time'=>'0','is_rebate'=>'0','is_money'=>'0','confirm_time'=>'0','update_time'=>'1657697201','create_time'=>'1657697201']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_mall_account_store_pay}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

