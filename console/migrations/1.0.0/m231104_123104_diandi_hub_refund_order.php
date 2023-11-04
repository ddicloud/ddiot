<?php

use yii\db\Migration;

class m231104_123104_diandi_hub_refund_order extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_hub_refund_order}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'bloc_id' => "int(11) NULL",
            'store_id' => "int(11) NULL",
            'order_id' => "int(11) NULL COMMENT '订单'",
            'reason_id' => "int(11) NOT NULL COMMENT '售后理由'",
            'transaction_id' => "varchar(30) NULL COMMENT '微信支付单号'",
            'refund_code' => "varchar(30) NULL COMMENT '退款单号'",
            'money' => "decimal(11,2) NOT NULL COMMENT '退款金额'",
            'type' => "int(11) NOT NULL COMMENT '售后类型'",
            'refund_status' => "int(11) NOT NULL COMMENT '退款状态:0申请退款1退款驳回,2退款中3已退款'",
            'status' => "int(11) NULL COMMENT '售后状态:0申请1拒绝售后2处理中3已处理4已完结'",
            'remark' => "varchar(100) NOT NULL COMMENT '退款理由'",
            'member_id' => "int(11) NOT NULL COMMENT '申请人'",
            'thumbs' => "text NULL COMMENT '图片说明'",
            'linkman' => "varchar(30) NOT NULL COMMENT '联系人'",
            'mobile' => "varchar(30) NOT NULL COMMENT '联系电话'",
            'goods_id' => "text NULL COMMENT '商品id'",
            'create_time' => "int(11) NULL",
            'update_time' => "int(11) NULL",
            'order_status' => "int(11) NULL COMMENT '订单状态'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_hub_refund_order}}',['id'=>'1','bloc_id'=>'33','store_id'=>'82','order_id'=>'35','reason_id'=>'54','transaction_id'=>'216532151','refund_code'=>'21545','money'=>'212.00','type'=>'2','refund_status'=>'2','status'=>'1','remark'=>'ssfds','member_id'=>'1','thumbs'=>'5135132','linkman'=>'13215','mobile'=>'15313515322','goods_id'=>'4','create_time'=>'153135','update_time'=>'1650957842','order_status'=>NULL]);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_hub_refund_order}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

