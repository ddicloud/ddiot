<?php

use yii\db\Migration;

class m231104_123105_diandi_mall_refund_order extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_mall_refund_order}}', [
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
            'order_status' => "int(11) NOT NULL COMMENT '订单状态'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_mall_refund_order}}',['id'=>'1','bloc_id'=>'13','store_id'=>'62','order_id'=>'6','reason_id'=>'1','transaction_id'=>'','refund_code'=>'Ref2022072698481005','money'=>'23.00','type'=>'1','refund_status'=>'3','status'=>'3','remark'=>'2323','member_id'=>'1','thumbs'=>'202207/26/4d357308-fc25-359e-8681-f8478e4fa512.png,202207/26/cb85e624-494e-31b3-a8f0-546b15da8f47.png','linkman'=>'12','mobile'=>'13829389283','goods_id'=>'智能门锁','create_time'=>'1658806363','update_time'=>'1658808198','order_status'=>'0']);
        $this->insert('{{%diandi_mall_refund_order}}',['id'=>'2','bloc_id'=>'13','store_id'=>'62','order_id'=>'9','reason_id'=>'1','transaction_id'=>'','refund_code'=>'Ref2022072610298504','money'=>'12.00','type'=>'1','refund_status'=>'3','status'=>'3','remark'=>'12','member_id'=>'1','thumbs'=>'202207/26/2df32cfd-b9d5-3a25-a212-2953fead8fdb.png,202207/26/67370ad7-0c95-3471-bad8-2f29fb04d92d.png','linkman'=>'姚','mobile'=>'13829389283','goods_id'=>'店滴云商业授权','create_time'=>'1658816975','update_time'=>'1658817004','order_status'=>'0']);
        $this->insert('{{%diandi_mall_refund_order}}',['id'=>'3','bloc_id'=>'13','store_id'=>'62','order_id'=>'10','reason_id'=>'1','transaction_id'=>'','refund_code'=>'Ref2022072610197485','money'=>'10.00','type'=>'1','refund_status'=>'3','status'=>'4','remark'=>'1212','member_id'=>'1','thumbs'=>'202207/26/4c14cf14-b629-3185-9f69-f9fca33423f5.png,202207/26/5bea0483-f8b5-36b4-8c08-f58d88f2122f.png','linkman'=>'姚','mobile'=>'12839829382','goods_id'=>'店滴云商业授权','create_time'=>'1658817550','update_time'=>'1658819586','order_status'=>'0']);
        $this->insert('{{%diandi_mall_refund_order}}',['id'=>'4','bloc_id'=>'13','store_id'=>'62','order_id'=>'11','reason_id'=>'1','transaction_id'=>'','refund_code'=>'Ref2022072655569898','money'=>'10.00','type'=>'1','refund_status'=>'4','status'=>'4','remark'=>'121212','member_id'=>'2','thumbs'=>'202207/26/f2ce4935-b91b-3dbd-bc0a-5d4cc3775235.png,202207/26/acc4ccd2-6414-3cdb-9479-f2902c80bec6.png','linkman'=>'姚111','mobile'=>'13892839829','goods_id'=>'5','create_time'=>'1658819687','update_time'=>'1658822972','order_status'=>'0']);
        $this->insert('{{%diandi_mall_refund_order}}',['id'=>'5','bloc_id'=>'13','store_id'=>'62','order_id'=>'13','reason_id'=>'1','transaction_id'=>'','refund_code'=>'Ref2022072656100100','money'=>'1.00','type'=>'0','refund_status'=>'0','status'=>'4','remark'=>'1212','member_id'=>'2','thumbs'=>'202207/26/fb1c2f84-fdb9-3ceb-b8cd-62c5104ee224.png,202207/26/0d5f9b2d-4576-3640-bcdb-ecaa0bb4c10a.png','linkman'=>'姚12','mobile'=>'13892839892','goods_id'=>'1','create_time'=>'1658824680','update_time'=>'1658830490','order_status'=>'0']);
        $this->insert('{{%diandi_mall_refund_order}}',['id'=>'6','bloc_id'=>'13','store_id'=>'62','order_id'=>'14','reason_id'=>'1','transaction_id'=>'','refund_code'=>'Ref2022072610255495','money'=>'1.00','type'=>'0','refund_status'=>'0','status'=>'4','remark'=>'1212','member_id'=>'2','thumbs'=>'202207/26/d62da5f1-c388-3648-8f0a-1ec7ffb0244f.png,202207/26/da847f55-22e1-3eeb-93c0-96969bb50618.png','linkman'=>'1','mobile'=>'13892738982','goods_id'=>'1','create_time'=>'1658830655','update_time'=>'1658830705','order_status'=>'0']);
        $this->insert('{{%diandi_mall_refund_order}}',['id'=>'7','bloc_id'=>'13','store_id'=>'62','order_id'=>'15','reason_id'=>'1','transaction_id'=>'','refund_code'=>'Ref2022072657551025','money'=>'1.00','type'=>'0','refund_status'=>'0','status'=>'4','remark'=>'12','member_id'=>'2','thumbs'=>'202207/26/1a6c8c40-8700-3c90-a5b3-1d86bc8150bf.png,202207/26/eeeb3daf-2a57-3fe9-8ab5-da7e93a0cd98.png','linkman'=>'姚333','mobile'=>'13892839823','goods_id'=>'1','create_time'=>'1658831977','update_time'=>'1658832264','order_status'=>'10']);
        $this->insert('{{%diandi_mall_refund_order}}',['id'=>'8','bloc_id'=>'13','store_id'=>'62','order_id'=>'16','reason_id'=>'1','transaction_id'=>'','refund_code'=>'Ref2022072654505053','money'=>'1.00','type'=>'0','refund_status'=>'0','status'=>'4','remark'=>'12','member_id'=>'2','thumbs'=>'202207/26/a75afdef-5274-3f70-990a-473ff1684b85.png,202207/26/1dbadaf9-ecf5-3966-8345-770a2c3a5f09.png','linkman'=>'姚333','mobile'=>'13892893892','goods_id'=>'1','create_time'=>'1658832454','update_time'=>'1658832459','order_status'=>'0']);
        $this->insert('{{%diandi_mall_refund_order}}',['id'=>'10','bloc_id'=>'13','store_id'=>'62','order_id'=>'17','reason_id'=>'1','transaction_id'=>'','refund_code'=>'Ref2022072655504856','money'=>'1.00','type'=>'0','refund_status'=>'0','status'=>'4','remark'=>'1','member_id'=>'2','thumbs'=>'202207/26/bf77ed84-59e4-30a4-861d-63aac1324d07.png,202207/26/3cfab9b1-f161-3012-b05b-15624fdccdab.png','linkman'=>'问24','mobile'=>'12839289283','goods_id'=>'5','create_time'=>'1658833063','update_time'=>'1658833076','order_status'=>'1']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_mall_refund_order}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

