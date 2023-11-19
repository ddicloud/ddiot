<?php

use yii\db\Migration;

class m231118_154944_diandi_tea_order_list extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_tea_order_list}}', [
            'id' => "int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '包间订单id'",
            'bloc_id' => "int(11) NOT NULL COMMENT '人脸库组id'",
            'store_id' => "int(11) NOT NULL",
            'create_time' => "datetime NULL",
            'update_time' => "datetime NULL",
            'start_time' => "datetime NULL COMMENT '开始时间'",
            'end_time' => "datetime NULL COMMENT '结束时间'",
            'member_id' => "int(11) NULL COMMENT '会员id'",
            'coupon_id' => "int(11) NULL COMMENT '使用卡券id'",
            'balance' => "decimal(10,2) NULL COMMENT '余额'",
            'amount_payable' => "decimal(10,2) NULL COMMENT '应付金额'",
            'discount' => "decimal(10,2) NULL COMMENT '优惠金额'",
            'real_pay' => "decimal(10,2) NULL COMMENT '实付金额'",
            'order_number' => "varchar(100) NULL COMMENT '订单编号'",
            'pay_type' => "smallint(6) NULL COMMENT '支付方式：1.现金支付 2.余额支付'",
            'status' => "smallint(6) NULL COMMENT '订单状态：1.待付款 2.支付成功 3.已完成 4.已取消'",
            'hourse_id' => "int(11) NULL COMMENT '包间id'",
            'is_use' => "smallint(6) NULL COMMENT '是否正在使用 ：1.未使用  2.使用中  3.已使用 4.已过期'",
            'order_type' => "smallint(6) NULL COMMENT '订单类型 1.包间订单  2.续费订单'",
            'set_meal_id' => "int(11) NULL COMMENT '使用套餐id'",
            'set_meal_name' => "varchar(255) NULL COMMENT '使用套餐名'",
            'renew_order_id' => "int(11) NULL COMMENT '续费订单id'",
            'transaction_id' => "varchar(100) NULL COMMENT '微信订单编号'",
            'pay_time' => "datetime NULL COMMENT '支付时间'",
            'renew_price' => "decimal(10,2) NULL COMMENT '半小时续费单价'",
            'renew_num' => "smallint(6) NULL COMMENT '续费单位个数'",
            'pwd' => "int(11) NULL COMMENT '开锁密码'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='包间订单列表'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_tea_order_list}}',['id'=>'1','bloc_id'=>'91','store_id'=>'153','create_time'=>'2023-11-17 15:55:26','update_time'=>'2023-11-17 15:55:26','start_time'=>'2023-11-17 16:00:00','end_time'=>'2023-11-17 18:00:00','member_id'=>'1','coupon_id'=>'0','balance'=>NULL,'amount_payable'=>'156.00','discount'=>'0.00','real_pay'=>'156.00','order_number'=>'H2023111710156565','pay_type'=>NULL,'status'=>'1','hourse_id'=>'8','is_use'=>NULL,'order_type'=>'1','set_meal_id'=>'6','set_meal_name'=>'【单价88】2小时6人间套餐','renew_order_id'=>NULL,'transaction_id'=>NULL,'pay_time'=>NULL,'renew_price'=>'44.00','renew_num'=>NULL,'pwd'=>NULL]);
        $this->insert('{{%diandi_tea_order_list}}',['id'=>'2','bloc_id'=>'91','store_id'=>'153','create_time'=>'2023-11-17 15:57:22','update_time'=>'2023-11-17 15:57:22','start_time'=>'2023-11-17 16:00:00','end_time'=>'2023-11-17 20:00:00','member_id'=>'52','coupon_id'=>'0','balance'=>NULL,'amount_payable'=>'352.00','discount'=>'0.00','real_pay'=>'352.00','order_number'=>'H2023111750100495','pay_type'=>NULL,'status'=>'4','hourse_id'=>'9','is_use'=>NULL,'order_type'=>'1','set_meal_id'=>'10','set_meal_name'=>'【单价88】6个人计时套餐','renew_order_id'=>NULL,'transaction_id'=>NULL,'pay_time'=>NULL,'renew_price'=>'44.00','renew_num'=>NULL,'pwd'=>NULL]);
        $this->insert('{{%diandi_tea_order_list}}',['id'=>'3','bloc_id'=>'91','store_id'=>'153','create_time'=>'2023-11-17 16:04:06','update_time'=>'2023-11-17 16:04:06','start_time'=>'2023-11-17 16:05:00','end_time'=>'2023-11-17 18:05:00','member_id'=>'52','coupon_id'=>'0','balance'=>NULL,'amount_payable'=>'156.00','discount'=>'0.00','real_pay'=>'156.00','order_number'=>'H2023111754511015','pay_type'=>NULL,'status'=>'4','hourse_id'=>'9','is_use'=>NULL,'order_type'=>'1','set_meal_id'=>'6','set_meal_name'=>'【单价88】2小时6人间套餐','renew_order_id'=>NULL,'transaction_id'=>NULL,'pay_time'=>NULL,'renew_price'=>'44.00','renew_num'=>NULL,'pwd'=>NULL]);
        $this->insert('{{%diandi_tea_order_list}}',['id'=>'4','bloc_id'=>'91','store_id'=>'153','create_time'=>'2023-11-17 16:07:56','update_time'=>'2023-11-17 16:07:56','start_time'=>'2023-11-17 16:10:00','end_time'=>'2023-11-17 18:10:00','member_id'=>'52','coupon_id'=>'0','balance'=>NULL,'amount_payable'=>'156.00','discount'=>'0.00','real_pay'=>'156.00','order_number'=>'H2023111799485750','pay_type'=>NULL,'status'=>'4','hourse_id'=>'9','is_use'=>NULL,'order_type'=>'1','set_meal_id'=>'6','set_meal_name'=>'【单价88】2小时6人间套餐','renew_order_id'=>NULL,'transaction_id'=>NULL,'pay_time'=>NULL,'renew_price'=>'44.00','renew_num'=>NULL,'pwd'=>NULL]);
        $this->insert('{{%diandi_tea_order_list}}',['id'=>'5','bloc_id'=>'91','store_id'=>'153','create_time'=>'2023-11-17 16:17:17','update_time'=>'2023-11-17 16:17:17','start_time'=>'2023-11-17 16:20:00','end_time'=>'2023-11-17 18:20:00','member_id'=>'52','coupon_id'=>'0','balance'=>NULL,'amount_payable'=>'156.00','discount'=>'0.00','real_pay'=>'156.00','order_number'=>'H2023111710010098','pay_type'=>NULL,'status'=>'4','hourse_id'=>'9','is_use'=>NULL,'order_type'=>'1','set_meal_id'=>'6','set_meal_name'=>'【单价88】2小时6人间套餐','renew_order_id'=>NULL,'transaction_id'=>NULL,'pay_time'=>NULL,'renew_price'=>'44.00','renew_num'=>NULL,'pwd'=>NULL]);
        $this->insert('{{%diandi_tea_order_list}}',['id'=>'6','bloc_id'=>'91','store_id'=>'153','create_time'=>'2023-11-17 16:17:59','update_time'=>'2023-11-17 16:17:59','start_time'=>'2023-11-17 16:20:00','end_time'=>'2023-11-17 18:20:00','member_id'=>'52','coupon_id'=>'0','balance'=>NULL,'amount_payable'=>'156.00','discount'=>'0.00','real_pay'=>'156.00','order_number'=>'H2023111755515049','pay_type'=>NULL,'status'=>'4','hourse_id'=>'9','is_use'=>NULL,'order_type'=>'1','set_meal_id'=>'6','set_meal_name'=>'【单价88】2小时6人间套餐','renew_order_id'=>NULL,'transaction_id'=>NULL,'pay_time'=>NULL,'renew_price'=>'44.00','renew_num'=>NULL,'pwd'=>NULL]);
        $this->insert('{{%diandi_tea_order_list}}',['id'=>'7','bloc_id'=>'91','store_id'=>'153','create_time'=>'2023-11-17 16:25:15','update_time'=>'2023-11-17 16:25:15','start_time'=>'2023-11-17 16:30:00','end_time'=>'2023-11-17 18:30:00','member_id'=>'1','coupon_id'=>'0','balance'=>NULL,'amount_payable'=>'196.00','discount'=>'0.00','real_pay'=>'196.00','order_number'=>'H2023111798565249','pay_type'=>NULL,'status'=>'1','hourse_id'=>'5','is_use'=>NULL,'order_type'=>'1','set_meal_id'=>'7','set_meal_name'=>'【单价108】2小时12人间套餐','renew_order_id'=>NULL,'transaction_id'=>NULL,'pay_time'=>NULL,'renew_price'=>'54.00','renew_num'=>NULL,'pwd'=>NULL]);
        $this->insert('{{%diandi_tea_order_list}}',['id'=>'8','bloc_id'=>'91','store_id'=>'153','create_time'=>'2023-11-17 16:32:33','update_time'=>'2023-11-17 16:32:33','start_time'=>'2023-11-17 16:35:00','end_time'=>'2023-11-17 18:35:00','member_id'=>'52','coupon_id'=>'0','balance'=>NULL,'amount_payable'=>'96.00','discount'=>'0.00','real_pay'=>'96.00','order_number'=>'H2023111749565598','pay_type'=>NULL,'status'=>'1','hourse_id'=>'7','is_use'=>NULL,'order_type'=>'1','set_meal_id'=>'3','set_meal_name'=>'【单价58】2小时4人间套餐','renew_order_id'=>NULL,'transaction_id'=>NULL,'pay_time'=>NULL,'renew_price'=>'29.00','renew_num'=>NULL,'pwd'=>NULL]);
        $this->insert('{{%diandi_tea_order_list}}',['id'=>'9','bloc_id'=>'91','store_id'=>'153','create_time'=>'2023-11-17 16:41:34','update_time'=>'2023-11-17 16:41:34','start_time'=>'2023-11-17 16:45:00','end_time'=>'2023-11-17 18:45:00','member_id'=>'52','coupon_id'=>'0','balance'=>NULL,'amount_payable'=>'156.00','discount'=>'0.00','real_pay'=>'156.00','order_number'=>'H2023111710110053','pay_type'=>NULL,'status'=>'1','hourse_id'=>'9','is_use'=>NULL,'order_type'=>'1','set_meal_id'=>'6','set_meal_name'=>'【单价88】2小时6人间套餐','renew_order_id'=>NULL,'transaction_id'=>NULL,'pay_time'=>NULL,'renew_price'=>'44.00','renew_num'=>NULL,'pwd'=>NULL]);
        $this->insert('{{%diandi_tea_order_list}}',['id'=>'10','bloc_id'=>'91','store_id'=>'153','create_time'=>'2023-11-18 01:23:38','update_time'=>'2023-11-18 01:23:38','start_time'=>'2023-11-18 01:25:00','end_time'=>'2023-11-18 03:25:00','member_id'=>'52','coupon_id'=>'0','balance'=>NULL,'amount_payable'=>'156.00','discount'=>'0.00','real_pay'=>'156.00','order_number'=>'H2023111897509857','pay_type'=>NULL,'status'=>'1','hourse_id'=>'9','is_use'=>NULL,'order_type'=>'1','set_meal_id'=>'6','set_meal_name'=>'【单价88】2小时6人间套餐','renew_order_id'=>NULL,'transaction_id'=>NULL,'pay_time'=>NULL,'renew_price'=>'44.00','renew_num'=>NULL,'pwd'=>NULL]);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_tea_order_list}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

