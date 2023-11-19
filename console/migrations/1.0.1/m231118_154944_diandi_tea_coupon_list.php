<?php

use yii\db\Migration;

class m231118_154944_diandi_tea_coupon_list extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_tea_coupon_list}}', [
            'id' => "int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '卡券消费记录id'",
            'bloc_id' => "int(11) NOT NULL COMMENT '人脸库组id'",
            'store_id' => "int(11) NOT NULL",
            'create_time' => "datetime NULL",
            'update_time' => "datetime NULL",
            'member_id' => "int(11) NULL COMMENT '会员id'",
            'coupon_name' => "varchar(100) NOT NULL COMMENT '卡券名称'",
            'coupon_type' => "smallint(6) NULL COMMENT '卡券类型  1：代金券 2：时常卡  3：次卡 4：折扣券 5：体验券'",
            'coupon_id' => "int(11) NULL COMMENT '卡券id'",
            'order_id' => "int(11) NULL COMMENT '订单id'",
            'price' => "decimal(10,0) NULL COMMENT '卡券价格'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='卡券消费记录表'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_tea_coupon_list}}',['id'=>'2','bloc_id'=>'91','store_id'=>'153','create_time'=>'2022-03-22 18:07:37','update_time'=>'2022-03-22 18:07:40','member_id'=>'1','coupon_name'=>'dfdsfds','coupon_type'=>'1','coupon_id'=>'1','order_id'=>'1','price'=>'11']);
        $this->insert('{{%diandi_tea_coupon_list}}',['id'=>'5','bloc_id'=>'91','store_id'=>'153','create_time'=>'2022-04-07 19:21:22','update_time'=>'2022-04-07 19:21:22','member_id'=>'4691','coupon_name'=>'体验','coupon_type'=>'2','coupon_id'=>'5','order_id'=>'46','price'=>'100']);
        $this->insert('{{%diandi_tea_coupon_list}}',['id'=>'6','bloc_id'=>'91','store_id'=>'153','create_time'=>'2022-04-07 19:37:19','update_time'=>'2022-04-07 19:37:19','member_id'=>'4691','coupon_name'=>'体验','coupon_type'=>'3','coupon_id'=>'5','order_id'=>'47','price'=>'100']);
        $this->insert('{{%diandi_tea_coupon_list}}',['id'=>'7','bloc_id'=>'91','store_id'=>'153','create_time'=>'2022-04-08 09:13:50','update_time'=>'2022-04-08 09:13:50','member_id'=>'4691','coupon_name'=>'体验','coupon_type'=>'4','coupon_id'=>'5','order_id'=>'49','price'=>'100']);
        $this->insert('{{%diandi_tea_coupon_list}}',['id'=>'12','bloc_id'=>'91','store_id'=>'153','create_time'=>'2022-05-31 15:31:02','update_time'=>'2022-05-31 15:31:02','member_id'=>'11301','coupon_name'=>'体验','coupon_type'=>'5','coupon_id'=>'5','order_id'=>'327','price'=>'1']);
        $this->insert('{{%diandi_tea_coupon_list}}',['id'=>'13','bloc_id'=>'91','store_id'=>'153','create_time'=>'2022-06-01 14:47:02','update_time'=>'2022-06-01 14:47:02','member_id'=>'11296','coupon_name'=>'体验','coupon_type'=>'5','coupon_id'=>'5','order_id'=>'343','price'=>'1']);
        $this->insert('{{%diandi_tea_coupon_list}}',['id'=>'15','bloc_id'=>'91','store_id'=>'153','create_time'=>'2022-06-01 14:53:57','update_time'=>'2022-06-01 14:53:57','member_id'=>'4949','coupon_name'=>'体验','coupon_type'=>'5','coupon_id'=>'5','order_id'=>'345','price'=>'1']);
        $this->insert('{{%diandi_tea_coupon_list}}',['id'=>'16','bloc_id'=>'91','store_id'=>'153','create_time'=>'2022-06-01 15:03:59','update_time'=>'2022-06-01 15:03:59','member_id'=>'11296','coupon_name'=>'体验','coupon_type'=>'5','coupon_id'=>'5','order_id'=>'346','price'=>'1']);
        $this->insert('{{%diandi_tea_coupon_list}}',['id'=>'17','bloc_id'=>'91','store_id'=>'153','create_time'=>'2022-06-01 15:08:48','update_time'=>'2022-06-01 15:08:48','member_id'=>'11296','coupon_name'=>'体验','coupon_type'=>'5','coupon_id'=>'5','order_id'=>'347','price'=>'1']);
        $this->insert('{{%diandi_tea_coupon_list}}',['id'=>'18','bloc_id'=>'91','store_id'=>'153','create_time'=>'2022-06-01 15:13:55','update_time'=>'2022-06-01 15:13:55','member_id'=>'11296','coupon_name'=>'体验','coupon_type'=>'5','coupon_id'=>'5','order_id'=>'348','price'=>'1']);
        $this->insert('{{%diandi_tea_coupon_list}}',['id'=>'19','bloc_id'=>'91','store_id'=>'153','create_time'=>'2022-06-01 15:43:49','update_time'=>'2022-06-01 15:43:49','member_id'=>'4949','coupon_name'=>'体验','coupon_type'=>'5','coupon_id'=>'5','order_id'=>'349','price'=>'1']);
        $this->insert('{{%diandi_tea_coupon_list}}',['id'=>'22','bloc_id'=>'91','store_id'=>'153','create_time'=>'2022-06-01 17:42:47','update_time'=>'2022-06-01 17:42:47','member_id'=>'11614','coupon_name'=>'体验','coupon_type'=>'5','coupon_id'=>'5','order_id'=>'363','price'=>'1']);
        $this->insert('{{%diandi_tea_coupon_list}}',['id'=>'23','bloc_id'=>'91','store_id'=>'153','create_time'=>'2022-06-01 17:59:48','update_time'=>'2022-06-01 17:59:48','member_id'=>'11302','coupon_name'=>'体验','coupon_type'=>'5','coupon_id'=>'5','order_id'=>'370','price'=>'1']);
        $this->insert('{{%diandi_tea_coupon_list}}',['id'=>'24','bloc_id'=>'91','store_id'=>'153','create_time'=>'2022-06-01 18:13:59','update_time'=>'2022-06-01 18:13:59','member_id'=>'11302','coupon_name'=>'体验','coupon_type'=>'5','coupon_id'=>'5','order_id'=>'371','price'=>'1']);
        $this->insert('{{%diandi_tea_coupon_list}}',['id'=>'26','bloc_id'=>'91','store_id'=>'153','create_time'=>'2022-06-05 11:38:43','update_time'=>'2022-06-05 11:38:43','member_id'=>'4949','coupon_name'=>'体验','coupon_type'=>'5','coupon_id'=>'5','order_id'=>'440','price'=>'1']);
        $this->insert('{{%diandi_tea_coupon_list}}',['id'=>'27','bloc_id'=>'91','store_id'=>'153','create_time'=>'2022-06-05 15:12:07','update_time'=>'2022-06-05 15:12:07','member_id'=>'11623','coupon_name'=>'体验','coupon_type'=>'5','coupon_id'=>'5','order_id'=>'441','price'=>'1']);
        $this->insert('{{%diandi_tea_coupon_list}}',['id'=>'34','bloc_id'=>'91','store_id'=>'153','create_time'=>'2022-06-09 11:07:40','update_time'=>'2022-06-09 11:07:40','member_id'=>'11301','coupon_name'=>'体验','coupon_type'=>'5','coupon_id'=>'5','order_id'=>'476','price'=>'1']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_tea_coupon_list}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

