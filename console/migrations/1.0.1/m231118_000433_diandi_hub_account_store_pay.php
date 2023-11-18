<?php

use yii\db\Migration;

class m231118_000433_diandi_hub_account_store_pay extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_hub_account_store_pay}}', [
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
        $this->insert('{{%diandi_hub_account_store_pay}}',['id'=>'1','store_id'=>'82','bloc_id'=>'33','member_store_id'=>'1','order_no'=>'123','member_id'=>'123','operation_mid'=>'15','money'=>'2135.00','remark'=>'sfsd','pay_type'=>'1','status'=>'1','affirm_mid'=>'15','affirm_name'=>'dsfds','transaction_id'=>'123153','store_radio'=>'1351.00','store_money'=>'153.00','qrcode_time'=>'21531','pay_time'=>'135123','is_rebate'=>'1','is_money'=>'1','confirm_time'=>'15313','update_time'=>'135132','create_time'=>'153123']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_hub_account_store_pay}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

