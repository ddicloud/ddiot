<?php

use yii\db\Migration;

class m231104_123105_diandi_tea_order_list extends Migration
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
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='包间订单列表'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_tea_order_list}}',['id'=>'498','bloc_id'=>'91','store_id'=>'153','create_time'=>'2023-10-31 16:49:32','update_time'=>'2023-10-31 16:49:32','start_time'=>'2023-10-31 16:50:00','end_time'=>'2023-10-31 18:50:00','member_id'=>'1','coupon_id'=>'0','balance'=>NULL,'amount_payable'=>'196.00','discount'=>'0.00','real_pay'=>'196.00','order_number'=>'H2023103199569953','pay_type'=>NULL,'status'=>'4','hourse_id'=>'5','is_use'=>NULL,'order_type'=>'1','set_meal_id'=>'7','set_meal_name'=>'【单价108】2小时12人间套餐','renew_order_id'=>NULL,'transaction_id'=>NULL,'pay_time'=>NULL,'renew_price'=>'54.00','renew_num'=>NULL,'pwd'=>NULL]);
        $this->insert('{{%diandi_tea_order_list}}',['id'=>'499','bloc_id'=>'91','store_id'=>'153','create_time'=>'2023-10-31 16:53:27','update_time'=>'2023-10-31 16:53:27','start_time'=>'2023-10-31 16:55:00','end_time'=>'2023-10-31 18:55:00','member_id'=>'1','coupon_id'=>'0','balance'=>NULL,'amount_payable'=>'196.00','discount'=>'0.00','real_pay'=>'196.00','order_number'=>'H2023103155544950','pay_type'=>NULL,'status'=>'4','hourse_id'=>'5','is_use'=>NULL,'order_type'=>'1','set_meal_id'=>'7','set_meal_name'=>'【单价108】2小时12人间套餐','renew_order_id'=>NULL,'transaction_id'=>NULL,'pay_time'=>NULL,'renew_price'=>'54.00','renew_num'=>NULL,'pwd'=>NULL]);
        $this->insert('{{%diandi_tea_order_list}}',['id'=>'500','bloc_id'=>'91','store_id'=>'153','create_time'=>'2023-10-31 16:53:53','update_time'=>'2023-10-31 16:53:53','start_time'=>'2023-10-31 16:55:00','end_time'=>'2023-10-31 18:55:00','member_id'=>'1','coupon_id'=>'0','balance'=>NULL,'amount_payable'=>'196.00','discount'=>'0.00','real_pay'=>'196.00','order_number'=>'H2023103149484998','pay_type'=>NULL,'status'=>'1','hourse_id'=>'5','is_use'=>NULL,'order_type'=>'1','set_meal_id'=>'7','set_meal_name'=>'【单价108】2小时12人间套餐','renew_order_id'=>NULL,'transaction_id'=>NULL,'pay_time'=>NULL,'renew_price'=>'54.00','renew_num'=>NULL,'pwd'=>NULL]);
        $this->insert('{{%diandi_tea_order_list}}',['id'=>'501','bloc_id'=>'91','store_id'=>'153','create_time'=>'2023-10-31 16:56:17','update_time'=>'2023-10-31 16:56:17','start_time'=>'2023-10-31 19:00:00','end_time'=>'2023-10-31 20:00:00','member_id'=>'1','coupon_id'=>'0','balance'=>NULL,'amount_payable'=>'108.00','discount'=>'0.00','real_pay'=>'108.00','order_number'=>'H2023103149100541','pay_type'=>NULL,'status'=>'1','hourse_id'=>'5','is_use'=>NULL,'order_type'=>'1','set_meal_id'=>'11','set_meal_name'=>'【单价108】12个人计时套餐','renew_order_id'=>NULL,'transaction_id'=>NULL,'pay_time'=>NULL,'renew_price'=>'54.00','renew_num'=>NULL,'pwd'=>NULL]);
        $this->insert('{{%diandi_tea_order_list}}',['id'=>'502','bloc_id'=>'91','store_id'=>'153','create_time'=>'2023-10-31 20:47:15','update_time'=>'2023-10-31 20:47:15','start_time'=>'2023-10-31 20:50:00','end_time'=>'2023-11-01 00:50:00','member_id'=>'14','coupon_id'=>'0','balance'=>NULL,'amount_payable'=>'204.00','discount'=>'0.00','real_pay'=>'204.00','order_number'=>'H2023103151974951','pay_type'=>NULL,'status'=>'1','hourse_id'=>'10','is_use'=>NULL,'order_type'=>'1','set_meal_id'=>'14','set_meal_name'=>'【单价68】4小时4人间套餐','renew_order_id'=>NULL,'transaction_id'=>NULL,'pay_time'=>NULL,'renew_price'=>'34.00','renew_num'=>NULL,'pwd'=>NULL]);
        $this->insert('{{%diandi_tea_order_list}}',['id'=>'503','bloc_id'=>'91','store_id'=>'153','create_time'=>'2023-10-31 21:02:45','update_time'=>'2023-10-31 21:02:45','start_time'=>'2023-10-31 21:05:00','end_time'=>'2023-11-01 01:05:00','member_id'=>'1','coupon_id'=>'0','balance'=>NULL,'amount_payable'=>'432.00','discount'=>'0.00','real_pay'=>'432.00','order_number'=>'H2023103153565753','pay_type'=>NULL,'status'=>'1','hourse_id'=>'5','is_use'=>NULL,'order_type'=>'1','set_meal_id'=>'11','set_meal_name'=>'【单价108】12个人计时套餐','renew_order_id'=>NULL,'transaction_id'=>NULL,'pay_time'=>NULL,'renew_price'=>'54.00','renew_num'=>NULL,'pwd'=>NULL]);
        $this->insert('{{%diandi_tea_order_list}}',['id'=>'504','bloc_id'=>'91','store_id'=>'153','create_time'=>'2023-11-02 01:34:32','update_time'=>'2023-11-02 01:34:32','start_time'=>'2023-11-02 01:35:00','end_time'=>'2023-11-02 03:35:00','member_id'=>'1','coupon_id'=>'0','balance'=>NULL,'amount_payable'=>'196.00','discount'=>'0.00','real_pay'=>'196.00','order_number'=>'H2023110256569810','pay_type'=>NULL,'status'=>'1','hourse_id'=>'5','is_use'=>NULL,'order_type'=>'1','set_meal_id'=>'7','set_meal_name'=>'【单价108】2小时12人间套餐','renew_order_id'=>NULL,'transaction_id'=>NULL,'pay_time'=>NULL,'renew_price'=>'54.00','renew_num'=>NULL,'pwd'=>NULL]);
        $this->insert('{{%diandi_tea_order_list}}',['id'=>'505','bloc_id'=>'91','store_id'=>'153','create_time'=>'2023-11-03 08:38:59','update_time'=>'2023-11-03 08:38:59','start_time'=>'2023-11-03 08:40:00','end_time'=>'2023-11-03 12:40:00','member_id'=>'9','coupon_id'=>'0','balance'=>NULL,'amount_payable'=>'264.00','discount'=>'0.00','real_pay'=>'264.00','order_number'=>'H2023110351495257','pay_type'=>NULL,'status'=>'1','hourse_id'=>'8','is_use'=>NULL,'order_type'=>'1','set_meal_id'=>'8','set_meal_name'=>'【单价88】4小时6人间套餐','renew_order_id'=>NULL,'transaction_id'=>NULL,'pay_time'=>NULL,'renew_price'=>'44.00','renew_num'=>NULL,'pwd'=>NULL]);
        
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

