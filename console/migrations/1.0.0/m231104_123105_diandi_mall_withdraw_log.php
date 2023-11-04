<?php

use yii\db\Migration;

class m231104_123105_diandi_mall_withdraw_log extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_mall_withdraw_log}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'partner_trade_no' => "varchar(30) NULL COMMENT '付款商户单号'",
            'money' => "decimal(11,2) NOT NULL COMMENT '到账金额'",
            'money_count' => "decimal(11,2) NULL COMMENT '申请金额'",
            'withdraw_type' => "int(11) NULL COMMENT '提现类型'",
            'withdraw_status' => "int(11) NULL COMMENT '提现状态'",
            'member_id' => "int(11) NULL COMMENT '用户id'",
            'pay_status' => "int(11) NULL",
            'pay_type' => "int(11) NULL COMMENT '支付方式'",
            'confirm_name' => "varchar(30) NULL COMMENT '确认人'",
            'openid' => "varchar(30) NULL COMMENT 'OPENID'",
            're_user_name' => "varchar(30) NULL COMMENT '真实姓名'",
            'desc' => "varchar(255) NULL COMMENT '付款说明'",
            'ymd_time' => "int(11) NOT NULL COMMENT '申请时间ymd'",
            'service_charge' => "decimal(11,2) NULL COMMENT '手续费'",
            'create_time' => "int(11) NULL COMMENT '申请时间'",
            'update_time' => "int(11) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='申请提现日志'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_mall_withdraw_log}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

