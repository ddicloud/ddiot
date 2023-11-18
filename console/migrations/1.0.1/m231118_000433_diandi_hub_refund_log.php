<?php

use yii\db\Migration;

class m231118_000433_diandi_hub_refund_log extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_hub_refund_log}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'bloc_id' => "int(11) NULL",
            'store_id' => "int(11) NULL",
            'order_id' => "int(11) NULL COMMENT '订单'",
            'refund_id' => "int(11) NOT NULL COMMENT '售后订单'",
            'money' => "decimal(11,2) NOT NULL COMMENT '退款金额'",
            'old_refund_status' => "int(11) NULL COMMENT '之前的退款状态'",
            'old_status' => "int(11) NULL COMMENT '之前的售后状态'",
            'type' => "int(11) NOT NULL COMMENT '售后类型'",
            'refund_status' => "int(11) NOT NULL COMMENT '退款状态:0申请退款1退款驳回,2退款中3已退款'",
            'status' => "int(11) NULL COMMENT '售后状态:0申请1拒绝售后2处理中3已处理4已完结'",
            'remark' => "varchar(100) NOT NULL COMMENT '处理意见'",
            'member_id' => "int(11) NOT NULL COMMENT '申请人'",
            'refund_username' => "varchar(30) NULL COMMENT '处理人'",
            'user_remark' => "varchar(100) NULL COMMENT '用户对处理的反馈'",
            'create_time' => "int(11) NULL",
            'update_time' => "int(11) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_hub_refund_log}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

