<?php

use yii\db\Migration;

class m231104_123105_diandi_tea_coupon_buy_list extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_tea_coupon_buy_list}}', [
            'id' => "int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '人脸招聘'",
            'bloc_id' => "int(11) NOT NULL COMMENT '人脸库组id'",
            'store_id' => "int(11) NOT NULL",
            'create_time' => "datetime NULL",
            'update_time' => "datetime NULL",
            'member_id' => "int(11) NULL COMMENT '会员id'",
            'coupon_id' => "int(11) NULL COMMENT '卡券id'",
            'price' => "decimal(10,2) NULL COMMENT '价格'",
            'coupon_name' => "varchar(255) NULL COMMENT '卡券名'",
            'coupon_type' => "smallint(6) NULL COMMENT '卡券类型  1：代金券 2：时常卡  3：次卡 4：折扣券 5：体验券'",
            'transaction_id' => "varchar(100) NULL COMMENT '微信订单编号'",
            'order_number' => "varchar(100) NULL COMMENT '订单编号'",
            'pay_time' => "datetime NULL COMMENT '购买时间'",
            'pay_type' => "smallint(6) NULL COMMENT '支付方式：1.现金支付 2.余额支付'",
            'status' => "smallint(6) NULL COMMENT '订单状态：1.待付款 2.已完成 '",
            'balance' => "decimal(10,2) NULL COMMENT '余额'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='卡券购买记录表'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_tea_coupon_buy_list}}',['id'=>'115','bloc_id'=>'91','store_id'=>'153','create_time'=>'2022-06-08 22:25:07','update_time'=>'2022-06-08 22:25:07','member_id'=>'11618','coupon_id'=>'5','price'=>'1.00','coupon_name'=>'体验','coupon_type'=>'5','transaction_id'=>NULL,'order_number'=>'K2022060851101515','pay_time'=>NULL,'pay_type'=>NULL,'status'=>'1','balance'=>NULL]);
        $this->insert('{{%diandi_tea_coupon_buy_list}}',['id'=>'116','bloc_id'=>'91','store_id'=>'153','create_time'=>'2022-06-09 11:00:11','update_time'=>'2022-06-09 11:00:11','member_id'=>'11301','coupon_id'=>'5','price'=>'1.00','coupon_name'=>'体验','coupon_type'=>'5','transaction_id'=>NULL,'order_number'=>'K2022060998529848','pay_time'=>NULL,'pay_type'=>NULL,'status'=>'1','balance'=>NULL]);
        $this->insert('{{%diandi_tea_coupon_buy_list}}',['id'=>'117','bloc_id'=>'91','store_id'=>'153','create_time'=>'2022-06-09 11:00:24','update_time'=>'2022-06-09 11:00:24','member_id'=>'11301','coupon_id'=>'5','price'=>'1.00','coupon_name'=>'体验','coupon_type'=>'5','transaction_id'=>'4200001426202206099932473378','order_number'=>'K2022060956101575','pay_time'=>'2022-06-09 11:01:13','pay_type'=>'1','status'=>'2','balance'=>'0.00']);
        $this->insert('{{%diandi_tea_coupon_buy_list}}',['id'=>'118','bloc_id'=>'91','store_id'=>'153','create_time'=>'2022-06-09 11:33:17','update_time'=>'2022-06-09 11:33:17','member_id'=>'4949','coupon_id'=>'5','price'=>'0.01','coupon_name'=>'体验','coupon_type'=>'5','transaction_id'=>'4200001531202206090411046103','order_number'=>'K2022060910010050','pay_time'=>'2022-06-09 11:33:26','pay_type'=>'1','status'=>'2','balance'=>'0.00']);
        $this->insert('{{%diandi_tea_coupon_buy_list}}',['id'=>'120','bloc_id'=>'91','store_id'=>'153','create_time'=>'2022-06-10 23:55:21','update_time'=>'2022-06-10 23:55:21','member_id'=>'11640','coupon_id'=>'5','price'=>'10.00','coupon_name'=>'体验券','coupon_type'=>'5','transaction_id'=>NULL,'order_number'=>'K2022061057555350','pay_time'=>NULL,'pay_type'=>NULL,'status'=>'1','balance'=>NULL]);
        $this->insert('{{%diandi_tea_coupon_buy_list}}',['id'=>'121','bloc_id'=>'91','store_id'=>'153','create_time'=>'2022-06-12 14:07:45','update_time'=>'2022-06-12 14:07:45','member_id'=>'11645','coupon_id'=>'5','price'=>'10.00','coupon_name'=>'体验券','coupon_type'=>'5','transaction_id'=>NULL,'order_number'=>'K2022061249494952','pay_time'=>NULL,'pay_type'=>NULL,'status'=>'1','balance'=>NULL]);
        $this->insert('{{%diandi_tea_coupon_buy_list}}',['id'=>'122','bloc_id'=>'91','store_id'=>'153','create_time'=>'2023-10-31 20:18:03','update_time'=>'2023-10-31 20:18:03','member_id'=>'5','coupon_id'=>'5','price'=>'10.00','coupon_name'=>'体验券','coupon_type'=>'5','transaction_id'=>NULL,'order_number'=>'K2023103198975250','pay_time'=>NULL,'pay_type'=>NULL,'status'=>'1','balance'=>NULL]);
        $this->insert('{{%diandi_tea_coupon_buy_list}}',['id'=>'123','bloc_id'=>'91','store_id'=>'153','create_time'=>'2023-10-31 21:03:41','update_time'=>'2023-10-31 21:03:41','member_id'=>'16','coupon_id'=>'5','price'=>'10.00','coupon_name'=>'体验券','coupon_type'=>'5','transaction_id'=>NULL,'order_number'=>'K2023103110057529','pay_time'=>NULL,'pay_type'=>NULL,'status'=>'1','balance'=>NULL]);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_tea_coupon_buy_list}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

